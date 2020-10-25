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
    var click = true;
    // 変数をリセット
    auto_msg = false;
    $('.action-message-box').on('click', async function(){
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
                // HPバーの処理 =================================
                //
                case 'hpbar':
                await doAnimateHpBar(
                    now.data('target'),
                    now.data('param')
                );
                break;
                // ==============================================
                // 経験値バーの処理 =============================
                //
                case 'expbar':
                await doAnimateExpBar(
                    now.data('param')
                );
                break;
                // ==============================================
                // レベルアップ処理 =============================
                //
                case 'levelup':
                await doAnimateLevelUp(
                    now.data('param')
                );
                break;
                // ==============================================
            }
            // 次のメッセージへ
            await nextMsg(now);
        }
        resolve();
    });
}

// ==============================================
// HPバーの処理 =================================
//
/**
* HPバーのアニメーションを実行
* @param string target
* @param mixed param
* @param now element
* @return Promise
**/
var doAnimateHpBar = function(target, param){
    return new Promise((resolve, reject) => {
        // 対象のHPバーを取得
        var hpbar = $('#hpbar-' + target);
        var hp = hpbar.attr('aria-valuenow') - param;
        // 最小値の処理
        if(hp < 0){
            hp = 0;
        }
        // 最大値の処理
        if(hp > hpbar.attr('aria-valuemax')){
            hp = hpbar.attr('aria-valuemax');
        }
        // 処理後のHPバーの長さを算出
        var width = hp / hpbar.attr('aria-valuemax') * 100;
        // キーフレームの用意
        $.keyframe.define({
            name: target + 'hpbar-animation',
            from: {
                width: hpbar.width()
            },
            to: {
                width: width + '%'
            }
        });
        // 非同期1
        var promise1 = new Promise((resolve, reject) => {
            // 長さを変更
            hpbar.playKeyframe({
                name: target + 'hpbar-animation',
                duration: '1000ms',
                timingFunction: 'ease',
                delay: '0s',
                iterationCount: 1, // 繰り返し回数
                direction: 'normal',
                fillMode: 'forwards',
                complete: function(){
                    // 処理完了(css変更のズレがあるため0.5秒後にresolveを返却)
                    if(target === 'friend'){
                        // HPバーの色チェック
                        hpbar.removeClass('bg-success bg-warning bg-danger');
                        if(width <= 20){
                            hpbar.addClass('bg-danger');
                        }else if(width <= 50){
                            hpbar.addClass('bg-warning');
                        }else{
                            hpbar.addClass('bg-success');
                        }
                    }
                    setTimeout(function() {
                        resolve();
                    }, 500);
                }
            });
        });
        // 非同期2
        var promise2 = new Promise( async (resolve, reject) => {
            // HPカウンターのアニメーション
            if(target === 'friend'){
                // 引数は数値でセット
                await countHp(
                    parseInt(hpbar.attr('aria-valuenow'), 10),
                    parseInt(hp, 10)
                );
            }
            return resolve();
        });
        Promise.all([promise1, promise2]).then(() => {
            // 残HPの値を変更
            hpbar.attr('aria-valuenow', hp);
            return resolve();
        });
        // ==============================================
    });
}

/**
* HPの数値カウント処理
* @param integer start
* @param integer end
* @return Promise
**/
var countHp = function(start, end){
    return new Promise((resolve, reject) => {
        // もし開始と終了が同じであれば処理不要
        var diff = start - end;
        if(diff === 0){
            return resolve();
        }
        // 数値の変動処理関数
        var counter = function(){
            // 実行回数が＋かーかで数値の変動方向を判定
            if((start - end) > 0){
                // 減算（ダメージ）
                start--;
            }else{
                // 加算（回復）
                start++;
            }
            $('#remaining-hp-count-friend').text(start);
        }
        // 繰り返し関数
        var time = parseInt(1000 / diff, 10);
        // 0.3秒後にカウントスタート
        setTimeout(function() {
            var interval_id = setInterval(function(){
                counter();
                if(start === end){
                    clearInterval(interval_id);
                    return resolve();
                }
            }, time);
        }, 300);
    });
}

// ==============================================
// 経験値バーの処理 =============================
//
/**
* 経験値バーのアニメーションを実行
* @param mixed param
* @return Promise
**/
var doAnimateExpBar = function(param){
    return new Promise ((resolve, reject) => {
        var expbar = $("#expbar");
        // EXPの現在の値を変更
        expbar.attr('aria-valuenow', param);
        // キーフレームの用意
        $.keyframe.define({
            name: 'expbar-animation',
            from: {
                width: expbar.width()
            },
            to: {
                width: param + '%'
            }
        });
        // 経験値バーのアニメーション
        expbar.playKeyframe({
            name: 'expbar-animation',
            duration: '1000ms',
            timingFunction: 'ease',
            delay: '0s',
            iterationCount: 1, // 繰り返し回数
            direction: 'normal',
            fillMode: 'forwards',
            complete: function(){
                setTimeout(function() {
                    resolve();
                }, 500);
            }
        });
    });
}

// ==============================================
// レベルアップ処理 =============================
//
/**
* 経験値バーのアニメーションを実行
* @param json
* @return Promise
**/
var doAnimateLevelUp = function(param){
    return new Promise ((resolve, reject) => {
        var expbar = $("#expbar");
        // アニメーションをリセット
        expbar.resetKeyframe(function(){});
        expbar.hide();
        expbar.css('width', 0);
        // レベルアップ
        $("#level").text(param.level);
        // HPバーの変更
        var hpbar = $("#hpbar-friend");
        hpbar.attr('aria-valuenow', param.remaining_hp);
        hpbar.attr('aria-valuemax', param.max_hp);
        // 表示されているHPを変更
        $('#remaining-hp-count-friend').text(param.remaining_hp);
        $('#max-hp-count-friend').text(param.max_hp);
        hpbar.css('width', param.remaining_hp_per + '%');
        // 経験値バーをリセット
        expbar.stop()
        .animate({
            width: 0
        }, {
            duration: 1,
            easing: 'linear',
            complete: function(){
                // 処理完了(css変更のズレがあるため0.5秒後にresolveを返却)
                setTimeout(function() {
                    expbar.show();
                    resolve();
                }, 500);
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
