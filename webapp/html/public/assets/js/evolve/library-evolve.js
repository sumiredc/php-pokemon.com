// グローバル関数をオブジェクト化
window.evolveLib = {};

/*----------------------------------------------------------
// グローバル化する関数
----------------------------------------------------------*/

/**
* 進化演出（5秒間の進化アニメーション）
* @return Promise
**/
window.evolveLib.doAnimateEvolve = function(){
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

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/
