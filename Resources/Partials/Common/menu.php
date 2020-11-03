<div class="col-12 mb-5">
    <div class="btn-group float-right">
        <button type="button"
        class="btn btn-secondary dropdown-toggle"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">
        メニュー</button>
        <div class="dropdown-menu dropdown-menu-right">
            <span class="dropdown-item p-0">
                <?php # ポケモン ?>
                <button type="button"
                class="btn btn-link btn-block text-left text-secondary font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#party-modal">ポケモン</button>
            </span>
            <span class="dropdown-item p-0">
                <?php # ポケモンセンター ?>
                <form action="" method="post">
                    <input type="hidden" name="action" value="recovery">
                    <input class="btn btn-link text-secondary btn-block text-left font-weight-bolder px-4 text-decoration-none"
                    type="submit"
                    value="ポケモンセンター">
                    <?php input_token(); ?>
                </form>
            </span>
            <span class="dropdown-item p-0">
                <?php # バトル ?>
                <form action="" method="post">
                    <input type="hidden" name="action" value="battle">
                    <input class="btn btn-link text-secondary btn-block text-left font-weight-bolder px-4 text-decoration-none"
                    type="submit"
                    value="バトル">
                    <?php input_token(); ?>
                </form>
            </span>
            <div class="dropdown-divider"></div>
            <span class="dropdown-item p-0">
                <?php # リセット ?>
                <button class="btn btn-link text-danger btn-block text-left font-weight-bolder px-4 text-decoration-none"
                data-toggle="modal"
                data-target="#reset-modal">リセット</button>
            </span>
        </div>
    </div>
</div>
