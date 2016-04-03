<p class="lead" style="
    color: white;
    text-align: center;
">В ожидании <strike>чуда...</strike> соперника</p>

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