/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
var supportedFlag = $.keyframe.isSupported();
// 自動メッセージ判定用
var auto_msg;
// メッセージボックスのクリック判定用
var click_flg;

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
    click_flg = true;
    // 変数をリセット
    auto_msg = false;
    $('.action-message-box').on('click', async function(){
        if(click_flg === false) return;
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
* 進化キャンセルボタン
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
**/
var actionMsgBox = function(now){
    return new Promise( async (resolve, reject) => {
        // 最終メッセージかどうか確認
        if((now.length === 0) || now.hasClass('last-message')){
            await doLastMsg();
        }else{
            // メッセージにアクションがセットされていれば実行
            switch (now.data('action')){
                // ==============================================
                // 進化アニメーション ===========================
                //
                case 'evolve':
                $('#cancel-evolve').show()
                await evolvePokemon();
                break;
                // ==============================================
                // 進化キャンセル ===============================
                //
                case 'cancel':
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

// ==============================================
// 進化演出 =====================================
//
/**
* 5秒間の進化アニメーション
* @param mixed param
* @return Promise
**/
var evolvePokemon = function(param){
    return new Promise ((resolve, reject) => {
        var keyframe = {};
        var per = 100;
        var opacity = 0;
        while (per) {
            if(opacity){
                keyframe[per + '%'] = {opacity: 0};
                opacity = 0;
            }else{
                keyframe[per + '%'] = {opacity: 1};
                opacity = 1;
            }
            per -= 3;
            if(per < 0){
                per = 0;
            }
        }
        keyframe['0%'] = {opacity: 1};
        keyframe.name = 'evolve-animation';
        // キーフレームの用意
        $.keyframe.define(keyframe);
        // 経験値バーのアニメーション
        $('#pokemon-after').playKeyframe({
            name: 'evolve-animation',
            duration: '5000ms',
            timingFunction: 'ease',
            delay: '0s',
            iterationCount: 1, // 繰り返し回数
            direction: 'normal',
            fillMode: 'forwards',
            complete: function(){
                $('#cancel-evolve').hide()
                $('#remote-form-action').val('evolve');
                $('#remote-form').submit();
            }
        });
    });
}

// ==============================================

/**
* 次のメッセージへ移行する処理
* @param now element
* @return Promise
**/
var nextMsg = function(now){
    return new Promise( async (resolve, reject) => {
        // 現在のメッセージのactiveを解除
        now.removeClass('active');
        // 次のメッセージにactiveを付与
        var next = now.next();
        next.addClass('active');
        /**
        * メッセージのステータスに合わせた分岐
        **/
        // 最終メッセージかどうかの判別
        if(next.hasClass('last-message')){
            // 最終メッセージ
            await doLastMsg();
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
**/
var doLastMsg = function(){
    // スクロールアイコンを非表示
    $('.message-scroll-icon').hide();
    // 終了
    $('#remote-form-action').val('');
    setTimeout(function() {
        $('#remote-form').submit();
    }, 500);
}

/**
* 最終メッセージではない場合の処理
* @return void
**/
var doNotLastMsg = function(){
    // スクロールアイコンを表示
    $('.message-scroll-icon').show();
}

/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    startInit();
    clickMsgBoxInit();
    clickCancelEvolveInit();
});
