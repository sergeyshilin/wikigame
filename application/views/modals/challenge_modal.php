<div class="modal fade challenge-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Дуэль</h4>
            </div>
            <div class="modal-body">
                <div class="game-type-grid" style="color: #000; text-shadow: none">
                    <div class="row row-eq-height">
                        <div class="game-type col-sm-6">
                            <img src="application/images/game_types/wki_icon-04.png" class="invert" onclick="gotoChallenge('')">
                            <div class="game-type-text" onclick="gotoChallenge('')">
                                <h3>Ожидать соперника</h3>
                                <p>Сыграть со случайным противником прямо сейчас</p>
                            </div>
                        </div>
                        <div class="game-type col-sm-6">
                            <img src="application/images/game_types/wki_icon-04.png" class="invert" onclick="gotoChallenge('/share')">
                            <div class="game-type-text" onclick="gotoChallenge('/share')">
                                <h3>Поделиться ссылкой</h3>
                                <p>Получите ссылку, отправьте ее другу и соревнуйтесь прямо сейчас!</p>
                            </div>
                        </div>
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
    function showChallengeModal() {
        $(".challenge-modal").modal("show");
    }

    function gotoChallenge(type){
        window.location.href = 'challenge'+type;
    }
</script>