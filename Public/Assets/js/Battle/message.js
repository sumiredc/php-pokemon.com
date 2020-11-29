/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
var supportedFlag = $.keyframe.isSupported();
// 自動メッセージ判定用
var auto_msg;

/**
* 画面読み込み時の関数
* @function ready
* @return void
*/
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
*/
var clickMsgBoxInit = function(){
    var click = true;
    // 変数をリセット
    auto_msg = false;
    $('[data-controls="message-box"]').on('click', async function(){
        if(click === false) return;
        $(".message-scroll-icon").hide();
        // メッセージボックスを処理終了まで無効化
        click = false;
        // 現在のメッセージ
        var now = $('.result-message.active');
        await actionMsgBox(now);
        // 次がオートメッセージの場合は再度実行
        while(auto_msg){
            now = now.next();
            await actionMsgBox(now);
        }
        // メッセージボックスを有効可
        click = true;
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/
/**
* メッセージアクション
* @param now element
* @return Promise
*/
var actionMsgBox = function(now){
    return new Promise( async (resolve, reject) => {
        // 最終メッセージかどうか確認
        if((now.length === 0) || now.hasClass('last-message')){
            await doLastMsg();
        }else{
            // メッセージにアクションがセットされていれば実行
            switch (now.data('action')){
                // ==============================================
                // バトル開始演出 ===============================
                case 'start':
                await window.actionLib
                .doAnimateStart(now.data('target'));
                break;
                // ==============================================
                // HPバーの処理 =================================
                case 'hpbar':
                await window.actionLib
                .doAnimateHpBar(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 状態異常処理 =================================
                case 'sa':
                await window.actionLib
                .doAnimateSa(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 状態異常解除 =================================
                case 'sa-release':
                await window.actionLib
                .doAnimateSaRelease(now.data('target'));
                break;
                // ==============================================
                // へんしん処理 =================================
                case 'transform':
                await window.actionLib
                .doAnimateTransform(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 交代処理（戻す） =============================
                case 'change-in':
                await window.actionLib
                .doAnimateChangeIn(now.data('target'));
                break;
                // ==============================================
                // 交代処理（登場） =============================
                case 'change-out':
                await window.actionLib
                .doAnimateChangeOut(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 経験値バーの処理 =============================
                case 'expbar':
                await window.actionLib
                .doAnimateExpBar(now.data('param'));
                break;
                // ==============================================
                // レベルアップ処理 =============================
                case 'levelup':
                await window.actionLib
                .doAnimateLevelUp(now.data('param'));
                break;
                // ==============================================
                // 捕獲処理 =====================================
                case 'capture':
                await window.actionLib
                .doAnimateCapture(now.data('param'));
                break;
                // ==============================================
                // 瀕死処理 =====================================
                case 'fainting':
                await window.actionLib
                .doAnimateFainting(now.data('target'));
                break;
            }
            // 次のメッセージへ
            await nextMsg(now);
        }
        resolve();
    });
}

/**
* 次のメッセージへ移行する処理
* @param now element
* @return Promise
*/
var nextMsg = function(now){
    return new Promise( async (resolve, reject) => {
        // 現在のメッセージのactiveを解除
        now.removeClass('active');
        // 次のメッセージにactiveを付与
        var next = now.next();
        next.addClass('active');
        /**
        * メッセージのステータスに合わせた分岐
        */
        // バトル終了
        if(next.hasClass('battle-end')){
            $('#remote-form-action').val('end');
            setTimeout(function() {
                $('#remote-form').submit();
            }, 500);
            return;
        }
        // 最終メッセージかどうかの判別
        if(next.hasClass('last-message')){
            // 最終メッセージ
            doLastMsg();
        }else{
            // 最終メッセージではない
            doNotLastMsg();
        }
        // 次のメッセージがオートメッセージかどうかの判定
        if(next.data('auto')){
            auto_msg = true;
        }else{
            auto_msg = false;
        }
        // 処理終了
        resolve();
    });
}

/**
* 最終メッセージの処理
* @return void
*/
var doLastMsg = function(){
    // スクロールアイコンを非表示
    $('.message-scroll-icon').hide();
    // 操作ボタンの有効化
    $('.action-btn, .action-img-btn').prop('disabled', false);
    // ボタンに色付け
    $('.action-btn').each(function(){
        $(this).removeClass('btn-disabled')
        .addClass('btn-php-dark');
    });
}

/**
* 最終メッセージではない場合の処理
* @return void
*/
var doNotLastMsg = function(){
    // スクロールアイコンを非表示
    $('.message-scroll-icon').show();
    // 操作ボタンの無効化
    $('.action-btn, .action-img-btn').prop('disabled', true);
    // ボタンの色消し
    $('.action-btn').each(function(){
        $(this).removeClass('btn-php-dark')
        .addClass('btn-disabled');
    });
}

/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    startInit();
    clickMsgBoxInit();
});
