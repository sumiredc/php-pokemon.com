
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* ロード中スピナーの表示
* @function on beforeunload
* @return void
**/
var showItemModalDetailInit = function(){
    $('.item-row').on('click', function(){
        var category = $(this).data('category');
        var name = $(this).data('name');
        var description = $(this).data('description');
        // 詳細に表示
        $('#item-modal-' + category + '-name').text(name);
        $('#item-modal-' + category + '-description').text(description);
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    showItemModalDetailInit();
});
