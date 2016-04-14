<div class="modal fade login-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Вход в систему</h4>
            </div>
            <div class="modal-body">
                <p>Чтобы играть в этом режиме, вам необходимо залогиниться.</p>
                <p>Вы можете войти через:</p>
                <div class="socials row">
                    <div class="soclogin col-xs-4">
                        <a class="btn btn-primary btn-block" href="/login/provider/Vkontakte" onclick="sendRefererMode()">
                            <i class="fa fa-vk"></i></a>
                    </div>
                    <div class="soclogin col-xs-4">
                        <a class="btn btn-primary btn-block" href="/login/provider/Facebook" onclick="sendRefererMode()" disabled>
                            <i class="fa fa-facebook"></i></a>
                    </div>
                    <div class="soclogin col-xs-4">
                        <a class="btn btn-danger btn-block" href="/login/provider/Google" onclick="sendRefererMode()" disabled>
                            <i class="fa fa-google-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showLoginModal() {
        $(".login-modal").modal("show");
    }

    function sendRefererMode(){
        $.ajax({
            url:"/main/referer_mode/" + window.referer_mode
        })
    }
</script>