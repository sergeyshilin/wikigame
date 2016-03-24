
<fieldset>
    <h3 class="sign-up-title" style="color:#fff; text-align: center">Свой маршрут</h3>
    <div id="custom_ways_alert" style="visibility: hidden" class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <span id="msg_placeholder"></span>.
    </div>
    <input class="form-control" placeholder="Начальная ссылка" id="startlink" type="text" value="">
    <input class="form-control" placeholder="Конечная ссылка" id="endlink" type="text" value="">

    <button class="btn btn-success btn-block submit-button" onclick="add()" id="submit_action">Сохранить</button>

</fieldset>
    <div id="after-success">
        <a id="classic" href=""><button class="btn btn-default">Классический</button></a>
        <a id="one_minute" href=""><button class="btn btn-default">На время</button></a>
        <a id="challenge" href=""><button class="btn btn-default">Дуэль</button></a>
    </div>


<script>

        $("#after-success").css("visibility","hidden");
        function add() {
            $.ajax({
                url: "/custom_ways/add",
                method: "POST",
                data: {"startlink": $("#startlink").val(), "endlink": $("#endlink").val()}
            }).done(function (response) {
                switch (response) {
                    case "exists":
                        $("#custom_ways_alert").css("visibility","visible");
                        $("#msg_placeholder").text("У вас уже есть такой маршрут");
                        break;
                    case "failed":
                        location.href = "/";
                        break;
                    case "invalid links":
                        $("#custom_ways_alert").css("visibility","visible");
                        $("#msg_placeholder").text("Неправильный адрес");
                        break;
                    default:
                        $("#custom_ways_alert").css("visibility","visible");
                        $("#msg_placeholder").text("Поздравляем! У вас есть свой маршрут");
                        $("#challenge").attr("href", "/challenge/custom/"+response);
                        $("#classic").attr("href", "/wiki/custom_way/"+response);
                        $("#one_minute").attr("href", "/one_minute/"+response);
                        $("#after-success").css("visibility","visible");
                        break;
                }
            });
        }

</script>