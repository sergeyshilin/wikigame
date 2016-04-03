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
                    <img class="header_logo" src="/application/images/logo.svg" title="WikiWalker - найди свой путь">
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
        url: "/wiki/Main_Page"
    }).done(function (data) {
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
            if ((Math.floor(Date.now() / 1000) - parseInt(c.date)) > 15) {
                alert("Игрок вышел");
                location.href = "/";
            }
            refreshWindow();
        });
        upd = setTimeout(update, 6000);
    }
    var upd = setTimeout(update, 6000);

    function fixLinks() {
        $("a:not([href^='#'], #navbar *, .navbar-header *)").attr("onclick", "loadAfterClick(this); return false;");
    }

    function getWayInfo(fr) {
        $.ajax({
            url: "/challenge/get",
            dataType: "json",
            jsonp: "false"
        }).done(function (data) {
            window.t = data;
            refreshWindow();
        });
    }

    function check() {
        $.ajax({
            url: "/challenge/upd"
        }).done(function (response) {
            if (response == "lose") {
                alert("Вы проиграли! Соперник раньше дошел до конца! :)");
                location.href = "/";
            }
        })
    }

    function refreshWindow() {
        $("#_counter>span").text(t.counter);
        $("#_end").text(t.end);
        $("#_endlink").attr("href", t.endlink);
        $("#_nick2>span").text(c.nick);
        $("#_counter2>span").text(c.counter);
        $("#_current2>span").text(c.link);
    }

    function loadAfterClick(ele) {
        $.ajax({
            url: $(ele).prop("href")
        }).done(function (data) {
            if (data == "win") {
                location.href = "/challenge/success";
            }
            else {
                $(".bootstrap-scope").nextAll().remove();
                $(".bootstrap-scope").after(data);
                fixLinks();
                getWayInfo();
                $(document).scrollTop(0);
            }
        });
    }
    $("#backarrow").click(function () {
        jQuery.ajax({
            url: "/wiki/" + window.t.previous
        }).done(function (data) {
            $(".bootstrap-scope").nextAll().remove();
            $(".bootstrap-scope").after(data);
            fixLinks();
            getWayInfo();
            $(document).scrollTop(0);
        });
    });

    $("#dislike").click(function () {
        if (window.like == "-1") {
            $.ajax({
                url: "/main/like"
            });
            $("#dislike span").css("border", "none");
            syncLikes();
        }
        else if (window.like == "0" || window.like == "1") {
            $.ajax({
                url: "/main/like/-1"
            });
            $("#dislike span").css("border", "1px solid");
            $("#like span").css("border", "none");
            syncLikes();
        }
    });
    $("#like").click(function () {
        if (window.like == "1") {
            $.ajax({
                url: "/main/like"
            });
            $("#like span").css("border", "none");
            syncLikes();
        }
        else if (window.like == "0" || window.like == "-1") {
            $.ajax({
                url: "/main/like/1"
            });
            $("#like span").css("border", "1px solid");
            $("#dislike span").css("border", "none");
            syncLikes();
        }
    });
</script>