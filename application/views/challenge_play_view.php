<div class="bootstrap-scope">
    <nav id="game-navbar" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <ul class="nav navbar-nav" style="margin-top: 0">
                <li><a class="navbar-brand" href="/">
                        <img class="header_logo" src="/application/images/logo.svg" title="WikiWalker - найди свой путь">
                    </a></li>
                <li><button type="button" id="backarrow" class="btn btn-default navbar-btn backarrow"><span class="glyphicon glyphicon-arrow-left"></span></button></li>
                <li><div class="navbar-text counter_wrapper"><span class="label label-warning _counter" style="font-size: 100%; padding: 3px 6px;"></span></div></li>
                <li><div class="navbar-text ellipse endlink_wrapper"><a class="_endlink" target="_blank" href=""><span></span></a></div></li>
            </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><div class="navbar-text" id="_nick2"> <span></span></div></li>
                    <li><div class="navbar-text" id="_current2"> <span></span></div></li>
                    <li><div class="navbar-text" id="_counter2">шагов:<span></span></div></li>
                </ul>
        </div>
    </nav>
    <?php include_once("modals/load_layer.php"); ?>
</div>

<script>
    window.t = "";
    window.c = "";
    jQuery.ajax({
        url: "/wiki/Main_Page"
    }).done(function (data) {
        $(".load-layer").hide();
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
        $("a:not([href^='#'], #game-navbar *, .navbar-header *, .new)").attr("onclick", "loadAfterClick(this); return false;");
        $("a.new").attr("onclick","alert('Этой страницы в Википедии нет'); return false;");
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
                //alert("Вы проиграли! Соперник раньше дошел до конца! :)");
                location.href = "/challenge/lose";
            }
        })
    }

    function refreshWindow() {
        $("._counter").text(t.counter);
        $("._endlink").attr("href", t.endlink);
        $("._endlink>span").text(t.end);
        $("#_nick2>span").text(c.nick);
        $("#_counter2>span").text(c.counter);
        $("#_current2>span").text(c.link);
    }

    function loadAfterClick(ele) {
        $(".load-layer").show();
        $("#content").hide();
        $(document).scrollTop(0);

        $.ajax({
            url: $(ele).prop("href")
        }).done(function (data) {
            if (data == "win") {
                location.href = "/challenge/success";
            }
            else {
                $("#content").show();
                $(".load-layer").hide();
                $(".bootstrap-scope").nextAll().remove();
                $(".bootstrap-scope").after(data);
                fixLinks();
                getWayInfo();
                $(document).scrollTop(0);
            }
        });
    }
    $("#backarrow").click(function () {
        $(".load-layer").show();
        $("#content").hide();
        $(document).scrollTop(0);

        jQuery.ajax({
            url: "/wiki/" + window.t.previous
        }).done(function (data) {
            $("#content").show();
            $(".load-layer").hide();

            $(".bootstrap-scope").nextAll().remove();
            $(".bootstrap-scope").after(data);
            fixLinks();
            getWayInfo();
            $(document).scrollTop(0);
        });
    });
</script>