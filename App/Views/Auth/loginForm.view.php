<?php /** @var Array $data */ ?>

<?php if($data["login_error"] != "") { ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["login_error"] ?>
    </div>
<?php } ?>

<?php if($data["login_message"] != "") { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["login_message"] ?>
    </div>
<?php } ?>


<div class="row">
    <div class="d-flex justify-content-center h-100">
        <div class="card col-8">
            <div class="card-header">
                <h3 class="text-dark">Prihlásenie</h3>
            </div>
            <div class="card-body">
                <form method="post" action="?c=auth&a=prihlas">
                    <div class="mb-3 align-content-center">
                        <label for="loginInputEmail" class="form-label text-dark">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="loginInputEmail" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="inputPassword" class="form-label text-dark">Heslo</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="heslo" id="inputPassword" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn bg-primary text-light">Prihlásiť</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="text-center text-dark">
                    Nemáte účet? <a href="?c=auth&a=registraciaForm">Zaregistrujte sa</a>
                </div>
            </div>
        </div>
    </div>
</div>
