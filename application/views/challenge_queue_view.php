<?php include_once("modals/load_layer.php"); ?>
<p class="lead" style="color: white; text-align: center;">
    В ожидании <span style="text-decoration: line-through;">чуда...</span> соперника
</p>

<script>
    function check_queue() {
        $.ajax({
            url: "/challenge/check_queue"
        }).done(function (response) {
            if (response == "ready") {
                location.href = "/challenge/play";
            }
        });
        upd = setTimeout(check_queue, 1000);
    }
    var upd = setTimeout(check_queue, 1000);
</script>