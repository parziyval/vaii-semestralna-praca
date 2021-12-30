<?php /** @var Array $data */
use App\Auth; ?>

<?php if($data["index_sprava"] != "") { ?>
    <div class="alert alert-<?=$data["index_sprava_typ"]?> alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["index_sprava"] ?>
    </div>
<?php } ?>

<?php if(Auth::jePrihlaseny() && Auth::getRola() == "admin") { ?>
    <a href="?c=galeria&a=pridajAlbumForm" class="btn btn-primary mb-2"><i class="bi-plus-square"></i> Pridať album</a>
<?php } ?>

<div class="row">
    <?php foreach ($data["albumy"] as $album) { ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
                <a href="?c=galeria&a=zobrazAlbum&album_id=<?= $album->getId() ?>">
                    <img src="<?= \App\Config\Configuration::UPLOAD_DIR . $album->getThumbnail()?>" class="card-img-top" alt="Thumbnail albumu">
                </a>
                <div class="card-body">
                    <p class="text-center"> <?php echo $album->getPopisok() ?> </p>
                    <div class="text-center">
                        <?php if(Auth::jePrihlaseny() && Auth::getRola() == "admin") { ?>
                            <a href="?c=galeria&a=upravAlbumForm&album_id=<?= $album->getId(); ?>" class="btn btn-info"><i class="bi bi-pencil"></i></a>
                            <a href="?c=galeria&a=vymazAlbum&album_id=<?= $album->getId(); ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
