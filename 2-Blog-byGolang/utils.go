package main

import (
	"encoding/json"
	"fmt"
	"io/ioutil"
	"net"
	"net/http"
	"net/smtp"
	"os"
	"path/filepath"
	"regexp"
	"runtime"
	"strconv"
	"strings"
	"time"
)

const (
	MAXLOGFILES  = 7
	MAILUSERNAME = "Jason's little lovely assistant"
	MAILUSER     = "903456967@qq.com"
	//qq邮箱服务器
	//MAILPASSWORD = "smtp授权密码"
	//MAILHOST = "smtp.qq.com:587"
	//163邮箱服务器
	//MAILPASSWORD ="登录密码"
	//MAILHOST = "smtp.163.com:25"
	RANGEDURATION = 15 * time.Minute
)

func sendMail(username, user, password, host, to, subject, body, mailtype string) error {
	hp := strings.Split(host, ":")
	auth := smtp.PlainAuth("", user, password, hp[0])
	var content_type string
	if mailtype == "html" {
		content_type = "Content-Type: text/" + mailtype + "; charset=UTF-8"
	} else {
		content_type = "Content-Type: text/plain" + "; charset=UTF-8"
	}
	msg := []byte("To: " + to + "\r\nFrom: " + username + "<" + user + ">\r\nSubject: " + subject + "\r\n" + content_type + "\r\n" + body + "\r\n REPLY-TO: " + user)
	send_to := strings.Split(to, ";")
	err := smtp.SendMail(host, auth, user, send_to, msg)
	return err
}

func getAddr() string { //get ip
	conn, err := net.Dial("udp", "baidu.com:80")
	if err != nil {
		fmt.Println(err.Error())
		return "Erorr"
	}
	defer conn.Close()
	return strings.Split(conn.LocalAddr().String(), ":")[0]
}
func getMac() string { // get local connection infos
	interfaces, err := net.Interfaces()
	if err != nil {
		return " ; 网络连接信息获取失败！"
	}
	var macs string
	for _, inter := range interfaces {
		mac := inter.HardwareAddr
		addrs, _ := inter.Addrs()
		if strings.Contains(inter.Name, "本地") || strings.Contains(inter.Name, "eth0") || strings.EqualFold(inter.Name, "Local") {
			macs = " ; 网络连接Name: " + inter.Name + " ; 网络连接Addr: " + fmt.Sprintf("%s", addrs) + "  ; MAC: " + fmt.Sprintf("%s", mac)
			break
		}
		macs = " ; 网络连接Name: " + inter.Name + " ; 网络连接Addr: " + fmt.Sprintf("%s", addrs) + "  ; MAC: " + fmt.Sprintf("%s", mac)
	}
	return macs
}

func toString(v interface{}) string {
	data, _ := json.Marshal(v)
	return string(data)
}

func readFile(path string) string {
	fi, err := os.Open(path)
	if err != nil {
		panic(err)
	}
	defer fi.Close()
	fd, err := ioutil.ReadAll(fi)
	result := string(fd)
	result = strings.Replace(result, "Time:", "<br><font color=red>Time</font>:", -1)
	return result
}

func Exist(filename string) bool {
	_, err := os.Stat(filename)
	return err == nil || os.IsExist(err)
}

func checkSliceBInA(a []string, b []string) (isIn bool) {
	lengthA := len(a)
	var diffSlice []string
	for _, valueB := range b {
		temp := valueB
		for j := 0; j < lengthA; j++ {
			if temp == a[j] { //如果相同 比较下一个
				break
			} else {
				if lengthA == (j + 1) { //如果不同 查看a的元素个数及当前比较元素的位置 将不同的元素添加到返回slice中
					diffSlice = append(diffSlice, temp)
				}
			}
		}
	}
	if len(diffSlice) == 0 {
		isIn = true
	} else {
		isIn = false
	}
	return isIn
}

func writeLogToFile(vals []string, outfile string) error {
	today := time.Now().Format("2006-01-02")
	if strings.Contains(outfile, today) {
		_, err := os.Open(outfile)
		if err != nil && os.IsNotExist(err) {
			_, err := os.Create(outfile)
			if err != nil {
				panic(err)
			}

		}
	} else {
		panic("data error!")
	}

	f, err := os.OpenFile(outfile, os.O_APPEND, 0644)
	if err != nil {
		panic(err)
	}
	defer f.Close()

	for _, v := range vals {
		v = "Time: " + time.Now().Format("2006-01-02 15:04:05") + "   " + v
		f.WriteString(v)
		f.WriteString("\r\n")
	}
	return err
}

func checkLog(logname string) {
	var i int
	var pathslice []string
	filepath.Walk("log", func(path string, info os.FileInfo, err error) error {
		if !info.IsDir() && filepath.Ext(path) == ".log" && strings.Contains(path, logname) {
			i++
			pathslice = append(pathslice, path)
		}
		return err
	})
	if i > MAXLOGFILES {
		delpathslice := pathslice[:len(pathslice)-MAXLOGFILES]

		t1 := time.Now()
		//将要发送邮件的内容
		currenttime := time.Now().Format("2006-01-02 15:04:05")
		var subject string
		var maincontent string
		var body string
		var removeresult bool
		var counts int
		counts = 0
		for i := 0; i < len(delpathslice); i++ {
			counts += strings.Count(readFile(delpathslice[i]), "Time")
			maincontent += `<p>文件` + strconv.Itoa((i + 1)) + `：<font color=red>` + delpathslice[i] + `</font></p>
            <p>内容：` + readFile(delpathslice[i]) + `</p><br><hr>`
			err := os.RemoveAll(delpathslice[i])
			if err != nil || Exist(delpathslice[i]) {
				removeresult = false
			} else {
				removeresult = true
				println(delpathslice[i], "--->删除成功")
			}
		}
		if removeresult {
			subject = "Redundant log files deleted successfully"
			body = `
            <html>
            <body>
            <h3>
            日志文件删除通知!
            </h3>
            <p>以下共` + strconv.Itoa(len(delpathslice)) + `个文件已被删除，主要页面共计被访问` + strconv.Itoa(counts) + `次：</p><hr>
            ` + maincontent + `
            <p>` + currenttime + ` - by system</p>
            </body>
            </html>
            `
		} else {
			subject = "Warning！Log files delete failed！！！"
			body = `
			<html>
			<body>
				<h3><font color=red>日志文件删除失败</font></h3>
				<p>请尽快登录后台排查问题，以防影响服务器正常工作！</p><hr>
				<p>` + currenttime + ` - by system</p>
			</body>
			</html>
			`
		}
		t2 := time.Now()

		println("sending email......")
		err1 := sendMail(MAILUSERNAME, MAILUSER, MAILPASSWORD, MAILHOST, MAILTO, subject, body, "html")
		if err1 != nil {
			println("sended mail error!")
			today := time.Now().Format("2006-01-02")
			MailErrorLogfile := "log/" + today + "mailerrorlog.log"
			writeLogToFile([]string{" - 邮件发送失败，请检查邮件账号信息！"}, MailErrorLogfile)
		} else {
			println("sended mail success!")
			fmt.Printf("删除文件总用时： %v\n", t2.Sub(t1))
		}
		var m runtime.MemStats
		runtime.ReadMemStats(&m)
		fmt.Printf("程序向应用程序申请的内存:%d,堆上目前分配的内存:%d,堆上目前没有使用的内存:%d,回收到操作系统的内存:%d\n", m.HeapSys, m.HeapAlloc, m.HeapIdle, m.HeapReleased)
		runtime.GC()
	}
}

//getLastedPwd
func getLastedPwd() {
	ticker := time.NewTicker(RANGEDURATION)
	var newslice_a []string
	var newslice_b []string
	var tempslice []string
	var subject string
	var bodycontent string
	var maincontent string
	var baseint int = 0
	for {
		if time.Now().Hour() >= 8 {
			if baseint >= 2147483645 {
				baseint = 0
			}
			select {
			case <-ticker.C:
				//小管家自动查房
				if baseint != 0 && baseint%8 == 0 {
					client := &http.Client{}
					req, _ := http.NewRequest("GET", "http://localhost:2333/", nil)
					req.Header.Add("User-Agent", "小管家自动查房")
					client.Do(req)
				}
				baseint++
				//获取最新密码
				resp, _ := http.Get("http://www.ishadowsocks.org/")
				if resp.StatusCode == 200 {
					body, err := ioutil.ReadAll(resp.Body)
					if err != nil {
						panic(err)
					}
					reg := regexp.MustCompile(`<h4>[A-Z]密码:.*?</h4>`)
					// regexp.MustCompile(`<h4>[A-Z]服务器地址:.*?</h4>`)
					// regexp.MustCompile(`<h4>端口:.*?</h4>`)
					tempslice = reg.FindAllString(string(body), -1)
					if newslice_a == nil {
						newslice_a = tempslice
					} else {
						newslice_b = tempslice
					}
				} else {
					newslice_a = []string{"访问网站出错", "访问网站出错", "访问网站出错"}
					newslice_a = newslice_b
				}
				if baseint == 0 {
					newslice_b = tempslice
				}
				defer resp.Body.Close()

				if newslice_a != nil && newslice_b != nil {
					if !checkSliceBInA(newslice_a, newslice_b) {
						maincontent = "<font color=red>已过期密码</font>：" + newslice_a[1] + "<font color=green>本次可用密码</font>：" + newslice_b[1]
						newslice_a = nil
						newslice_b = nil
						tempslice = nil
					} else {
						maincontent = "<font color=green>正常使用</font>：" + tempslice[1]
					}
				}
				currenttime := time.Now().Format("2006-01-02 15:04:05")
				subject = "A notification of checking the password"
				bodycontent = `
            <html>
            <body>
                <h3>已成功帮您检测到了最新的密码！</h3>
                <p>` + maincontent + `</p><hr>
                <p>` + currenttime + ` - by system</p>
            </body>
            </html>
            `
			}
			err1 := sendMail(MAILUSERNAME, MAILUSER, MAILPASSWORD, MAILHOST, MAILTO, subject, bodycontent, "html")
			if err1 != nil {
				println("sended mail error!")
			}
		}
	}
}

//以下是获取最新微信金融领域最新文章
func Get(url string) (content string, statusCode int) {
	resp, err1 := http.Get(url)
	if err1 != nil {
		statusCode = -100
		return
	}
	defer resp.Body.Close()
	data, err2 := ioutil.ReadAll(resp.Body)
	if err2 != nil {
		statusCode = -200
		return
	}
	statusCode = resp.StatusCode
	content = string(data)
	return
}

func findIndex(content string) (index []string, err error) {
	ptnIndexItem := regexp.MustCompile(`<a class="question_link" href="/n/(\d)*`)
	matches := ptnIndexItem.FindAllString(content, -1)
	for i := 0; i < len(matches); i++ {
		matches[i] = "http://chuansong.me" + strings.Replace(matches[i], `<a class="question_link" href="`, ``, -1)
	}
	return matches, nil
}

func getLastedWeiXinFinanceArticles() string {
	resp, statusCode := Get("http://chuansong.me/finance")
	if statusCode != 200 {
		panic("状态错误")
	}
	index, _ := findIndex(resp)
	var itemall string
	for k, item := range index {
		item = "<a href='" + item + "'>" + strconv.Itoa(k+1) + "、" + item + "</a><br>"
		itemall += item
	}
	return itemall
}
