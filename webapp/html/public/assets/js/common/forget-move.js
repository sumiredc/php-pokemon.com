/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/

/**
* 忘れさせる技選択時の関数
* @function click
* @return void
**/
var selectForgetMoveInit = function(){
    $('.forget-selectmove').on('click', function(){
        var modal = $(this).data('modal');
        // 諦めるボタンの無効化切り替え
        if($(this).hasClass('new-move')){
            $(modal).find(".btn-abandon-move")
            .removeClass('btn-disabled')
            .addClass('btn-secondary')
            .prop('disabled', false);
            $(modal).find('.btn-forget-move')
            .hide();
            return;
        }else{
            $(modal).find(".btn-abandon-move")
            .removeClass('btn-secondary')
            .addClass('btn-disabled')
            .prop('disabled', true);
        }
        // 技名を取得
        var name = $(this).data('name');
        // ボタンに技名をセット
        $(modal).find('.btn-forget-move .move-name')
        .text(name);
        $(modal).find('.btn-forget-move')
        .show();
    });
}

/**
* 忘れさせるボタンを押したときの関数
* @function click
* @return void
**/
var submitForgetMoveInit = function(){
    $('.btn-forget-move').on('click', function(){
        var modal = $(this).data('modal');
        // 技をフォームへセット
        var data = {
            id: $(this).data('msg_id'),
            forget: $(modal).find('.forget-selectmove.active').data('num'),
            level: $('#level-friend').text(),
            hp: $('#hpbar-friend').attr('aria-valuenow')
        };
        // フォームを用意
        $.each(data, function(key, val){
            // フォームの最初にパラメーターを追加
            $('#remote-form').append(
                '<input type="hidden" name="param[' + key + ']" value="' + val + '">'
            );
        })
        // サブミット実行
        $('#remote-form-action').val('learn_move');
        $('#remote-form').submit();
    });
}


/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    selectForgetMoveInit();
    submitForgetMoveInit();
});
