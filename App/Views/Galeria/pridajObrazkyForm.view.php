<?php /** @var Array $data */ ?>

<form method="post" action="?c=galeria&a=pridajObrazky&album_id=" enctype="multipart/form-data">
    <h1>Pridanie obrázkov do albumu</h1>

    <div class="form-group">
        <div class="mb-3">
            <label for="formFile" class="form-label">Obrázky na pridanie</label>
            <input class="form-control" type="file" id="formFile" name="obrazkySubory[]" accept=".jpeg,.jpg,.png" required multiple>
        </div>
        <small class="text-secondary">Pridávajte len obrázky vo formáte .jpeg, .jpg alebo .png</small>

        <div>
            <button type="submit" class="btn btn-primary mt-3 text-center btn-md" >Pridať obrázky</button>
            <a href="?c=galeria" class="btn btn-secondary mt-3">Späť</a>
        </div>

    </div>
</form>
