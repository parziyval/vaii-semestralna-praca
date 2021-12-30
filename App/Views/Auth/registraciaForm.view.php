<?php /** @var Array $data */ ?>

<?php if($data["registration_error"] != "") { ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["registration_error"] ?>
    </div>
<?php } ?>

<div class="d-flex justify-content-center h-100">
    <div class="card col-8">
        <div class="card-header">
            <h3 class="text-dark">Registrácia</h3>
        </div>
        <div class="card-body">
            <form method="post" action="?c=auth&a=registruj">
                <label for="regInputEmail" class="form-label text-dark">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="regInputEmail" required>
                </div>

                <label for="regInputMeno" class="form-label text-dark">Meno</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="meno" id="regInputMeno" required>
                </div>

                <label for="regInputPriezvisko" class="form-label text-dark">Priezvisko</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="priezvisko" id="regInputPriezvisko" required>
                </div>

                <label for="inputPassword" class="form-label text-dark">Heslo</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="heslo" id="inputPassword" required>
                </div>

                <label for="inputPassword2" class="form-label text-dark">Znova zadajte heslo</label>
                <div class="col-sm-10 mb-3">
                    <input type="password" class="form-control" name="heslo2" id="inputPassword2" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn bg-primary text-light">Registrovať</button>
                </div>
            </form>
        </div>
    </div>
</div>
