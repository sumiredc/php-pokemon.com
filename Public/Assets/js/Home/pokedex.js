
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* ポケモンの選択
* @function on:click
* @return void
**/
var selectPokedexInit = function(){
    $('#pokedex-list-table > tbody > tr').on('click', function(tr){
        var preview = $('#pokedex-preview');
        var name = $(this).data('name');
        var species = $(this).data('species');
        var description = $(this).data('description');
        // 図鑑に登録済みであれば、画像を表示
        var registed = $(this).find('[data-registed]').data('registed')
        if(registed){
            // 登録済み
            $.each(['front', 'back'], function(index, val){
                var base64 = $(tr.currentTarget).data('base64_' + val);
                preview.find('[data-pokemon="image-' + val + '"]')
                .attr('src', base64)
                .show();
            })
        }else{
            // 未登録
            preview.find('[data-pokemon*="image-"]')
            .hide();
        }
        preview.find('[data-pokemon="name"]')
        .text(name);
        preview.find('[data-pokemon="species"]')
        .text(species);
        preview.find('[data-pokemon="description"]')
        .text(description);
    });
}


/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/


/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    selectPokedexInit();
});
