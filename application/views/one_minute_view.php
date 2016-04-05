<div class="bootstrap-scope">
    <nav id="game-navbar" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <ul class="nav navbar-nav" style="margin-top: 0">
                <li><a class="navbar-brand" href="/">
                        <img class="header_logo" src="/application/images/logo.svg" title="WikiWalker - найди свой путь">
                    </a></li>
                <li><button type="button" id="backarrow" class="btn btn-default navbar-btn backarrow"><span class="glyphicon glyphicon-arrow-left"></span></button></li>
                <li><div class="navbar-text ellipse endlink_wrapper"><a class="_endlink" target="_blank" href=""><span></span></a></div></li>
                <li>
                    <div id="countdown" style="line-height: 30.24px!important;" class="timeTo timeTo-white"></div>
                </li>
            </ul>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/one_minute<?= $start_page ?>" style="padding-top: 17px" onclick="yaCounter28976460.reachGoal('header_playagain'); return true;">Начать заново</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<script>
    window.t = "";
    window.like = 0;
    jQuery.ajax({
        url: "/wiki/Main_Page"
    }).done(function (data) {
        $(".bootstrap-scope").after(data);
        fixLinks();
        getWayInfo();
        syncLikes();
        setUpUrl();
        $('#countdown').timeTo(60, function () {
            location.href = "/one_minute/lose";
        });
    });

    function setUpUrl() {
        $.ajax({url: "/one_minute/playlink"}).done(function (data) {
            window.history.pushState("", "", "/" + data);
        })
    }
    function fixLinks() {
        $("a:not([href^='#'], #game-navbar *, .navbar-header *)").attr("onclick", "loadAfterClick(this); return false;");
        //$("a.image").attr("onclick", "return false");
    }

    function getWayInfo(fr) {
        $.ajax({
            url: "/one_minute/get",
            dataType: "json",
            jsonp: "false"
        }).done(function (data) {
            window.t = data;
            refreshWindow();
            syncLikes();
        });
    }

    function syncLikes() {
        $.ajax({
            url: "/main/like/check"
        }).done(function (data) {
            console.log(data);
            window.like = data;
            if (data == 1) {
                $("#like span").css("border", "1px solid");
            }
            if (data == -1) {
                $("#dislike span").css("border", "1px solid");
            }
        });
    }

    function refreshWindow() {
        $("._endlink").attr("href", t.endlink);
        $("._endlink>span").text(t.end);
    }


    function loadAfterClick(ele) {
        $.ajax({
            url: $(ele).prop("href")
        }).done(function (data) {
            if (data == "win") {
                location.href = "/one_minute/success";
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
    })
</script>