<header class="bg-php border-php-dark <?php if(getPageName() !== 'initial') echo 'mb-4' ?>" style="border-bottom: 4px solid;">
    <div class="container-fluid">
        <section>
            <div class="row">
                <div class="col-12 col-sm-6 py-2">
                    <h1 class="font-weight-bolder font-italic">PHP POKEMON<span class="small ml-3">(α)</span></h1>
                </div>
                <?php if(http_response_code() !== 503): ?>
                    <div class="col-12 col-sm-6 py-2 text-right d-flex align-items-center justify-content-end">
                        <button class="btn btn-php-back btn-sm ml-1" data-target="#introduction-modal" data-toggle="modal" title="はじめに">はじめに</button>
                        <a href="https://s-yqual.com/contact" target="_blank" role="button" class="btn btn-php-back btn-sm ml-1" title="お問い合わせ">お問い合わせ</a>
                        <button class="btn btn-php-back btn-sm ml-1" data-target="#help-modal" data-toggle="modal" title="ヘルプ">ヘルプ</button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</header>
<?php if(getPageName() === 'initial' && http_response_code() === 200): ?>
    <section class="bg-php-info border-php-info-dark text-center p-2 mb-4" style="border-bottom: 2px solid;">
        <div class="container-fluid">
            <h2 class="h5 mb-0 text-light font-weight-bolder">ようこそ！PHPポケモンの世界へ</h2>
        </div>
    </section>
<?php endif; ?>
