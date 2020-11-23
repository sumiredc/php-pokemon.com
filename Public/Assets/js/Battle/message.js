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
                // 状態異常処理 =================================
                //
                case 'sa':
                await doAnimateSa(
                    now.data('target'),
                    now.data('param')
                );
                break;
                // ==============================================
                // へんしん処理 =================================
                //
                case 'transform':
                await doAnimateTransform(
                    now.data('target'),
                    now.data('param')
                );
                // ==============================================
                // 捕獲処理 =====================================
                //
                case 'capture':
                await doAnimateCapture(
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
// 状態異常処理 =================================
/**
* 状態異常をセット
* @param json
* @return Promise
**/
var doAnimateSa = function (target, param){
    return new Promise ((resolve, reject) => {
        var badge = $('#sa-' + target);
        badge.removeClass("badge-");
        badge.addClass("badge-" + param.color);
        badge.text(param.name);
        resolve();
    });
}

// ==============================================
// へんしん処理 =================================
/**
* @param json
* @return Promise
**/
var doAnimateTransform = function (target, param){
    return new Promise ((resolve, reject) => {
        // 対象のポケモン画像を指定
        var img = $('#' + target + '-pokemon-image');
        // へんしん前のポケモンクラスを取得
        var before = img.data('pokemon');
        // srcを書き換える
        var src = img.attr('src').replace(before, param);
        img.attr('src', src);
        resolve();
    });
}

// ==============================================
// 捕獲処理 =====================================
/**
* @param integer
* @return Promise
**/
var doAnimateCapture = function (param){
    return new Promise ((resolve, reject) => {
        // ボール画像を取得
        var ball = $($('#template-effect-ball').html());
        ball.attr('src', param.src);
        $('#battle-field').prepend(ball);
        // キーフレームの用意
        var l = 25;
        var t = 15;
        var keyframes  = {
            name: 'throw-ball'
        };
        for (var i = 0; i <= 100; i++) {
            var left = l + (i / 2);                          // x座標
            var top = t + 100 ** ((100 - i + 1) / 100) / 2;  // y座標(累乗で山なりにする)
            var rotate = 3.6 * i * 1.5 - 180;                // 回転率
            var per = i + '%';
            keyframes[per] = {
                transform: 'translateY(-50%) translateX(-50%) rotate(' + rotate + 'deg)',
                left: left + '%',
                top: top + '%'
            };
            // 最後の基準Y値は、揺れ処理用に合わせて-100%にする
            if(i === 100){
                keyframes[per].transform = 'translateY(-100%) translateX(-50%) rotate(' + rotate + 'deg)';
            }
        }
        $.keyframe.define(keyframes);
        // ボールスローアニメーション
        ball.show();
        ball.playKeyframe({
            name: 'throw-ball',
            duration: '750ms',
            timingFunction: 'ease',
            delay: '0s',
            iterationCount: 1, // 繰り返し回数
            direction: 'normal',
            fillMode: 'forwards',
            complete: async function(){
                // ボールエフェクト
                ball.hide();
                $('#battle-field').append(
                    $($('#template-effect-ball-open').html())
                );
                await timer(500);
                // 相手ポケモンを非表示
                ball.show();
                $('img.capture-ball.open').hide();
                $('#enemy-pokemon-image').hide();
                // 揺れ演出
                await shakeBall(ball, param.shake);
                if(param.shake >= 4){
                    // 捕獲成功
                    await timer(1000);
                    resolve();
                }else{
                    // 捕獲失敗
                    // ボールエフェクト
                    ball.remove();
                    $('#battle-field').append(
                        $('#template-effect-ball-open').html()
                    );
                    // 相手ポケモンを表示
                    $('#enemy-pokemon-image').show();
                    await timer(500);
                    // 非表示
                    $('img.capture-ball.open').hide();
                    await timer(500);
                    resolve();
                }
            }
        });
    });
}
/**
* 揺れアニメーション
* @param ball:element
* @param count:integer
* @return Promise
**/
var shakeBall = function(ball, count){
    return new Promise ((resolve, reject) => {
        $.keyframe.define({
            name: 'shake-ball',
            '0%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(0deg)'
            },
            '20%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(45deg)'
            },
            '40%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(-45deg)'
            },
            '60%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(0deg)'
            },
        });
        ball.playKeyframe({
            name: 'shake-ball',
            duration: '1000ms',
            timingFunction: 'ease',
            delay: '500ms',
            iterationCount: count, // 繰り返し回数
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
    $('.action-btn, .action-img-btn').prop('disabled', false);
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
    $('.action-btn, .action-img-btn').prop('disabled', true);
    // ボタンの色消し
    $('.action-btn').each(function(){
        $(this).removeClass('btn-outline-success');
        $(this).addClass('btn-outline-light');
    });
}

/**
* タイマー
* @param time:integer
* @return Promise
**/
var timer = function(time){
    return new Promise( async (resolve, reject) => {
        setTimeout(() => { resolve(); }, time);
    });
}


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    startInit();
    clickMsgBoxInit();
});
