package main

import (
	"encoding/json"
	"fmt"
	"io/ioutil"
	"net"
	"net/smtp"
	"os"
	"path/filepath"
	"runtime"
	"strconv"
	"strings"
	"time"
)

const (
	MAXLOGFILES = 7
)

func sendMail(username, user, password, host, to, subject, body, mailtype string) error {
	hp := strings.Split(host, ":")
	auth := smtp.PlainAuth("", user, password, hp[0])
	var content_type string
	if mailtype == "html" {
		content_type = "Content-Type: text/" + mailtype + "; charset=UTF-8;"
	} else {
		content_type = "Content-Type: text/plain" + "; charset=UTF-8;"
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
		username := "博客后台小管家"
		user := "user@qq.com"
		//qq邮箱服务器
		password := "smtp授权密码"
		host := "smtp.qq.com:587"
		//163邮箱服务器
		//password :="登录密码"
		//host := "smtp.163.com:25"
		to := "to@163.com"
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
			subject = "博客冗余日志文件成功删除通知"
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
			subject = "警告！日志删除失败！！！"
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
		err1 := sendMail(username, user, password, host, to, subject, body, "html")
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
