/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
var supportedFlag = $.keyframe.isSupported();
// 自動メッセージ判定用
var auto_msg;
// メッセージボックスのクリック判定用
var click_flg = true;
// ページ判別用ID
var page_id = $('meta[name="page-id"]').attr('content');

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
    // 変数をリセット
    auto_msg = false;
    $('[data-controls="message-box"]').on('click', async function(){
        if(
            // 連続クリック防止
            click_flg === false ||
            (
                // モーダルの消失回避
                $('.result-message.active').data('toggle') === 'modal' &&
                $(this).data('dismiss') !== 'modal'
            )
        ){
            return;
        }
        $(".message-scroll-icon").hide();
        // メッセージボックスを処理終了まで無効化
        click_flg = false;
        // 現在のメッセージ
        var now = $('.result-message.active');
        await actionMsgBox(now);
        // 次がオートメッセージの場合は再度実行
        while(auto_msg){
            now = now.next();
            await actionMsgBox(now);
        }
        // メッセージボックスを有効可
        click_flg = true;
    });
}

/**
* メッセージボックス内の進化キャンセルボタン
* @function click
* @return void
**/
var clickCancelEvolveInit = function(){
    $('#cancel-evolve').on('click', async function(){
        // 自身のボタンを非表示化
        $(this).hide()
        // アニメーションの強制終了(コールバックを無効化)
        $('#pokemon-after').resetKeyframe(function(){});
        $('#pokemon-after').css('opacity', 0);
        await nextMsg($('.result-message.active'));
        // cancelボタンで発火しないように１秒後にメッセージボックスを有効可
        setTimeout(function() {
            click_flg = true;
        }, 1000);
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
            switch (page_id + '-' + now.data('action')){
                // ==============================================
                // バトル開始演出 ===============================
                case 'battle-start':
                await window.battleLib
                .doAnimateStart(now.data('target'));
                break;
                // ==============================================
                // HPバーの処理 =================================
                case 'battle-hpbar':
                await window.battleLib
                .doAnimateHpBar(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 状態異常処理 =================================
                case 'battle-sa':
                await window.battleLib
                .doAnimateSa(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 状態異常解除 =================================
                case 'battle-sa-release':
                await window.battleLib
                .doAnimateSaRelease(now.data('target'));
                break;
                // ==============================================
                // へんしん処理 =================================
                case 'battle-transform':
                await window.battleLib
                .doAnimateTransform(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 交代処理（戻す） =============================
                case 'battle-change-in':
                await window.battleLib
                .doAnimateChangeIn(now.data('target'));
                break;
                // ==============================================
                // 交代処理（登場） =============================
                case 'battle-change-out':
                await window.battleLib
                .doAnimateChangeOut(now.data('target'), now.data('param'));
                break;
                // ==============================================
                // 経験値バーの処理 =============================
                case 'battle-expbar':
                await window.battleLib
                .doAnimateExpBar(now.data('param'));
                break;
                // ==============================================
                // レベルアップ処理 =============================
                case 'battle-levelup':
                await window.battleLib
                .doAnimateLevelUp(now.data('param'));
                break;
                // ==============================================
                // 捕獲処理 =====================================
                case 'battle-capture':
                await window.battleLib
                .doAnimateCapture(now.data('param'));
                break;
                // ==============================================
                // 瀕死処理 =====================================
                case 'battle-fainting':
                await window.battleLib
                .doAnimateFainting(now.data('target'));
                break;
                // ==============================================
                // 進化アニメーション ===========================
                case 'evolve-evolve':
                $('#cancel-evolve').show()
                await window.evolveLib
                .doAnimateEvolve();
                break;
                // ==============================================
                // 進化キャンセル ===============================
                case 'evolve-cancel':
                $('#remote-form-action').val('cancel');
                $('#remote-form').submit();
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
    return new Promise ((resolve, reject) => {
        // スクロールアイコンを非表示
        $('.message-scroll-icon').hide();
        // =====================================================
        // 進化画面用の処理 ====================================
        //
        if(page_id === 'evolve'){
            // 終了
            $('#remote-form-action').val('');
            setTimeout(function() {
                // 5秒後画面移管のためリモートフォームを空送信
                $('#remote-form').submit();
            }, 500);
        }
        // =====================================================
        // バトル画面用の処理 ==================================
        //
        if(page_id === 'battle'){
            // 操作ボタンの有効化
            $('.action-btn, .action-img-btn').prop('disabled', false);
            // ボタンに色付け
            $('.action-btn').each(function(){
                $(this).removeClass('btn-disabled')
                .addClass('btn-php-dark');
            });
        }
        resolve();
    });
}

/**
* 最終メッセージではない場合の処理
* @return void
*/
var doNotLastMsg = function(){
    // スクロールアイコンを非表示
    $('.message-scroll-icon').show();
    // =====================================================
    // バトル画面用の処理 ==================================
    //
    if(page_id === 'battle'){
        // 操作ボタンの無効化
        $('.action-btn, .action-img-btn').prop('disabled', true);
        // ボタンの色消し
        $('.action-btn').each(function(){
            $(this).removeClass('btn-php-dark')
            .addClass('btn-disabled');
        });
    }
}

/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    startInit();
    clickMsgBoxInit();
    clickCancelEvolveInit();
});
