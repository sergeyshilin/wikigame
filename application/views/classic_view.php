<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- made by www.metatags.org -->
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta name="keywords" content="википедия, вики, игра, интерактив, развлечение, образование, ссылка, переход, клик"/>
    <meta name="author" content="Sergey Shilin & Dmitriy Verbitskiy">
    <meta name="robots" content="index, nofollow">
    <meta name="revisit-after" content="3 days">
    <link rel="stylesheet" type="text/css" href="/application/css/main.css">
    <meta property="og:title" content="WikiWalker - Пройди свой путь"/>
    <meta property="og:description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta property="og:url" content="http://wikiwalker.ru/"/>
    <meta property="og:image" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>
    <meta property="og:image:url" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>
    <meta name="title" content="WikiWalker - Пройди свой путь"/>
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <link rel="image_src" href="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <title>WikiWalker - Пройди свой путь</title>
    <!-- wikipedia, game, walk -->
    <script src="/application/js/jquery.min.js"></script>
    <script src="/application/js/magnific.js"></script>
    <link rel="stylesheet" href="/application/css/magnific.css" />
    <link rel="icon" href="/application/images/logo/favicon.ico">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        ul[style]{
            line-height: 30.24px!important;
        }
        #countdown{
            margin-top: 10px;
            font-weight: normal;
        }
        #backarrow:hover{
            cursor: hand;
        }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/application/css/timeTo.css">
    <link rel="stylesheet" type="text/css" href="/application/css/bootstrap-scope.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/wiki-site.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/wiki-modules.min.css">
    <script src="/application/js/jquery.time-to.min.js"></script>


</head>

<div class="bootstrap-scope">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img class="header_logo" src="/application/images/logo/logo.svg" title="WikiWalker - найди свой путь">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a id="_endlink" target="_blank" href="">Ваша цель: <span id="_end" class="jslink"></span></a></li>
                    <li><a id="backarrow">Назад <span class="glyphicon glyphicon-arrow-left"></span></a></li>
                    <li><a id="_counter">Количество шагов: <span></span></a></li>
                    <li><a id="like"><span class="glyphicon glyphicon-thumbs-up"></span></a></li>
                    <li><a id="dislike"><span class="glyphicon glyphicon-thumbs-down"></span></a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="hovered"><a href="/classic<?= $start_page ?>"
                                           onclick="yaCounter28976460.reachGoal('header_playagain'); return true;">Начать заново</a></li>

                </ul>
            </div>
        </div>
    </nav>
</div>
<script>
    window.t = "";
    window.like = 0;
    jQuery.ajax({
        url:"/wiki/Main_Page"
    }).done(function(data){
        $(".bootstrap-scope").after(data);
        fixLinks();
        getWayInfo();
        setUpUrl();
        syncLikes();
    });

    function setUpUrl(){
        $.ajax({url: "/one_minute/playlink"}).done(function(data){
            window.history.pushState("", "", "/"+data);
        })
    }

    function fixLinks(){
        $("a:not([href^='#'], #navbar *, .navbar-header *)").attr("onclick", "loadAfterClick(this); return false;");
        //$("a.image").attr("onclick", "return false");
    }

    function syncLikes(){
        $.ajax({
            url: "/main/like/check"
        }).done(function(data){
            console.log(data);
            window.like = data;
            if(data == 1){$("#like span").css("border", "1px solid");}
            if(data == -1){$("#dislike span").css("border", "1px solid");}
        });
    }

    function getWayInfo(fr){
        $.ajax({
            url:"/classic/get",
            dataType: "json",
            jsonp: "false"
        }).done(function(data){
            window.t = data;
            refreshWindow();
        });
    }

    function refreshWindow(){
        $("#_counter>span").text(t.counter);
        $("#_end").text(t.end);
        $("#_endlink").attr("href", t.endlink);
    }

    function loadAfterClick(ele){
        $.ajax({
            url: $(ele).prop("href")
        }).done(function(data){
            if(data == "win") {
                location.href="/classic/success";
            }
            else{
                $(".bootstrap-scope").nextAll().remove(); $(".bootstrap-scope").after(data);
                fixLinks();
                getWayInfo();
                $(document).scrollTop(0);
            }
        });
    }
    $("#backarrow").click(function(){
        jQuery.ajax({
            url:"/wiki/"+window.t.previous
        }).done(function(data){
            $(".bootstrap-scope").nextAll().remove();
            $(".bootstrap-scope").after(data);
            fixLinks();
            getWayInfo();
            $(document).scrollTop(0);
        });
    });
    $("#dislike").click(function(){
        if(window.like == "-1"){
            $.ajax({
                url: "/main/like"
            });
            $("#dislike span").css("border", "none");
            syncLikes();
        }
        else if(window.like == "0" || window.like == "1"){
            $.ajax({
                url: "/main/like/-1"
            });
            $("#dislike span").css("border", "1px solid");
            $("#like span").css("border", "none");
            syncLikes();
        }
    })
    $("#like").click(function(){
        if(window.like == "1"){
            $.ajax({
                url: "/main/like"
            });
            $("#like span").css("border", "none");
            syncLikes();
        }
        else if(window.like == "0" || window.like == "-1"){
            $.ajax({
                url: "/main/like/1"
            });
            $("#like span").css("border", "1px solid");
            $("#dislike span").css("border", "none");
            syncLikes();
        }
    })
</script>