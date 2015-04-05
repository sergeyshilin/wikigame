<?php

require_once 'C:\Users\illus_000\Documents\GitHub\wikigame\w\classes\PageResolver.php';

class PageResolverTest extends PHPUnit_Framework_TestCase {
    public function testPageResolve() {
        $_SESSION['lang'] = "ru";
        $page = "Прокрастинация";
        $resolver = new PageResolver();
        $obj = $resolver->getContentFromApi($page);
        $this->assertEquals($page, $obj["title"]);
    }

    public function testPageRedirect() {
        $_SESSION['lang'] = "ru";
        $resolver = new PageResolver();

        $obj = $resolver->getContentFromApi("Числовая прямая");
        $title = $obj["title"];
        $content = $obj["content"];

        $this->assertEquals("Числовая прямая", $title);
        $this->assertTrue($resolver->isRedirect($content));

        $page = $resolver->extractRedirectPageName($content);

        $obj = $resolver->getContentFromApi($page);
        $title = $obj["title"];
        $this->assertEquals("Числовая ось", $title);
    }

    public function testCategories() {
        $_SESSION['lang'] = "ru";
        $resolver = new PageResolver();

        $obj = $resolver->getContentFromApi("Категория:Монастыри по алфавиту");
        $title = $obj["title"];
        $content = $obj["content"];
    }
}