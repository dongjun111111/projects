package main

import (
	"os"
	"path/filepath"
	"strings"
	"time"
)

func writeMainLogToFile(vals []string, outfile string) error {
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
	if i > 7 {
		delpathslice := pathslice[:len(pathslice)-7]
		for i := 0; i < len(delpathslice); i++ {
			err := os.RemoveAll(delpathslice[i])
			if err != nil {
				println("delet dir error:", err)
				return
			}
			println(delpathslice[i], "--->删除成功")
		}
	}
}
