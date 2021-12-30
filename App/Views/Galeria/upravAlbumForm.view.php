<?php /** @var Array $data */ ?>

<?php if($data["form_sprava"] != "") { ?>
    <div class="alert alert-<?=$data["form_sprava_typ"]?> alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data["form_sprava"] ?>
    </div>
<?php } ?>

<form method="post" action="?c=galeria&a=upravAlbum&album_id=<?=$data["album_id"]?>" enctype="multipart/form-data">
    <h1>Úprava albumu</h1>

    <div class="form-group">
        <div class="mb-3">
            <label for="formFile" class="form-label">Nový thumbnail albumu(ak nechcete zmeniť thumbnail, nevyberajte žiadny súbor)</label>
            <div class="col-lg-12">
                <input type="file" class="form-control" id="formFile" name="albumSubor" accept=".jpeg,.jpg,.png">
            </div>
        </div>
        <small class="text-secondary">Pridávajte len obrázky vo formáte .jpeg, .jpg alebo .png<br>Maximálna veľkosť súboru je <?php echo ini_get("upload_max_filesize") ?></small>

        <div class="mb-3">
            <label for="inputPopisok" class="col-sm-2 col-form-label">Popisok</label>
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputPopisok" name="albumPopisok" value="<?=$data["popisok"] ?>" maxlength="50" required>
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary mt-3 text-center btn-md" >Upraviť album</button>
            <a href="?c=galeria" class="btn btn-secondary mt-3">Späť</a>
        </div>

    </div>
</form>
