<fieldset>
    <h3 class="sign-up-title" style="color:#fff; text-align: center">Дуэль</h3>
    <input class="form-control" placeholder="" id="startlink" type="text" value="<?=$data?>">
    <p>Отправьте эту ссылку своему сопернику. Ждем...</p>
</fieldset>

<script>
    function check() {
        $.ajax({
            url: "/challenge/wait",
        }).done(function (response) {
            if (response == "play") {
                location.href = "/challenge/play";
            }
        });
        upd = setTimeout(check, 10000);
    }
    var upd = setTimeout(check, 10000);
</script>