
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/

/**
* ボックス選択
* @function on click
*/
var selectPokeboxInit = function() {
    $('[data-list="pokebox"] > [role="tab"]').on('click', function(){
        var category = $(this).data('category');
        var name = $(this).find('.pokebox-name')
        .text();
        // ボックスリストボタンの色変更
        $('[data-list="pokebox"] > .nav-link').removeClass('btn-orange')
        .addClass('btn-secondary');
        $(this).removeClass('btn-secondary')
        .addClass('btn-orange');
        // ボックス操作ボタンの表示・非表示
        $('[data-pokebox="controls"] [data-category="common"]').hide();
        $('[data-pokebox="controls"] [data-category][data-category!="' + category + '"]').hide();
        $('[data-pokebox="controls"] [data-category="' + category + '"][data-btn="default"]').show();
        $('[data-pokebox="controls"] [data-category="common"][data-btn="default"]').show();
        // 選択中のポケモンを解除
        var row = $('.table-selected[data-list="pokemon"]')
        .find('.table-selected-row')
        .removeClass('active');
    });
}

/**
* ポケモンの選択
* @function on click
*/
var selectPokemonInit = function() {
    $('[data-list="pokemon"] .table-selected-row').on('click', function(){
        var place = $(this).data('place');
        var pokemon_id = $(this).data('pokemon_id');
        // ボックス操作関係のフォーム・ボタンを非表示
        $('[data-category="' + place + '"]').hide();
        $('[data-btn="default"]').hide();
        // 「様子を見る」の有効化
        $('[data-btn="details"]').hide();
        $('[data-btn="details"][data-pokemon_id="' + pokemon_id + '"]').show();
        // 選択されたポケモン情報を取得
        var name = $(this).find('#pokebox-pokemon-name-' + pokemon_id)
        .text();
        var img = $(this).find('#pokebox-pokemon-img-' + pokemon_id)
        .attr('src');
        // パーティー、ボックス内ポケモンの分岐
        if(place === 'party'){
            var action = 'deposit';
        }else if(place === 'pokebox'){
            var action = 'receive';
        }
        // 「預ける」または「引き取る」を有効化
        $('[data-btn="' + action + '"]').show();
        // モーダルに選択されたポケモン情報をセット
        $('form#pokebox-' + action + '-form [name="pokemon_id"]').val(pokemon_id);
        $('#' + action + '-pokemon-name').text(name);
        $('#' + action + '-pokemon-img').attr('src', img);
    });
}

/**
* ボックス切り替え
* @function on click
*/
var switchPokeboxModalInit = function() {
    $('[data-target="#pokebox-switch-modal"]').on('click', function(){
        var box = $(this).data('box');
        var name = $(this).find('.pokebox-name').text();
        // ボックス名と番号をセット
        $('#switch-pokebox-name').text(name);
        $('#pokebox-switch-form [name="box"]').val(box);
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    selectPokemonInit();
    selectPokeboxInit();
    switchPokeboxModalInit();
});
