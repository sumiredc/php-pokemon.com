
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

/**
 * 二重モーダルを正常に表示するための重ね処理
 *
 * @function on show modal
 */
var dubbleModalInit = function() {
    $(document).ready(function() {
        $('[data-dubble_modal="true"]').on("show.bs.modal", function(e) {
            var currentModal = $(e.currentTarget);
            var zIndex = 1040 + 10 * $(".modal:visible").length;
            currentModal.css("z-index", zIndex);
            setTimeout(function() {
                $(".modal-backdrop")
                    .not(".modal-stack")
                    .css("z-index", zIndex - 1)
                    .addClass("modal-stack");
            }, 0);
        });
    });
}

/**
 * リモートフォームへのサブミット
 *
 * @function on show modal
 */
var submitRemoteInit = function() {
    $('[data-submit_remote]').on('click', function(){
        $("#remote-form-action").val($(this).data('submit_remote'))
        $('form#remote-form').submit();
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
    dubbleModalInit();
    submitRemoteInit();
});
