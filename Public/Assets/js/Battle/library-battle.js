// グローバル関数をオブジェクト化
window.battleLib = {};

/*----------------------------------------------------------
// グローバル化する関数
----------------------------------------------------------*/

/**
* バトル開始
* @param target:string
* @return Promise
*/
window.battleLib.doAnimateStart = function (target){
    return new Promise ( async (resolve, reject) => {
        // ボールが開くエフェクト
        $('#battle-field').append(
            $($('#template-effect-ball-open').html())
            .addClass('friend')
        );
        await timer(500);
        // ボールエフェクトを非表示
        $('img.capture-ball-open').hide();
        // 画像とパラメーターを表示
        $('#' + target + '-pokemon-image').removeClass('opacity-0');
        $('#' + target + '-pokemon-parameter').removeClass('opacity-0');
        await timer(1000);
        resolve();
    });
}

/**
* HPバーのアニメーションを実行
* @param string target
* @param mixed param
* @param now element
* @return Promise
*/
window.battleLib.doAnimateHpBar = function(target, param){
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
    });
}

/**
* 状態異常をセット
* @param json
* @return Promise
*/
window.battleLib.doAnimateSa = function (target, param){
    return new Promise ((resolve, reject) => {
        var badge = $('#sa-' + target);
        badge.removeClass("badge-");
        badge.addClass("badge-" + param.color);
        badge.text(param.name);
        resolve();
    });
}

/**
* 状態異常の解除
* @param
* @return Promise
*/
window.battleLib.doAnimateSaRelease = function (target){
    return new Promise ((resolve, reject) => {
        $('#sa-' + target).remove();
        resolve();
    });
}

/**
* へんしん処理
* @param json
* @return Promise
*/
window.battleLib.doAnimateTransform = function (target, param){
    return new Promise ((resolve, reject) => {
        // 対象のポケモン画像を変更
        var img = $('#' + target + '-pokemon-image').attr('src', param);
        resolve();
    });
}

/**
* 交代処理（戻す）
* @param json
* @return Promise
*/
window.battleLib.doAnimateChangeIn = function (target){
    return new Promise ((resolve, reject) => {
        // 対象のポケモン画像とパラメーターを非表示
        $('#' + target + '-pokemon-image').addClass('opacity-0');
        $('#' + target + '-pokemon-parameter').addClass('opacity-0');
        resolve();
    });
}

/**
* 交代処理（登場）
* @param json
* @return Promise
*/
window.battleLib.doAnimateChangeOut = function (target, param){
    return new Promise ( async (resolve, reject) => {
        // 交代後のポケモンの画像を生成
        var img = $('#' + target + '-pokemon-image');
        img.attr('src', param.base64)
        // HPの生成
        var hpbar = $('#hpbar-' + target);
        hpbar.css('width', param.hp_per + '%');
        hpbar.attr('aria-valuenow', param.hp_now);
        hpbar.attr('aria-valuemax', param.hp_max);
        hpbar.removeClass(function(index, className) {
            // 背景色クラスを全リセット
            return (className.match(/\bbg-\S+/g) || []).join(' ');
        });
        hpbar.addClass('bg-' + param.hp_color);
        $('#remaining-hp-count-' + target).text(param.hp_now);
        $('#max-hp-count-' + target).text(param.hp_max);
        // 状態異常の生成
        var sa = $('#sa-' + target);
        sa.text('');
        if(param.sa){
            sa.text(param.sa)
            .removeClass(function(index, className) {
                // バッジ色クラスを全リセット
                return (className.match(/\bbadge-\S+/g) || []).join(' ');
            })
            .addClass('badge-' + param.sa_color);
        }
        // レベル・名前
        $('#level-friend').text(param.level);
        $('#name-friend').text(param.name);
        // 経験値
        var expbar = $('#expbar-friend');
        expbar.css('width', param.exp + '%');
        expbar.attr('aria-valuenow', param.exp);
        // ボールが開くエフェクト
        $('#battle-field').append(
            $($('#template-effect-ball-open').html())
            .addClass('friend')
        );
        await timer(500);
        // ボールエフェクトを非表示
        $('img.capture-ball-open').hide();
        // 画像とパラメーターを表示
        img.removeClass('opacity-0');
        $('#' + target + '-pokemon-parameter').removeClass('opacity-0');
        await timer(1000);
        resolve();
    });
}

/**
* 経験値バーのアニメーション
* @param mixed param
* @return Promise
*/
window.battleLib.doAnimateExpBar = function(param){
    return new Promise ((resolve, reject) => {
        var expbar = $("#expbar-friend");
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

/**
* レベルアップ処理
* @param json
* @return Promise
*/
window.battleLib.doAnimateLevelUp = function(param){
    return new Promise ((resolve, reject) => {
        var expbar = $("#expbar-friend");
        // アニメーションをリセット
        expbar.resetKeyframe(function(){});
        expbar.hide();
        expbar.css('width', 0);
        // レベルアップ
        $("#level-friend").text(param.level);
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
            complete: async function(){
                // 処理完了(css変更のズレがあるため0.5秒後にresolveを返却)
                await timer(500);
                expbar.show();
                resolve();
            }
        });
    });
}

/**
* 捕獲処理
* @param integer
* @return Promise
*/
window.battleLib.doAnimateCapture = function (param){
    return new Promise ((resolve, reject) => {
        // ボール画像を取得
        var ball = $($('#template-effect-ball').html());
        ball.attr('src', param.src);
        $('#battle-field').prepend(ball);
        // キーフレームの用意
        var l = 25;
        var t = 25;
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
                ball.css('top', '35%'); // ボールの位置を少し下げる
                var ball_open = $($('#template-effect-ball-open').html());
                ball_open.addClass('enemy');
                $('#battle-field').append(ball_open);
                await timer(500);
                // 相手ポケモンを非表示
                ball.show();
                $('img.capture-ball-open').hide();
                $('#enemy-pokemon-image').addClass('opacity-0');
                // 揺れ演出
                await shakeBall(ball, param.shake);
                if(param.shake >= 4){
                    // 捕獲成功
                    // 捕獲時のボールアニメーション
                    var ball_get = $($('#template-effect-ball-get').html());
                    $('#battle-field').append(ball_get);
                    await timer(500);
                    $('img.capture-ball-get').hide();
                    resolve();
                }else{
                    // 捕獲失敗
                    // ボールエフェクト
                    ball.remove();
                    ball_open = $($('#template-effect-ball-open').html());
                    ball_open.addClass('enemy');
                    $('#battle-field').append(ball_open);
                    // 相手ポケモンを表示
                    $('#enemy-pokemon-image').removeClass('opacity-0');
                    await timer(500);
                    // 非表示
                    $('img.capture-ball-open').hide();
                    await timer(500);
                    resolve();
                }
            }
        });
    });
}

/**
* 瀕死処理
* @param target:string
* @return Promise
*/
window.battleLib.doAnimateFainting = function (target){
    return new Promise ( async (resolve, reject) => {
        $('#' + target + '-pokemon-parameter').addClass('opacity-0');
        $('#' + target + '-pokemon-image').addClass('opacity-0');
        await timer(500);
        resolve();
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/

/**
* HPの数値カウント処理
* @param integer start
* @param integer end
* @return Promise
*/
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

/**
* ボールの揺れアニメーション
* @param ball:element
* @param count:integer
* @return Promise
*/
var shakeBall = function(ball, count){
    return new Promise ((resolve, reject) => {
        // 揺れ回数0
        if(!count){
            resolve();
            return;
        }
        // 回数分のpromiseを作成
        var jobs = [];
        for (var i = 0; i < count; i++) {
             jobs.push($.Deferred());
        }
        $.keyframe.define({
            name: 'shake-ball',
            '0%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(0deg)'
            },
            '15%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(45deg)'
            },
            '30%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(-45deg)'
            },
            '45%': {
                transform: 'translateY(-100%) translateX(-50%) rotate(0deg)'
            },
        });
        var shake = 0;
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
                    jobs[shake].resolve();
                    shake++;
                }, 500);
            }
        });
        // 揺れ回数分の処理が完了
        Promise.all(jobs)
        .then(() => { resolve(); });
    });
}

/**
* タイマー
* @param time:integer
* @return Promise
*/
var timer = function(time){
    return new Promise( async (resolve, reject) => {
        setTimeout(() => { resolve(); }, time);
    });
}
