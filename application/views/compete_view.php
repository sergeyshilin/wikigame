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
                <li><div class="navbar-text step"><span></span> из 5</div></li>
                <li>
                    <div id="countdown" style="line-height: 30.24px!important;" class="timeTo timeTo-white"></div>
                </li>
            </ul>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/compete<?= $start_page ?>" style="padding-top: 17px" onclick="yaCounter28976460.reachGoal('header_playagain'); return true;">Начать заново</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php include_once("modals/load_layer.php"); ?>
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
        $('#countdown').timeTo(900, function () {
            location.href = "/compete/lose";
        });
        $(".load-layer").hide();
    });

    function fixLinks() {
        $("a:not([href^='#'], #game-navbar *, .navbar-header *, .new)").attr("onclick", "loadAfterClick(this); return false;");
        $("a.new").attr("onclick","alert('Этой страницы в Википедии нет'); return false;");
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
        $("._counter").text(t.counter);
        $("._endlink").attr("href", t.endlink);
        $("._endlink>span").text(t.end);
        $(".step>span").text(t.compete.step);
    }

    function loadAfterClick(ele) {
        $(".load-layer").show();
        $("#content").hide();
        $(document).scrollTop(0);
        $.ajax({
            url: $(ele).prop("href")
        }).done(function (data) {
            if (data == "win") {
                location.href = "/compete/success";
            }
            $(".bootstrap-scope").nextAll().remove();
            $(".bootstrap-scope").after(data);
            fixLinks();
            getWayInfo();
            $(document).scrollTop(0);
            $("#content").show();
            $(".load-layer").hide();
        });
    }
    $("#backarrow").click(function () {
        if (window.t.previous != "") {
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
        }
    });
</script>