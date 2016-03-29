<div class="modal fade custom-way-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Свой маршрут</h4>
            </div>
            <div class="modal-body">
                <div id="before-success">
                    <div id="custom_ways_alert_wrapper">
                    </div>

                    <div class="input-group">
                        <input class="form-control" placeholder="Начальная ссылка" id="startlink" type="text" value="">
                        <span class="input-group-addon" onclick="exchange()"><i class="fa fa-exchange"></i></span>
                        <input class="form-control" placeholder="Конечная ссылка" id="endlink" type="text" value="">
                    </div>
                </div>
                <div id="after-success" style="display: none;">
                    <p>Поздравляем! Теперь вы можете сыграть в него в следующих режимах:</p>
                    <a id="classic" class="btn btn-default" href="">Классический</a>
                    <a id="one_minute" class="btn btn-default" href="">На время</a>
                    <a id="challenge" class="btn btn-default" href="">Дуэль</a>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success submit-button" onclick="add()" id="submit_action">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showCustomWayModal() {
        $("#before-success").css("display", "block");
        $("#submit_action").css("display", "inline-block");
        $("#after-success").css("display", "none");
        $(".custom-way-modal").modal("show");
    }
    
    function add() {
        $.ajax({
            url: "/custom_ways/add",
            method: "POST",
            data: {
                "startlink": $("#startlink").val(),
                "endlink": $("#endlink").val()
            }
        }).done(function (response) {
            switch (response) {
                case "exists":
                    showMessage("У вас уже есть такой маршрут");
                    break;
                case "failed":
                    location.href = "/";
                    break;
                case "invalid links":
                    showMessage("Неправильный адрес");
                    break;
                default:
                    $("#challenge").attr("href", "/challenge/custom/" + response);
                    $("#classic").attr("href", "/wiki/custom_way/" + response);
                    $("#one_minute").attr("href", "/one_minute/" + response);
                    $("#before-success").css("display", "none");
                    $("#submit_action").css("display", "none");
                    $("#after-success").css("display", "block");
                    break;
            }
        });
    }

    function exchange() {
        var $start_link = $("#startlink");
        var $end_link = $("#endlink");
        var text_left = $start_link.val();
        $start_link.val($end_link.val());
        $end_link.val(text_left);
    }

    function showMessage(message) {
        $("#custom_ways_alert_wrapper").html(
            '<div id="custom_ways_alert" class="alert alert-warning" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span></button>' +
            '<span id="msg_placeholder"></span>' +
            '</div>');
        $("#custom_ways_alert").css("display", "block");
        $("#msg_placeholder").text(message);
    }
</script>