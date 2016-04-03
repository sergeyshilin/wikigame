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
                    <li><a id="_step">Этап:<span></span> из 5</a></li>
                    <li>
                        <div id="countdown" style="line-height: 30.24px!important;" class="timeTo timeTo-white"></div>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="hovered"><a href="/compete"
                                           onclick="yaCounter28976460.reachGoal('header_playagain'); return true;">Начать заново</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<script>
    window.history.pushState("", "", "/<?=$_SESSION["playlink"]?>");
    window.t = "";
    jQuery.ajax({
        url: "/wiki/Main_Page"
    }).done(function (data) {
        $(".bootstrap-scope").after(data);
        fixLinks();
        getWayInfo();
        $('#countdown').timeTo(600, function () {
            location.href = "/compete/lose";
        });
    });

    function fixLinks() {
        $("a:not([href^='#'], #navbar *, .navbar-header *)").attr("onclick", "loadAfterClick(this); return false;");
    }

    function getWayInfo(fr) {
        $.ajax({
            url: "/compete/get",
            dataType: "json",
            jsonp: "false"
        }).done(function (data) {
            window.t = data;
            refreshWindow();
        });
    }

    function refreshWindow() {
        $("#_end").text(t.end);
        $("#_endlink").attr("href", t.endlink);
        $("#_step>span").text(t.compete.step);
        $("#_counter>span").text(t.counter);
    }

    function loadAfterClick(ele) {
        $.ajax({
            url: $(ele).prop("href")
        }).done(function (data) {
            if (data == "win") {
                location.href = "/hitler/success";
            }
            $(".bootstrap-scope").nextAll().remove();
            $(".bootstrap-scope").after(data);
            fixLinks();
            getWayInfo();
            $(document).scrollTop(0);
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
</script>