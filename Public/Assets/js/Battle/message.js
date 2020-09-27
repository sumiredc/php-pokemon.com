/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* 画面読み込み時の関数
* @function ready
* @return void
**/
var startInit = function(){
    // 現在のメッセージ
    var now = $('.result-message.active');
    if((now.length === 0) || now.hasClass('last-message')){
        doLastMsg();
        return;
    }
    doNotLastMsg();
}

/**
* メッセージボックスクリック時の関数
* @function click
* @return void
**/
var clickMsgBoxInit = function(){
    $('.message-box').click(function(){
        // 現在のメッセージ
        var now = $('.result-message.active');
        // 最終メッセージかどうか確認
        if((now.length === 0) || now.hasClass('last-message')){
            doLastMsg();
            return;
        }
        // 現在のメッセージのactiveを解除
        now.removeClass('active');
        // 次のメッセージにactiveを付与
        var next = now.next();
        next.addClass('active');
        /**
        * メッセージのステータスに合わせた分岐
        **/
        // バトル終了
        if(next.hasClass('battle-end')){
            $('#remote-form-action').val('end');
            return $('#remote-form').submit();
        }
        // 最終メッセージ
        if(next.hasClass('last-message')){
            doLastMsg();
            return;
        }
        // どれにも該当しない
        doNotLastMsg();
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/

/**
* 最終メッセージの処理
* @return void
**/
var doLastMsg = function(){
    // スクロールアイコンを非表示
    $('.message-scroll-icon').hide();
    // 操作ボタンの無効化解除
    $('.action-btn').prop('disabled', false);
    // ボタンに色付け
    $('.action-btn').each(function(){
        $(this).removeClass('btn-outline-light');
        $(this).addClass('btn-outline-success');
    });
}

/**
* 最終メッセージではない場合の処理
* @return void
**/
var doNotLastMsg = function(){
    // スクロールアイコンを非表示
    $('.message-scroll-icon').show();
    // 操作ボタンの無効化
    $('.action-btn').prop('disabled', true);
    // ボタンの色消し
    $('.action-btn').each(function(){
        $(this).removeClass('btn-outline-success');
        $(this).addClass('btn-outline-light');
    });
}


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    startInit();
    clickMsgBoxInit();
});
