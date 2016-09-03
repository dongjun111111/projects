package main

import (
	"bufio"
	"os"
	"strings"

	"github.com/huangml/log"
)

type Category struct {
	Name        string
	Title       string
	Description string
	Posts       []*Post
	Numbers     int
	Readmore    bool
}

var categories []*Category

func parseCategories() {
	log.Info("Parse Categories")

	f, err := os.OpenFile("conf/category.conf", os.O_RDONLY, 0777)
	log.FatalOnError(err)
	defer f.Close()

	scanner := bufio.NewScanner(f)
	for scanner.Scan() {
		sp := strings.SplitN(scanner.Text(), ":", 3)
		c := &Category{}
		if len(sp) > 0 {
			c.Name = sp[0]
		}
		if len(sp) > 1 {
			c.Title = sp[1]
		}
		if len(sp) > 2 {
			c.Description = sp[2]
		}

		categories = append(categories, c)
	}
}

func addPostToCategory(p *Post) {
	for _, c := range categories {
		if p.Category == c.Name {
			for i, _ := range c.Posts {
				c.Posts = append(c.Posts, nil)
				copy(c.Posts[i+1:], c.Posts[i:])
				c.Posts[i] = p
				return
			}
			c.Posts = append(c.Posts, p)
			//如果该分类下文章数超过6，对其进行截断处理
			// if len(c.Posts) > 6 {
			// 	c.Posts = c.Posts[:6]
			// 	c.Readmore = true
			// }
			return
		}
		c.Numbers = len(c.Posts)
		//当出现文章数小于等于0的分类时令其不显示
		// if len(c.Posts) <= 0 {
		// 	categories = append(categories[:k], categories[k+1:]...)
		// }
	}
}
