<?php
require_once "App.php";

$app = new App();

if(isset($_GET['upravit'])) {
    $id = $_GET['upravit'];
    $stmt = $app->runQuery("SELECT * FROM kn_prispevok WHERE id=?");
    $stmt->execute([intval($id)]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $id = null;
    $row = null;
}

if(isset($_POST['button_save'])) {
    $meno = strip_tags($_POST['meno']);
    $text = strip_tags($_POST['text']);

    try {
        if($id != null) {
            if($app->update($id, $meno, $text)) {
                $app->redirect("kniha_navstev.php?updated");
            }
        } else {
            if($app->insert($meno, $text)) {
                $app->redirect("kniha_navstev.php?inserted");
            } else {
                $app->redirect("kniha_navstev.php?error");
            }
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kniha návštev</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- ikonky -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">Penzión Chameleón</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.html">Domov</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ubytovanie.html">Ubytovanie</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="menu.html">Reštaurácia</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="kontakt.html">Kontakt</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="kniha_navstev.php">Kniha návštev</a>
                </li>
            </ul>


        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <form method="POST">
            <div class="form-group my-3">
                <label for="meno">Meno *</label>
                <input type="text" name="meno" id="meno" class="form-control" placeholder="Zadajte meno" value="<?php echo ($row == null) ? "" : $row['meno'];?>" required maxlength="50">
            </div>

            <div class="form-group my-3">
                <label for="text">Text príspevku *</label>
                <textarea name="text" id="text" class="form-control" placeholder="Zadajte text" required maxlength="2000"><?php echo ($row == null) ? "" : $row['text'];?></textarea>
            </div>
            <p class="text-muted">Polia označené <strong>*</strong> sú povinné</p>
            <input class="btn btn-success" type="submit" name="button_save" value="Uložiť">
            <a href="kniha_navstev.php" class="btn btn-secondary my-3" role="button">Zrušiť</a>

        </form>

    </div>
</div>

</body>
</html>