# -*- coding: utf-8 -*-

import urllib
import os
from random import randint
from time import sleep
import matplotlib.pyplot as plt
import numpy as np
import matplotlib.mlab as mlab
import math

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

    def count(self, txt):
        sums_3 = []
        sums_4 = []
        sums_5 = []

        f = open(txt, "r")
        text = f.readlines()
        f.close()

        def fil(x):
            if x > 6000:
                return x

        for line in text:
            if self.get_depth(line) == 3:
                sums_3.append(self.get_numbers_links(line))
            elif self.get_depth(line) == 4:
                sums_4.append(self.get_numbers_links(line))
            elif self.get_depth(line) == 5:
                sums_5.append(self.get_numbers_links(line))

        plt.plot(sums_3, self.get_normal(sums_3))
        plt.plot(sums_4, self.get_normal(sums_4))
        plt.plot(sums_5, self.get_normal(sums_5))
        plt.show()
        # self.show_plot(sums_3, [self.get_point(num, 3) for num in sums_3])
        # print sums_3
        # print [self.get_point(num, 3) for num in sums_3]
        # print len(filter(fil, sums_5))
        # print len(filter(fil, sums_4))

    def get_numbers_links(self, line):
            return int(line[line.rfind(',') + 2:-1])

    def get_depth(self, line):
            return int(line[line.rfind(',')-1])

    def get_point(self, num_links, depth):
        weight_of_depth = 100
        weight_of_links = 0.5
        return int(depth * weight_of_depth + num_links * weight_of_links)

    def show_plot(self, lst_1, lst_2 = None):
        plt.plot(lst_1, lst_2)
        plt.show()

    def get_normal(self, s):
        s.sort()
        mean = np.mean(s)
        sigma = math.sqrt(np.var(s))
        return mlab.normpdf(s,mean,sigma)


if __name__ == "__main__":
    tree = Tree()
    # max_length = 4
    # url_list = [ 
    #             "Mold",
    #             "Bitter_orange",
    #             "World_War_II",
    #             "University",
    #             "Earth",
    #             "Rock_music",
    #             "Italy",
    #             "Geology",
    #             "Radio",
    #             "Computer",
    #             "Tennis",
    #             "The_Simpsons",
    #             "Lake_Baikal",
    #             "Fifty_Shades_of_Grey",
    #             "Stephen_Hawking",
    #             "Facebook",
    #             "FIFA_World_Cup",
    #             "Cristiano_Ronaldo",
    #             "Amazon.com",
    #             "Game_of_Thrones",
    #             "Franz_Kafka",
    #             "Emma_Watson",
    #             "Olympic_Games",
    #             "Jack_the_Ripper",
    #             "Lunar_New_Year",
    #             "Mathematics",
    #             "The_Beatles",
    #             "Wikipedia",
    #             "Russia",
    #             "Vladimir_Putin",
    #             "Atom",
    #             "DNA",
    #             "Carbohydrate",
    #             "Metabolism",
    #             "Virus",
    #             "Mary_Rose",
    #             "Albatross",
    #             "Fossil",
    #             "Plutonium",
    #             "Norman_Selfe",
    #             "Lung_cancer",
    #             "British_Empire",
    #             "Tamil_language",
    #             "Washington_v._Texas",
    #             "Batman",
    #             "J._R._R._Tolkien",
    #             "Logarithm",
    #             "Fight_Club",
    #             "Superman_in_film",
    #             "Hurricane_Isabel",
    #             "AC/DC"
    #             ]
    url_list = [
    "https://ru.wikipedia.org/wiki/%D0%9A%D0%B0%D0%BD%D1%82%D0%BE%D1%80,_%D0%93%D0%B5%D0%BE%D1%80%D0%B3",
    "https://ru.wikipedia.org/wiki/%D0%91%D0%B5%D0%BA%D0%BB%D0%B5%D0%BC%D0%B8%D1%88%D0%B5%D0%B2,_%D0%94%D0%BC%D0%B8%D1%82%D1%80%D0%B8%D0%B9_%D0%92%D0%BB%D0%B0%D0%B4%D0%B8%D0%BC%D0%B8%D1%80%D0%BE%D0%B2%D0%B8%D1%87",
    "https://ru.wikipedia.org/wiki/%D0%93%D0%B0%D1%83%D1%81%D1%81,_%D0%9A%D0%B0%D1%80%D0%BB_%D0%A4%D1%80%D0%B8%D0%B4%D1%80%D0%B8%D1%85",
    "https://ru.wikipedia.org/wiki/%D0%9D%D1%8C%D1%8E%D1%82%D0%BE%D0%BD,_%D0%98%D1%81%D0%B0%D0%B0%D0%BA",
    "https://ru.wikipedia.org/wiki/%D0%9E%D1%81%D1%82%D1%80%D0%BE%D0%B3%D1%80%D0%B0%D0%B4%D1%81%D0%BA%D0%B8%D0%B9,_%D0%9C%D0%B8%D1%85%D0%B0%D0%B8%D0%BB_%D0%92%D0%B0%D1%81%D0%B8%D0%BB%D1%8C%D0%B5%D0%B2%D0%B8%D1%87",
    "https://ru.wikipedia.org/wiki/%D0%9B%D0%B0%D0%BD%D0%B4%D0%B0%D1%83,_%D0%9B%D0%B5%D0%B2_%D0%94%D0%B0%D0%B2%D0%B8%D0%B4%D0%BE%D0%B2%D0%B8%D1%87",
    "https://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%84%D1%88%D0%B8%D1%86,_%D0%95%D0%B2%D0%B3%D0%B5%D0%BD%D0%B8%D0%B9_%D0%9C%D0%B8%D1%85%D0%B0%D0%B9%D0%BB%D0%BE%D0%B2%D0%B8%D1%87",
    "https://ru.wikipedia.org/wiki/%D0%93%D0%B8%D0%BD%D0%B7%D0%B1%D1%83%D1%80%D0%B3,_%D0%92%D0%B8%D1%82%D0%B0%D0%BB%D0%B8%D0%B9_%D0%9B%D0%B0%D0%B7%D0%B0%D1%80%D0%B5%D0%B2%D0%B8%D1%87",
    "https://ru.wikipedia.org/wiki/%D0%9A%D0%B0%D0%BF%D0%B8%D1%86%D0%B0,_%D0%9F%D1%91%D1%82%D1%80_%D0%9B%D0%B5%D0%BE%D0%BD%D0%B8%D0%B4%D0%BE%D0%B2%D0%B8%D1%87",
    "https://ru.wikipedia.org/wiki/%D0%A1%D1%82%D0%BE%D0%BA%D1%81,_%D0%94%D0%B6%D0%BE%D1%80%D0%B4%D0%B6_%D0%93%D0%B0%D0%B1%D1%80%D0%B8%D0%B5%D0%BB%D1%8C",
    "https://ru.wikipedia.org/wiki/%D0%AD%D0%B9%D0%BD%D1%88%D1%82%D0%B5%D0%B9%D0%BD,_%D0%90%D0%BB%D1%8C%D0%B1%D0%B5%D1%80%D1%82",
    "https://ru.wikipedia.org/wiki/%D0%A1%D0%BA%D0%BB%D0%BE%D0%B4%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F-%D0%9A%D1%8E%D1%80%D0%B8,_%D0%9C%D0%B0%D1%80%D0%B8%D1%8F",
    "https://ru.wikipedia.org/wiki/%D0%AD%D0%B9%D0%BB%D0%B5%D1%80,_%D0%9B%D0%B5%D0%BE%D0%BD%D0%B0%D1%80%D0%B4",
    "https://ru.wikipedia.org/wiki/%D0%A0%D0%B8%D0%BC%D0%B0%D0%BD,_%D0%91%D0%B5%D1%80%D0%BD%D1%85%D0%B0%D1%80%D0%B4",
    "https://ru.wikipedia.org/wiki/%D0%95%D0%B2%D0%BA%D0%BB%D0%B8%D0%B4",
    "https://ru.wikipedia.org/wiki/%D0%A2%D1%8C%D1%8E%D1%80%D0%B8%D0%BD%D0%B3,_%D0%90%D0%BB%D0%B0%D0%BD",
    "https://ru.wikipedia.org/wiki/%D0%9B%D0%B5%D0%B9%D0%B1%D0%BD%D0%B8%D1%86,_%D0%93%D0%BE%D1%82%D1%84%D1%80%D0%B8%D0%B4_%D0%92%D0%B8%D0%BB%D1%8C%D0%B3%D0%B5%D0%BB%D1%8C%D0%BC",
    "https://ru.wikipedia.org/wiki/%D0%9C%D0%B0%D0%BA%D1%81%D0%B2%D0%B5%D0%BB%D0%BB,_%D0%94%D0%B6%D0%B5%D0%B9%D0%BC%D1%81_%D0%9A%D0%BB%D0%B5%D1%80%D0%BA",
    "https://ru.wikipedia.org/wiki/%D0%9F%D0%BB%D0%B0%D0%BD%D0%BA,_%D0%9C%D0%B0%D0%BA%D1%81",
    "https://ru.wikipedia.org/wiki/%D0%A0%D0%B5%D0%BD%D1%82%D0%B3%D0%B5%D0%BD,_%D0%92%D0%B8%D0%BB%D1%8C%D0%B3%D0%B5%D0%BB%D1%8C%D0%BC_%D0%9A%D0%BE%D0%BD%D1%80%D0%B0%D0%B4",
    "https://ru.wikipedia.org/wiki/%D0%A4%D0%B5%D1%80%D0%BC%D0%B8,_%D0%AD%D0%BD%D1%80%D0%B8%D0%BA%D0%BE",
    "https://ru.wikipedia.org/wiki/%D0%90%D0%BC%D0%BF%D0%B5%D1%80,_%D0%90%D0%BD%D0%B4%D1%80%D0%B5-%D0%9C%D0%B0%D1%80%D0%B8",
    "https://ru.wikipedia.org/wiki/%D0%91%D0%BE%D1%80,_%D0%9D%D0%B8%D0%BB%D1%8C%D1%81",
    "https://ru.wikipedia.org/wiki/%D0%A2%D0%BE%D0%BC%D1%81%D0%BE%D0%BD,_%D0%A3%D0%B8%D0%BB%D1%8C%D1%8F%D0%BC_(%D0%BB%D0%BE%D1%80%D0%B4_%D0%9A%D0%B5%D0%BB%D1%8C%D0%B2%D0%B8%D0%BD)",
    "https://ru.wikipedia.org/wiki/%D0%93%D1%8E%D0%B9%D0%B3%D0%B5%D0%BD%D1%81,_%D0%A5%D1%80%D0%B8%D1%81%D1%82%D0%B8%D0%B0%D0%BD"
    ]
    f = open("russians.txt", "w")
    for max_length in range(2, 5):
        tree.set_max_length(max_length)
        for url_end in url_list:
            url = url_start + url_end
            for i in range(20):
                links = tree.get_way(url)
                string = str(links) + ', ' + str(len(links)) + ', ' + str(tree.get_sum()) + '\n'
                f.write(string)
                tree.clear_all()
    f.close()
    # tree.count('./15klists.txt')