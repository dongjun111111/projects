package main

import (
	"encoding/json"
	"fmt"
	"github.com/dongjun111111/persistent_pool"
	"runtime"
	"time"
)

func main() {
	//factory 创建连接的方法
	factory := func() ([]byte, error) { return []byte("jason"), nil }
	close := func(v []byte) error { v = nil; return nil }
	//创建一个对象池 初始化1，最大30
	poolConfig := &pool.PoolConfig{
		InitialCap:     1,
		MaxCap:         30,
		Factory:        factory,
		Close:          close,
		InitialTimeout: 15 * time.Second,
	}
	pool, err := pool.NewChannelPool(poolConfig)
	if err != nil {
		fmt.Println("err=", err.Error())
	}
	runtime.GC()
	str := "55555"
	resstr, _ := json.Marshal(str)
	pool.Put(resstr)
	val1, _ := pool.Get()
	fmt.Println(string(val1))
	val2, _ := pool.Get()
	fmt.Println(string(val2))
	type Person struct {
		Name string
		Age  int
	}
	pony := &Person{Name: "pony", Age: 77}
	preput, _ := json.Marshal(pony)
	pool.Put(preput)
	val3, _ := pool.Get()
	fmt.Println(string(val3))
	fmt.Println("pool's length=", pool.Len())
}
