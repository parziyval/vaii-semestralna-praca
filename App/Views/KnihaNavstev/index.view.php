<?php /** @var Array $data */ ?>

<div>
    <form method="post">
        <input type="hidden" id="uzivatel_email" name="uzivatel_email" value="<?= isset($SESSION["email"]) ? $_SESSION["email"] : "" ?>">
        <input id="kn_text" type="text" required>
        <button id="kn_btn_odoslat">Odoslať</button>
    </form>
</div>

<div id="kn_prispevky">

</div>
