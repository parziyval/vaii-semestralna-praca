<?php /** @var Array $data */ ?>

<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Meno</th>
        <th>Priezvisko</th>
        <th></th>
    </tr>
    <?php foreach($data["uzivatelia"] as $uzivatel) {
        $id = $uzivatel->getId()?>
    <tr>
        <td><?php echo $uzivatel->getId() ?></td>
        <td>
            <div contentEditable="true" class="edit" id="email_<?php echo $id; ?>">
                <?php echo $uzivatel->getEmail() ?>
            </div>
        </td>

        <td>
            <div contentEditable="true" class="edit" id="meno_<?php echo $id; ?>">
                <?php echo $uzivatel->getMeno() ?>
            </div>
        </td>

        <td>
            <div contentEditable="true" class="edit" id="priezvisko_<?php echo $id; ?>">
                <?php echo $uzivatel->getPriezvisko() ?>
            </div>
        </td>

        <td>
            <i class="bi bi-trash delete" id="<?php echo $id; ?>"></i>
        </td>
    </tr>
    <?php } ?>
</table>
