package main

import (
	"time"

	"github.com/gorilla/feeds"
)

var recentPosts []*Post

const feedNum = 10

func addPostToFeed(p *Post) {
	for i, rp := range recentPosts {
		if p.Time.After(rp.Time) {
			recentPosts = append(recentPosts, nil)
			copy(recentPosts[i+1:], recentPosts[i:])
			recentPosts[i] = p
			return
		}
	}
	recentPosts = append(recentPosts, p)
}

func feed() *feeds.Feed {
	now := time.Now()
	feed := &feeds.Feed{
		Title:       "Jason’s Post",
		Link:        &feeds.Link{Href: "http://blog.djason.cc"},
		Description: "",
		Author:      &feeds.Author{"Jason", "dongjun903456@163.com"},
		Created:     now,
	}

	for i := 0; i < feedNum && i < len(recentPosts); i++ {
		p := recentPosts[i]
		feed.Items = append(feed.Items, &feeds.Item{
			Title:       p.Title,
			Link:        &feeds.Link{Href: "http://blog.djason.cc/" + p.Name},
			Description: p.Content,
			Created:     p.Time,
		})
	}

	return feed
}
