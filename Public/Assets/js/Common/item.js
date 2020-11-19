
/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/
/**
* アイテム詳細の表示
* @function on beforeunload
* @return void
*/
var showItemModalDetailInit = function(){
    $('.item-row').on('click', function(){
        var category = $(this).data('category');
        var name = $(this).data('name');
        var description = $(this).data('description');
        var target = $(this).data('target');
        var use = $(this).data('use');
        var trash = $(this).data('trash');
        var order = $(this).data('order');
        // 操作ボタンを非表示
        var button_group = $('.item-action-button-group[data-category="' + category + '"]');
        button_group.find('[data-button="*"]').hide();
        // 詳細に表示
        $('#item-modal-' + category + '-name').text(name);
        $('#item-modal-' + category + '-description').text(description);
        // 「使う」ボタンを表示
        if(use){
            // targetに合わせた使うボタン(フォーム)を表示
            var use_btn = button_group.find('[data-button="use"][data-item_target="' + target + '"]')
            use_btn.show();
            // もしアイテムの対象がenemyまたはplayerの場合はorderをセット
            if(target === 'enemy' || target === 'player'){
                use_btn.find('[name="order"]').val(order);
            }
        }
        // 「捨てる」ボタンを表示
        if(trash){
            button_group.find('button[data-button="trash"]')
            .show();
        }
    });
}

/**
* 「捨てる」の処理
* @function on beforeunload
* @return void
*/
var clickItemTrashInit = function(){
    $('[data-button="trash"]').on('click', function(){
        var category = $(this).parent().data('category');
        // フォーム値を初期化
        $('form#item-trash-form [name="count"] > option[data-template="true"]').remove();
        $('form#item-trash-form [name="order"]').val('');
        // 選択されたアイテムノードを取得
        var tr = $('tr[data-category="' + category + '"].active');
        var owned = tr.data('owned');
        var name = tr.data('name');
        var order = tr.data('order');
        // 個数選択の生成
        createTrashCountSelect(owned);
        $('#item-trash-name').text(name);
        // アイテム番号をセット
        $('form#item-trash-form [name="order"]').val(order);
    });
}

/**
* 「使う」の処理（ポケモン）
* @function on beforeunload
* @return void
*/
var clickItemUseFriendInit = function(){
    $('[data-button="use"][data-item_target="friend"]').on('click', function(){
        // アイテムカテゴリ取得
        var category = $(this).parent().data('category');
        // 選択されたアイテムノードを取得
        var tr = $('tr[data-category="' + category + '"].active');
        var name = tr.data('name');
        var order = tr.data('order');
        // フォームを取得
        var form = $('form#item-use-friend-form');
        // アイテム名とアイテム番号をセット
        $('#item-use-name').text(name);
        form.find('[name="order"]').val(order);
    });
}

/**
* 「使う」の処理（ポケモン） ポケモンを選択→送信処理
* @function on beforeunload
* @return void
*/
var selectItemUseFriendInit = function(){
    $('#item-use-friend-modal .pokemon-row').on('click', function(){
        // フォームを取得
        var form = $('form#item-use-friend-form');
        // ポケモン番号を取得
        var pokemon = $(this).data('pokemon');
        // フォームにパラメーターをセット
        form.find('[name="pokemon"]').val(pokemon);
        // 送信
        form.submit();
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/
/**
* 売却数optionの生成
* @param max:integer
* @return void
**/
var createTrashCountSelect = function(owned){
    // 売却可能数だけoptionを追加
    var count_select = $('form#item-trash-form [name="count"]');
    for (var i = 1; i <= owned; i++) {
        var option_template = $($('#template-option').html());
        option_template.val(i);
        option_template.text(i + ' 個');
        count_select.append(
            option_template
        );
    }
}

/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    showItemModalDetailInit();
    clickItemTrashInit();
    clickItemUseFriendInit();
    selectItemUseFriendInit();
});
