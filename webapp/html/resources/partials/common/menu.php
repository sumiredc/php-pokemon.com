<div class="col-12 py-3 mb-5">
    <div class="btn-group float-right">
        <button type="button"
        class="btn btn-php-dark btn-sm dropdown-toggle menu"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">
        <i class="fas fa-bars mr-2"></i>メニュー</button>
        <div class="dropdown-menu dropdown-menu-right">
            <span class="dropdown-item p-0">
                <?php # ずかん ?>
                <button type="button"
                class="btn btn-link btn-block text-left text-secondary font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#pokedex-modal">ずかん</button>
            </span>
            <span class="dropdown-item p-0">
                <?php # ポケモン ?>
                <button type="button"
                class="btn btn-link btn-block text-left text-secondary font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#party-modal">ポケモン</button>
            </span>
            <span class="dropdown-item p-0">
                <?php # どうぐ ?>
                <button type="button"
                class="btn btn-link btn-block text-left text-secondary font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#item-modal">どうぐ</button>
            </span>
            <span class="dropdown-item p-0">
                <?php # プレイヤー ?>
                <button type="button"
                class="btn btn-link btn-block text-left text-secondary font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#player-modal"><?=player()->getName()?></button>
            </span>
            <span class="dropdown-item p-0">
                <?php # レポート ?>
                <button type="button"
                class="btn btn-link btn-block text-left text-secondary font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#report-modal">レポート</button>
            </span>
            <span class="dropdown-item p-0">
                <?php # せってい ?>
                <button type="button"
                class="btn btn-link btn-block text-left text-secondary font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#setting-modal"
                title="未実装の機能です" disabled>せってい</button>
            </span>
            <div class="dropdown-divider"></div>
            <span class="dropdown-item p-0">
                <?php # リセット ?>
                <button class="btn btn-link text-danger btn-block text-left font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#reset-modal"><i class="fas fa-exclamation-triangle mr-2"></i>リセット</button>
            </span>
        </div>
    </div>
</div>
