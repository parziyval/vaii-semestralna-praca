<?php /** @var Array $data */ ?>

<?php if($data["sprava"] != "") { ?>
    <div class="alert alert-<?=$data["sprava_typ"]?> alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["sprava"] ?>
    </div>
<?php } ?>

<div class="row">
    <div class="d-flex justify-content-center h-100">
        <div class="card col-8">
            <div class="card-header">
                <h3 class="text-dark">Registrácia</h3>
            </div>
            <div class="card-body">
                <form method="post" action="?c=auth&a=registruj">
                    <label for="regInputEmail" class="form-label text-dark">Email</label>
                    <div class="col-sm-10 pb-3">
                        <input type="text" class="form-control" name="email" id="regInputEmail">
                        <small>Chyba</small>
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    </div>

                    <label for="regInputMeno" class="form-label text-dark">Meno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="meno" id="regInputMeno">
                    </div>

                    <label for="regInputPriezvisko" class="form-label text-dark">Priezvisko</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="priezvisko" id="regInputPriezvisko">
                    </div>

                    <label for="inputPassword" class="form-label text-dark">Heslo<br>
                        <small class="text-secondary">(Musí mať 8-30 znakov, musí obsahovať aspoň jedno veľké písmeno, aspoň jedno malé písmeno a aspoň jednu číslicu)</small></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="heslo" id="regInputPassword">
                    </div>

                    <label for="inputPassword2" class="form-label text-dark">Znova zadajte heslo</label>
                    <div class="col-sm-10 mb-3">
                        <input type="password" class="form-control" name="heslo2" id="regInputPassword2">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn bg-primary text-light">Registrovať</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
