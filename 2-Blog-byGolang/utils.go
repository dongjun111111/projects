package main

import (
	"os"
	"time"
)

func writeResult(vals []string, outfile string) error {
	_, err := os.Open(outfile)
	if err != nil && os.IsNotExist(err) {
		_, err := os.Create(outfile)
		if err != nil {
			panic(err)
		}
	}
	f, err := os.OpenFile(outfile, os.O_APPEND, 0644)
	if err != nil {
		panic(err)
	}
	defer f.Close()

	for _, v := range vals {
		v = time.Now().Format("2006-01-02 15:04:05") + "   " + v
		f.WriteString(v)
		f.WriteString("\r\n")
	}
	return err
}
