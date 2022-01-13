<?php /** @var Array $data */

use App\Auth; ?>

<?php if($data["sprava"] != "") { ?>
    <div class="alert alert-<?=$data["sprava_typ"]?> alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["sprava"] ?>
    </div>
<?php } ?>

<?php if(Auth::jePrihlaseny() && Auth::getRola() == "admin") { ?>
    <a href="?c=oznam&a=pridajOznamForm" class="btn btn-primary mb-2"><i class="bi-plus-square"></i> Pridať oznam</a>
<?php } ?>

<div class="row">
    <?php foreach ($data["oznamy"] as $oznam) { ?>
        <div class="col-12 col-md-6 col-lg-4 mb-3">
             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title">
                         <?php echo $oznam->getNadpis(); ?>
                     </h5>
                     <h6 class="card-subtitle mb-2 text-muted">
                         <?php echo $oznam->getDatumPridania(); ?>
                     </h6>
                     <p class="card-text">
                         <?php echo $oznam->getText(); ?>
                     </p>
                     <?php if(Auth::jePrihlaseny() && Auth::getRola() == "admin") { ?>
                         <a href="?c=oznam&a=upravOznamForm&oznam_id=<?= $oznam->getId(); ?>" class="btn btn-info"><i class="bi bi-pencil"></i></a>
                         <a href="?c=oznam&a=vymazOznam&oznam_id=<?= $oznam->getId(); ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                     <?php } ?>
                 </div>
             </div>
        </div>
    <?php } ?>
</div>

