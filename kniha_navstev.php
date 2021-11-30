<?php
    session_start();
    require_once "App.php";

    $app = new App();

    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        try {
            if($id != null) {
                if($app->delete($id)) {
                    $app->redirect("kniha_navstev.php?deleted");
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
        <?php
        if(isset($_GET['updated'])) {
            echo $app->showAlert("info", "Príspevok bol úspešne upravený!");
        } else if(isset($_GET['deleted'])) {
            echo $app->showAlert("warning", "Príspevok bol úspešne vymazaný!");
        } else if(isset($_GET['inserted'])) {
            echo $app->showAlert("success", "Príspevok bol úspešne pridaný!");
        } else if(isset($_GET['error'])) {
            echo $app->showAlert("danger", "Chyba!");
        }
        ?>

        <a href="kn_form.php"><button type="submit" class="btn btn-primary">Pridať príspevok</button></a>

        <div class="row justify-content-center">
            <?php
            foreach ($app->getAllPosts() as $post) { ?>
                <div class="card my-3 cierne-pismo">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post->getMeno();?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $post->getDatum();?></h6>
                        <p class="card-text"><?php echo $post->getText();?></p>
                        <a href="kn_form.php?upravit=<?php echo $post->getId(); ?>" class="btn btn-info"><i class="bi bi-pencil"></i></a>
                        <a href="kniha_navstev.php?delete=<?php echo $post->getId(); ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>


</body>
</html>