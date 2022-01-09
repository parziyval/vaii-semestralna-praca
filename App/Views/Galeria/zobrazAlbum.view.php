<?php /** @var Array $data */

use App\Auth; ?>

<?php if($data["sprava"] != "") { ?>
    <div class="alert alert-<?=$data["sprava_typ"]?> alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["sprava"] ?>
    </div>
<?php } ?>

<?php if(Auth::jePrihlaseny() && Auth::getRola() == "admin") { ?>
    <a href="?c=galeria&a=pridajObrazkyForm&album_id=<?=$data["album_id"]?>" class="btn btn-primary mb-2"><i class="bi-plus-square"></i> Pridať fotky</a>
<?php } ?>

<div class="row">
    <?php foreach ($data["obrazky"] as $obrazok) { ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
                <img src="<?= \App\Config\Configuration::UPLOAD_DIR . $obrazok->getSubor()?>" class="card-img-top" alt="Obrázok albumu">
                <?php if(Auth::jePrihlaseny() && Auth::getRola() == "admin") { ?>
                    <div class="card-body">
                        <a href="?c=galeria&a=vymazObrazok&obrazok_id=<?= $obrazok->getId(); ?>" class="btn btn-danger"><i class="bi bi-trash"></i> Vymazať obrázok</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
