
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* ロード中スピナーの表示
* @function on beforeunload
* @return void
**/
var nowLoadingInit = function(){
    $(window).on('beforeunload', function() {
        $('.now-loading').show();
    });
}
/**
* 技テーブルクリック時の関数
* @function click
* @return void
**/
var navMoveBoxInit = function(){
    $('.move-detail-link').on('click', function(){
        var target = $(this).data('target');
        $('.move-detail-link').each(function(){
            $(this).removeClass('active');
        });
        $('.move-detail-content').each(function(){
            $(this).removeClass('active');
        });
        $(this).addClass('active');
        $(target).addClass('active');
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    nowLoadingInit();
    navMoveBoxInit();
});
