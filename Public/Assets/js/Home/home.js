
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* フィールド選択
* @function on:change
* @return void
**/
var selectFieldInit = function(){
    $('form#select-field-form [name="field"]').on('change', function(){
        var field = $(this).val();
        var form = $('form#select-field-form');
        var image = $('#select-field-image');
        if(field){
            // 画像を表示してフォームを有効化
            image.attr('src', '/Assets/img/fields/' + field + '.png')
            .show();
            form.find('input[type="submit"]').prop('disabled', false);
        }else{
            // 画像を非表示にしてフォームを無効化
            image.attr('src', '')
            .hide();
            form.find('input[type="submit"]').prop('disabled', true);
        }
    });
}

/**
* トレーナー選択
* @function on:change
* @return void
**/
var selectTrainerInit = function(){
    $('form#select-trainer-form [name="trainer"]').on('change', function(){
        // テキストを全て非表示
        $('p[data-trainer]').hide();
        // 必要情報の取得
        var trainer = $(this).val();
        var form = $('form#select-trainer-form');
        var image = $('#select-trainer-image');
        var text = $('p[data-trainer="' + trainer + '"]');
        var selected = $(this).find('option:selected');
        if(trainer){
            // 画像とテキストを表示
            image.attr('src', selected.data('img'))
            .show();
            text.show();
            // 戦える状態ならボタンを有効化
            form.find('input[type="submit"]')
            .prop('disabled', !selected.data('fight'));
        }else{
            // デフォルトテキストを表示
            $('p[data-trainer="default"]').show();
            // 画像を非表示にしてフォームを無効化
            image.attr('src', '')
            .hide();
            form.find('input[type="submit"]').prop('disabled', true);
        }
    });
}

/**
* ジム選択
* @function on:change
* @return void
**/
var selectGymInit = function(){
    $('form#select-gym-form [name="gym"]').on('change', function(){
        // テキストを全て非表示
        $('[data-gym]').hide();
        // 必要情報の取得
        var gym = $(this).val();
        var form = $('form#select-gym-form');
        var image = $('#select-gym-image');
        var text = $('[data-gym="' + gym + '"]');
        var selected = $(this).find('option:selected');
        if(gym !== ''){
            // 画像とテキストを表示
            image.attr('src', selected.data('img'))
            .show();
            text.show();
            // 戦える状態ならボタンを有効化
            form.find('input[type="submit"]')
            .prop('disabled', !selected.data('fight'));
        }else{
            // デフォルトテキストを表示
            $('p[data-gym="default"]').show();
            // 画像を非表示にしてフォームを無効化
            image.attr('src', '')
            .hide();
            form.find('input[type="submit"]').prop('disabled', true);
        }
    });
}


/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    selectFieldInit();
    selectTrainerInit();
    selectGymInit();
});
