
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* パーティーの並び替え
* @function sortable
* @return void
**/
var sortPartyInit = function(){
    $('[data-list="party"]').sortable({
        // 並び替え完了後に並び替えボタンを有効家
        update: function(){
            var submit = $('form#party-order-sort-form button[type="submit"]');
            submit.prop('disabled', false)
            .removeClass('btn-secondary')
            .addClass('btn-primary');
        }
    });
}

/**
* パーティーの並び替え情報を送信
* @function submit
* @return void
**/
var submitPartyOrderSortInit = function(){
    $('form#party-order-sort-form').submit(function(){
        // 並び順を配列で取得
        var orders = [];
        $('[data-list="party"] > .row[data-order]').each(function(){
            orders.push(
                $(this).data('order')
            );
        });
        // 並び順配列のJSONをセット
        $(this).find('[name="orders"]')
        .val(
            JSON.stringify(orders)
        );
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    sortPartyInit();
    submitPartyOrderSortInit();
});
