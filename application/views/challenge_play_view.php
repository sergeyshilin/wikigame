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
    <link rel="icon" href="../../favicon.ico">
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
                    <li><a id="_nick2"> <span></span></a></li>
                    <li><a id="_current2"> <span></span></a></li>
                    <li><a id="_counter2">шагов:<span></span></a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<script>
    window.t = "";
    window.c = "";
    jQuery.ajax({
        url:"/wiki/Main_Page"
    }).done(function(data){
        $(".bootstrap-scope").after(data);
        update();
        check();
        fixLinks();
        getWayInfo();
    });
    function update() {
        $.ajax({
            url: "/challenge/check",
            dataType: "json",
            jsonp: "false"
        }).done(function (response) {
            window.c = response;
            check();
            if((Math.floor(Date.now() / 1000) - parseInt(c.date)) > 15)
            {
                alert("Игрок вышел");
                location.href = "/";
            }
            refreshWindow();
        });
        upd = setTimeout(update, 6000);
    }
    var upd = setTimeout(update, 6000);

    function fixLinks(){
        $("a:not([href^='#'], #navbar *, .navbar-header *)").attr("onclick", "loadAfterClick(this); return false;");
    }

    function getWayInfo(fr){
        $.ajax({
            url:"/challenge/get",
            dataType: "json",
            jsonp: "false"
        }).done(function(data){
            window.t = data;
            refreshWindow();
        });
    }

    function check(){
        $.ajax({
            url: "/challenge/upd"
        }).done(function(response){
            if(response == "lose"){
                alert("Вы проиграли! Соперник раньше дошел до конца! :)");
                location.href = "/";
            }
        })
    }

    function refreshWindow(){
        $("#_counter>span").text(t.counter);
        $("#_end").text(t.end);
        $("#_endlink").attr("href", t.endlink);
        $("#_nick2>span").text(c.nick);
        $("#_counter2>span").text(c.counter);
        $("#_current2>span").text(c.link);
    }

    function loadAfterClick(ele){
        $.ajax({
            url: $(ele).prop("href")
        }).done(function(data){
            if(data == "win") {
                location.href="/challenge/success";
            }
            $(".bootstrap-scope").nextAll().remove(); $(".bootstrap-scope").after(data);
            fixLinks();
            getWayInfo();
        });
    }
    $("#backarrow").click(function(){
        jQuery.ajax({
            url:"/wiki/"+window.t.previous
        }).done(function(data){
            $(".bootstrap-scope").after(data);
            fixLinks();
            getWayInfo();
        });
    })
</script>