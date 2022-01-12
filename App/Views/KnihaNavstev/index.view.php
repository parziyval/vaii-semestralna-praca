<?php /** @var Array $data */
use App\Auth; ?>

<h1>Kniha návštev</h1>
<p>Tu môžete zanechať svoje dojmy z návštevy nášho penziónu</p>

<?php if(Auth::jePrihlaseny()) { ?>
<div>
    <form method="post">
        <input type="hidden" id="uzivatel_email" name="uzivatel_email" value="<?= isset($SESSION["email"]) ? $_SESSION["email"] : "" ?>">
        <label for="kn_text">Text príspevku:</label>
        <textarea id="kn_text" name="kn_text" rows="4" cols="100" required ></textarea>
        <div>
        <button class="btn btn-primary" id="kn_btn_odoslat">Odoslať</button>
        </div>
    </form>
</div>
<?php } else { ?>
<div class="alert alert-info">
    Pre pridávanie príspevkov sa musíte prihlásiť.
</div>
<?php } ?>

<div id="kn_prispevky">

</div>
