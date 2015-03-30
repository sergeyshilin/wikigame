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
url_start = "http://ru.wikipedia.org/wiki/"
#url_start = "http://en.wikipedia.org/wiki/" # for english links

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
            # if list with results is empty we need to add start link of our way
            self.fin.append(url)
            # self.fin.append(url[len(url_start):]) #it's essential for english links
        
        page = urllib.urlopen(url).read()
        sleep(0.5)
        
        #we want to get links only from content
        try:      
            page = page[page.index("<div id=\"content\" class=\"mw-body\" role=\"main\">"):page.rindex(">Примечания</span>")]
        except ValueError:
            try:
                page = page[page.index("<div id=\"content\" class=\"mw-body\" role=\"main\">"):page.rindex(">Литература</span>")]
            except ValueError:
                try:
                    page = page[page.index("<div id=\"content\" class=\"mw-body\" role=\"main\">"):page.rindex(">Ссылки</span>")]  
                except ValueError:
                    page = page[page.index("<div id=\"content\" class=\"mw-body\" role=\"main\">"):page.index("<div id=\"mw-navigation\">")]
        
        
        #get all correct links from this url
        links =  self.get_all_links(page)
        
        if self.current_depth != self.max_depth:
            self.current_depth+=1

            length = len(links) - 1
            self.sum+=length
            
            try:
                self.next_page = links[randint(0, length)]
            except:
                try:
                    self.next_page = links[0]
                except:
                    return self.fin

            self.fin.append(url_start + self.next_page)
            return self.get_way(url_start + self.next_page)
        else:
            return self.fin

    def check_last_link(self, way):
        #delete ways with repeated links in one way
        for i, e in enumerate(way):
            if e in way[:i]:
                return False        

        link = way[-1]

        #delete way if final page about man and if finish in start
        try:    
            page_end = urllib.urlopen(link).read()
            page_start = urllib.urlopen(way[0]).read()

            if link[link.find(url_start)+len(url_start):] in page_start:
                return False

            if "Дата&nbsp;рождения:</th>" in page_end or "Дата рождения:</th>" in page_end:
                return False
        except:
            pass

        try:    
            if int(link).isdigit():
                return False
        except:
            try:
                year = link[link.rfind('/')+1:].split('_')[0]
                if int(year) < 2016:
                    return False
                else:
                    raise Exception
            except Exception:                
                return True



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
        if ':' in name or '#' in name:
            return False
        return True

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

    def get_url_list(self, filename):
        url_list = []

        start_pages = open('./start_pages/' + filename, 'r')
        lines = start_pages.readlines()
        start_pages.close()

        for line in lines[:-1]:
            url_list.append(line[:-1])
        url_list.append(lines[-1])

        return url_list


if __name__ == "__main__":
    tree = Tree()

    # filenames = {'biology_start.txt': 'biology_unsorted.txt',
    #              'astronomy_start.txt': 'astronomy_unsorted.txt', 
    #              'technic_start.txt': 'tecnic_unsorted.txt',
    #              'films_start.txt': 'films_unsorted.txt',
    #              'art_start.txt': 'art_unsorted.txt'}
    filenames = {'main_kun.txt': 'main_kun_unsorted.txt'}
    for filename_start in filenames:
        print filename_start, filenames[filename_start]
        url_list = tree.get_url_list(filename_start)

        f = open("./results/" + filenames[filename_start], "w")
        for max_length in range(5, 7):
            tree.set_max_length(max_length)
            for url_end in url_list:
                url = url_end
                # url = url_start + url_end # it's for english links
                for i in range(5):
                    links = tree.get_way(url)
                    if not tree.check_last_link(links):
                        tree.clear_all()
                        continue
                    string = str(links) + ', ' + str(len(links)) + ', ' + str(tree.get_sum()) + '\n'
                    f.write(string)

                    tree.clear_all()
        f.close()
    # tree.count('./15klists.txt')