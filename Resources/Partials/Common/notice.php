<div class="container-fluid bg-php-back section">
    <section class="bg-php-back p-3">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-3 h3 font-weight-bolder text-php-head">お知らせ</h2>
                <ul class="nav nav-tabs" id="notice-tab" role="tablist">
                    <?php foreach(config('notice') as $key => $notice): ?>
                        <li class="nav-item">
                            <a class="nav-link bg-php border-php text-white p-2 mr-1 <?php if($key === 'update') echo 'active'; ?>" id="<?=$key?>-notice-tab" data-toggle="tab" href="#<?=$key?>-notice-tab-content" role="tab" aria-controls="<?=$key?>-notice-tab-content" aria-selected="true">
                                <?php if(in_array($key, ['update', 'field'], true)): ?>
                                    <?=$notice['title']?>
                                <?php else: ?>
                                    <img src="/Assets/img/icon/<?=$key?>.png" alt="<?=$notice['title']?>" style="max-height: 16px;" />
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content " id="notice-tab-content">
                    <?php foreach(config('notice') as $key => $notice): ?>
                        <div class="tab-pane fade show <?php if($key === 'update') echo 'active'; ?>" id="<?=$key?>-notice-tab-content" role="tabpanel" aria-labelledby="<?=$key?>-notice-tab">
                            <ul class="list-group list-group-flush mb-3 overflow-auto border bg-white" style="height: 160px;">
                                <?php foreach($notice['info'] as list($date, $text)): ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-php-info p-1 mr-2"><?=$date?></span>
                                        <span class="d-block d-md-inline mt-2"><?=$text?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>
