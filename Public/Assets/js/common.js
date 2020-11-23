
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
        // 一旦全てのactiveを解除
        $('.move-detail-content, .move-detail-link').each(function(){
            $(this).removeClass('active');
        });
        // 選択された行と詳細のみをactive化
        $(target).addClass('active');
        $(this).addClass('active');
    });
}

/**
* table-selectedクリック時の関数
* @function click
* @return void
**/
var selectedTableInit = function(){
    $('table.table-selected tbody tr, .table-selected > .table-selected-row').on('click', function(){
        var target = $(this).data("target");
        // 行の色替え
        var children;
        if($(this).prop("tagName") === 'TR'){
            // テーブル要素
            children = 'tbody tr';
        }else if($(this).hasClass('table-selected-row')){
            // テーブル要素以外
            children = '.table-selected-row';
        }
        // 子要素が指定されていなければ処理不要
        if(!children){
            return;
        }
        $(this).closest('.table-selected').find(children)
        .each(function(){
            $(this).removeClass('active');
        });
        $(this).addClass('active');
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
 * 強制モーダルの起動
 * @function modal
 */
var showForceModalInit = function(){
    $(document).ready(function() {
        var force_modal = $('#force-modal');
        if(force_modal.length){
            $(force_modal.val()).modal('show');
        }
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
    selectedTableInit();
    dubbleModalInit();
    submitRemoteInit();
    showForceModalInit();
});
