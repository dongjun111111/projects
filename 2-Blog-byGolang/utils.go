package main

import (
	"fmt"
	"io/ioutil"
	"net/smtp"
	"os"
	"path/filepath"
	"strconv"
	"strings"
	"time"
)

const (
	MAXLOGFILES = 7
)

func sendMail(user, password, host, to, subject, body, mailtype string) error {
	hp := strings.Split(host, ":")
	auth := smtp.PlainAuth("", user, password, hp[0])
	var content_type string
	if mailtype == "html" {
		content_type = "Content-Type: text/" + mailtype + "; charset=UTF-8;"
	} else {
		content_type = "Content-Type: text/plain" + "; charset=UTF-8;"
	}

	msg := []byte("To: " + to + "\r\nFrom: " + user + "<" + user + ">\r\nSubject: " + subject + "\r\n" + content_type + "\r\n" + body)
	send_to := strings.Split(to, ";")
	err := smtp.SendMail(host, auth, user, send_to, msg)
	return err
}

func readFile(path string) string {
	fi, err := os.Open(path)
	if err != nil {
		panic(err)
	}
	defer fi.Close()
	fd, err := ioutil.ReadAll(fi)
	return string(fd)
}

func checkFile(filename string) bool {
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
		user := "user@qq.com"
		//qq邮箱服务器
		password := "不是邮箱登录密码，而是SMTP授权码"
		host := "smtp.qq.com:587"
		to := "email@163.com"
		//163邮箱服务器
		//password := "邮箱密码"
		//host := "smtp.163.com:25"
		var subject string
		var maincontent string
		var body string
		var removeresult bool
		for i := 0; i < len(delpathslice); i++ {
			maincontent += `<p><font color=red>文件` + strconv.Itoa((i + 1)) + `：` + delpathslice[i] + `</font></p>
            <p>内容：` + readFile(delpathslice[i]) + `</p><br><hr>`
			err := os.RemoveAll(delpathslice[i])
			if err != nil || checkFile(delpathslice[i]) {
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
            <p>以下共` + strconv.Itoa(len(delpathslice)) + `个文件已被删除：</p><hr>
            ` + maincontent + `
            <p>` + currenttime + ` - by system</p>
            </body>
            </html>
            `
		} else {
			subject = "博客冗余日志文件删除失败通知！！！"
			body = `
            <html>
            <body>
                <h3><font color=red>日志文件删除失败</font></h3>
                <p>请尽快登录后台排查问题，以防影响服务器正常工作！</p>
                <p>` + currenttime + ` - by system</p>
            </body>
            </html>
            `
		}
		t2 := time.Now()

		println("sending email......")
		err1 := sendMail(user, password, host, to, subject, body, "html")
		if err1 != nil {
			println("sended mail error!")
			today := time.Now().Format("2006-01-02")
			MailErrorLogfile := "log/" + today + "mailerrorlog.log"
			writeLogToFile([]string{" - 邮件发送失败，请检查邮件账号信息！"}, MailErrorLogfile)
		} else {
			println("sended mail success!")
			fmt.Printf("删除文件总用时： %v\n", t2.Sub(t1))
		}
	}
}
