<div style="color: #fff;">
    <input class="form-control" placeholder="" id="startlink" type="text" value="<?=$info?>">
    <p>Отправьте эту ссылку своему сопернику. Ждем...</p>
</div>

<script>
    function check() {
        $.ajax({
            url: "/challenge/wait"
        }).done(function (response) {
            if (response == "play") {
                location.href = "/challenge/play";
            }
        });
        upd = setTimeout(check, 1000);
    }
    var upd = setTimeout(check, 1000);
</script>