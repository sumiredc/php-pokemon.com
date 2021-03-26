<!-- Modal -->
<div class="modal fade" id="player-modal" tabindex="-1" role="dialog" aria-labelledby="player-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="player-modal-title">
                    <img src="/assets/img/player/red/mini/front.png" alt="<?=player()->getName()?>" />
                    <?=player()->getName()?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="player-modal-accordion">
                    <?php include resources_path('partials/home/partials/player-detail.php'); ?>
                    <?php include resources_path('partials/home/partials/player-badge.php'); ?>
                    <?php include resources_path('partials/home/partials/player-record.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
