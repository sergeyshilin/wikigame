<style>
    .content{
        width:500px;
    }
    #copy-button{
        padding: 9px;
    }
    h4{
        text-align: center;
        color:white;
        margin-top:20px;
    }
</style>

<fieldset>
    <h3 class="sign-up-title" style="color:#fff; text-align: center">Дуэль</h3>
    <div class="input-group">
        <input class="form-control" placeholder="" id="startlink" type="text" value="<?=$info?>">
        <span class="input-group-btn">
            <button class="btn btn-default" id="copy-button" type="button" data-toggle="popover"
                    data-trigger="hover" data-content="Скопировать в буфер обмена">
                <span class="glyphicon glyphicon-copy"></span>
            </button>
        </span>
    </div>
</fieldset>
<h4>Отправьте эту ссылку своему сопернику. Ждем...</h4>
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
    $(document).ready(function(){

        var btn = document.getElementById("copy-button");
        var text = document.getElementById("startlink");
        btn.addEventListener('click', function(e) {
            try{
                text.select();
                var successful = document.execCommand('copy');
            }
            catch (e){
                console.log("Браузер не поддерживает копирование в буфер обмена")
            }
        })

    });
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>