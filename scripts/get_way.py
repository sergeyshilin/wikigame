# -*- coding: utf-8 -*-

import urllib
import os
from random import randint
from time import sleep

global url_start 
url_start = "http://en.wikipedia.org/wiki/"

class Tree:
    
    def __init__(self):

        self.next_page = ''
        self.current_depth = 0
        self.sum = 0
        self.fin = []
        self.pr_name = ''
        self.max_depth = 0

    def get_way(self, url):

        if not len(self.fin):
            self.fin.append(url[len(url_start):])
        
        page = urllib.urlopen(url).read()
        sleep(1)

        links =  self.get_all_links(page)
        
        if self.current_depth != self.max_depth:
            self.current_depth+=1

            length = len(links) - 1
            self.sum+=length

            try:
                self.next_page = links[randint(0, length)]
            except:
                self.next_page = links[0]

            self.fin.append(self.next_page)

            return self.get_way(url_start + self.next_page)
        else:
            return self.fin

    def get_all_links(self, page):
        links = []
        next_page_end = 0
        example = '<a href="/wiki/'

        while True:
            try:
                next_page_start = page.index(example, next_page_end) + len(example)
                next_page_end = page.index('"', next_page_start)
                next_page = page[next_page_start:next_page_end]
            except ValueError:
                return links

            if not self.isCorrectname(next_page):
                continue

            links.append(next_page)

    def isCorrectname(self, name):
        if self.pr_name == name:
            return False
        self.pr_name = name
        return False if ":" in name and not "Help" in name else True

    def get_sum(self):
        return self.sum

    def set_max_length(self, max_depth = 2):
        self.max_depth = max_depth

    def clear_all(self):
        self.next_page = ''
        self.current_depth = 0
        self.sum = 0
        self.fin = []
        self.pr_name = ''

if __name__ == "__main__":
    tree = Tree()
    
    url_list = [ 
                "Mold",
                "Bitter_orange",
                "World_War_II",
                "University",
                "Earth",
                "Rock_music",
                "Italy",
                "Geology",
                "Radio",
                "Computer",
                "Tennis",
                "The_Simpsons",
                "Lake_Baikal",
                "Fifty_Shades_of_Grey",
                "Stephen_Hawking",
                "Facebook",
                "FIFA_World_Cup",
                "Cristiano_Ronaldo",
                "Amazon.com",
                "Game_of_Thrones",
                "Franz_Kafka",
                "Emma_Watson",
                "Olympic_Games",
                "Jack_the_Ripper"
                ]
    for max_length in range(2, 4):
        tree.set_max_length(max_length)
        for url_end in url_list:
            url = url_start + url_end
            for i in range(20):
                links = tree.get_way(url)
                print str(links) + ', ' + str(len(links)) + ', ' + str(tree.get_sum())
                tree.clear_all()
