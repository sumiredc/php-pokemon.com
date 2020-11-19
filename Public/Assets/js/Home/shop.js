/*----------------------------------------------------------
// 初期化する関数
----------------------------------------------------------*/

// おこづかい
var money = $('#player-remaining-money').val();

/**
* アイテム選択
* @function change
* @return void
**/
var selectItemInit = function(){
    $('form[data-form="shop"] select[name="order"]').on('change', function(){
        // フォームとoptionの判別
        var form = $(this).data('form');
        var option = $(this).find('option:selected');
        // 必要値の取得
        var item = option.data('item');
        var price = option.data('price');
        var owned = option.data('owned');
        var max = option.data('max');
        // 計算機と個数選択をリセット
        calculatorReset(form);
        $('form[data-form="shop"] select[name="count"]').val('');
        // 未選択の場合は処理終了
        if(option.val() === ''){
            return;
        }
        // フォームによる個数option生成の分岐
        switch (form) {
            case 'buy':
            createBuyCountSelect(max, owned);
            break;
            case 'sell':
            createSellCountSelect(owned);
            break;
        }
        // 所有数をセット
        $('#shop-' + form + '-item-owned').text(owned + ' 個');
        // アイテム名・単価をセット
        $('#shop-' + form + '-item-name').text(item);
        $('#shop-' + form + '-item-price').text(price + ' 円');
    });
}

/**
* 個数選択
* @function change
* @return void
**/
var selectCountInit = function(){
    $('form[data-form="shop"] select[name="count"]').on('change', function(){
        // 必要値の取得
        var form = $(this).data('form');
        var order_option = $('[data-form="' + form + '"][name="order"] option:selected')
        var price = order_option.data('price');
        var count = $(this).val();
        // 合計金額の算出
        var total = price * count;
        // 計算機に値をセット
        $('#shop-' + form + '-item-count').text(count + ' 個');
        $('#shop-' + form + '-total-price').text(total + ' 円');
        if(money < total){
            $('#shop-' + form + '-submit').prop('disabled', true);
            $('[data-alert="' + form + '"]').show();
        }else{
            $('#shop-' + form + '-submit').prop('disabled', false);
            $('[data-alert="' + form + '"]').hide();
        }
    });
}

/**
* モーダル起動時の初期化
* @function change
* @return void
**/
var showModalInit = function(){
    $('#shop-modal').on('show.bs.modal', function(){
        $.each(['buy', 'sell'], function(index, value){
            formReset(value);
            calculatorReset(value);
        })
    });
}

/**
* タブクリック時の初期化
* @function change
* @return void
**/
var shopTabInit = function(){
    $('#shop-modal-tab .nav-link').on('click', function(){
        var form = $(this).data('type');
        formReset(form);
        calculatorReset(form);
    });
}

/*----------------------------------------------------------
// 処理内で呼び出す関数
----------------------------------------------------------*/

/**
* 購入数optionの生成
* @param max:integer
* @param owned:integer
* @return void
**/
var createBuyCountSelect = function(max, owned){
    // 購入可能数だけoptionを追加
    var count_select = $('[data-form="buy"][name="count"]');
    for (var i = 1; i <= (max - owned); i++) {
        var option_template = $($('#template-option').html());
        option_template.val(i);
        option_template.text(i + ' 個');
        count_select.append(
            option_template
        );
    }
}

/**
* 売却数optionの生成
* @param max:integer
* @return void
**/
var createSellCountSelect = function(owned){
    // 売却可能数だけoptionを追加
    var count_select = $('[data-form="sell"][name="count"]');
    for (var i = 1; i <= owned; i++) {
        var option_template = $($('#template-option').html());
        option_template.val(i);
        option_template.text(i + ' 個');
        count_select.append(
            option_template
        );
    }
}

/**
* 計算機の初期化
* @param form:string
* @return void
**/
var calculatorReset = function(form){
    $('#shop-' + form + '-item-owned').text('-');
    $('#shop-' + form + '-item-name').text('-');
    $('#shop-' + form + '-item-price').text('-');
    $('#shop-' + form + '-item-count').text('-');
    $('#shop-' + form + '-total-price').text('-');
    $('[data-alert="' + form + '"]').hide();
    $('#shop-' + form + '-submit').prop('disabled', true);
    // 個数選択を初期化
    $('[data-form="' + form + '"][name="count"]')
    .find('option[data-template="true"]')
    .remove();
}

/**
* フォームの初期化
* @param form:string
* @return void
**/
var formReset = function(form){
    $('[data-form="'+ form +'"]').val('');
}

/*----------------------------------------------------------
// 初期化
----------------------------------------------------------*/
jQuery(function($){
    selectItemInit();
    selectCountInit();
    shopTabInit();
    showModalInit();
});
