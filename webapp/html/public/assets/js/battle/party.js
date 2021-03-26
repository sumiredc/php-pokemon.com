
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* ポケモンの選択
* @function on.click
* @return void
**/
var selectPartnerInit = function(){
    $('[data-list="party"] > .table-selected-row').on('click', function(){
        var order = $(this).data('order');
        var fight = $(this).data('fight');
        // 「入れ替える」の判定
        var change_btn = $('#partner-change-form button[type="submit"]');
        // 現在バトル中のポケモン番号異なり、戦闘可能
        if(
            order !== change_btn.data('selected') &&
            fight
        ){
            // 入れ替えボタンを有効化してinputに番号をセット
            change_btn.prop('disabled', false)
            .removeClass('btn-disabled')
            .addClass('btn-php-dark');
            $('#partner-change-form [name="order"]').val(order);
        }else{
            // 入れ替えボタンを無効化して番号をリセット
            change_btn.prop('disabled', true)
            .removeClass('btn-php-dark')
            .addClass('btn-disabled');
            $('#partner-change-form [name="order"]').val('');
        }
        // 「様子を見る」の判定
        $('button[data-action="details"]').hide();
        $('button[data-action="details"][data-order="' + order + '"]').show();
    });
}

/**
* モーダル起動時の初期化
* @function change
* @return void
**/
var showPartyModalInit = function(){
    $('#party-modal').on('show.bs.modal', function(){
        // 選択中のポケモンを初期化
        $(this).find('[data-list="party"] > .table-selected-row')
        .removeClass('active');
        // 「様子を見る」を初期化
        $(this).find('button[data-action="details"]')
        .hide();
        $(this).find('[data-btn="default"][data-action="details"]')
        .show();
        // 「入れ替える」を初期化
        $('#partner-change-form button[type="submit"]').prop('disabled', true)
        .removeClass('btn-php-dark')
        .addClass('btn-disabled');
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    selectPartnerInit();
    showPartyModalInit();
});
