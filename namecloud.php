<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- made by www.metatags.org -->
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов." />
    <meta name="keywords" content="википедия, вики, игра, интерактив, развлечение, образование, ссылка, переход, клик" />
    <meta name="author" content="Sergey Shilin & Dmitriy Verbitskiy">
    <meta name="robots" content="index, nofollow">
    <meta name="revisit-after" content="3 days">
    <title>WikiWalker - Страница благодарности</title>
    <!-- wikipedia, game, walk -->

    <link rel="icon" href="../../favicon.ico">
    <!-- Bootstrap core CSS -->
    <link href="/wiki/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/wiki/css/cover.css" rel="stylesheet">
    <style type="text/css">
      .vklink {
        padding: 1px 4px;
        background-color: rgba(0, 0, 51, 0.4);
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
      }

      .vklink:hover{
        text-decoration: none;
      }

/*      #clouder {
        margin: 0 auto;
      }
*/
    </style>

    <script src="/wiki/assets/js/ie-emulation-modes-warning.js"></script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="/wiki/js/jquery.min.js"></script>
    <script type="text/javascript" src="/wiki/js/cloud-lib.js"></script>
    <!-- <script type="text/javascript" src="/wiki/js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="/wiki/assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/wiki/assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>

    function init() {
        var w = document.body.clientWidth, h = document.body.clientHeight;
        var clouder = document.getElementById('clouder');
        
        clouder.style.border = "1px solid black";
        clouder.style.width = w * 2 / 3;
        clouder.style.height = h * 2 / 3;
        clouder.style.position = "absolute";
        clouder.style.left = w / 6;
        clouder.style.top = h / 6;
        clouder.style.border = "1px solid black";
        
        window.clouder = new Clouder({
            container: clouder,
            tags: createTags()
        });
    } // init

    function createTags() {
        var elems = [];
        elems.push({text: "Az", id: "1", weight: 0.1});
        elems.push({text: "Vedi", id: "2", weight: 0.1});
        elems.push({text: "Glagol", id: "3", weight: 0.1});
        elems.push({text: "Dobro", id: "4", weight: 0.1});
        elems.push({text: "Est", id: "5", weight: 0.1});
        elems.push({text: "Zelo", id: "6", weight: 0.1});
        elems.push({text: "Zemla", id: "7", weight: 0.1});
        elems.push({text: "Izhe", id: "8", weight: 0.1});
        elems.push({text: "Theta", id: "9", weight: 0.1});
        elems.push({text: "I", id: "10", weight: 0.5});
        elems.push({text: "Kako", id: "20", weight: 0.5});
        elems.push({text: "Ludi", id: "30", weight: 0.5});
        elems.push({text: "Myslete", id: "40", weight: 0.5});
        elems.push({text: "Nash", id: "50", weight: 0.5});
        elems.push({text: "Ksi", id: "60", weight: 0.5});
        elems.push({text: "On", id: "70", weight: 0.5});
        elems.push({text: "Pokoi", id: "80", weight: 0.5});
        elems.push({text: "Cherv", id: "90", weight: 0.5});
        elems.push({text: "Rtsy", id: "100", weight: 1.0});
        elems.push({text: "Slovo", id: "200", weight: 1.0});
        elems.push({text: "Tverdo", id: "300", weight: 1.0});
        elems.push({text: "Uk", id: "400", weight: 1.0});
        elems.push({text: "Fert", id: "500", weight: 1.0});
        elems.push({text: "Kha", id: "600", weight: 1.0});
        elems.push({text: "Psi", id: "700", weight: 1.0});
        elems.push({text: "Omega", id: "800", weight: 1.0});
        elems.push({text: "Tsy", id: "900", weight: 1.0});
        return elems;
    } // createTags

    </script>

  </head>

  <body onLoad="init();">

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">WikiWalker</h3>
              <!-- <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="#">Home</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">Contact</a></li>
                </ul>
              </nav> -->
            </div>
          </div>

          <div class="inner cover">
            <div id="clouder"></div>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Содержимое взято с сайта <a href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a>.</br>
                Поддержи проект! Вступай в группу <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
              .</p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28976460 = new Ya.Metrika({id:28976460, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
  </body>
</html>
