<?php /** @var Array $data */ ?>

<?php if($data["sprava"] != "") { ?>
    <div class="alert alert-<?=$data["sprava_typ"]?> alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["sprava"] ?>
    </div>
<?php } ?>

<form method="post" action="?c=oznam&a=pridajOznam" >
    <h1>Pridanie nového oznamu</h1>

    <div class="form-group">
        <div class="mb-3">
            <label for="inputNadpis" class="col-sm-2 col-form-label">Nadpis oznamu</label>
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputNadpis" name="oznamNadpis" maxlength="50" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Text oznamu</label>
            <div class="col-lg-12">
                <textarea class="form-control" id="inputText" name="oznamText" maxlength="2000" required></textarea>
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary mt-3 text-center btn-md" >Pridať oznam</button>
            <a href="?c=oznam" class="btn btn-secondary mt-3">Späť</a>
        </div>

    </div>
</form>
