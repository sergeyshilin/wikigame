<div class="modal fade hitler-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Гитлер</h4>
            </div>
            <div class="modal-body">
                <div class="game-type-grid" style="color: #000; text-shadow: none">
                    <div class="row row-eq-height">
                        <div class="game-type col-sm-4">
                            <img src="application/images/game_types/wki_icon-05.png" class="invert" onclick="gotoHitler()">
                            <div class="game-type-text" onclick="gotoCustom('wiki/Main_Page')">
                                <h3>Стандартный</h3>
                                <p>Доберитесь до Гитлера любой ценой!</p>
                            </div>
                        </div>
                        <div class="game-type col-sm-4">
                            <img src="application/images/game_types/wki_icon-05.png" class="invert" onclick="gotoHitler()">
                            <div class="game-type-text" onclick="gotoCustom('one_minute')">
                                <h3>Без Германии</h3>
                                <p>Доберитесь до Гитлера, не используя Германию</p>
                            </div>
                        </div>
                        <div class="game-type col-sm-4">
                            <img src="application/images/game_types/wki_icon-05.png" class="invert" onclick="gotoHitler()">
                            <div class="game-type-text" onclick="gotoCustom('challenge')">
                                <h3>За 5 переходов</h3>
                                <p>Доберитесь до Гитлера ровно за 5 переходов</p>
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
    function showHitlerModal() {
        $(".hitler-modal").modal("show");
    }
    
    function gotoHitler() {
        window.location.href = 'hitler';
    }
</script>