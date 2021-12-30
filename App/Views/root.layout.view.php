<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Penzión Chameleón</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- ikonky -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="public/css.css">

</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-2">
    <div class="container">
        <a class="navbar-brand" href="?c=home">Penzión Chameleón</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $_GET["c"] == "home" ? "active" : "" ?>" aria-current="page" href="?c=home">Domov</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $_GET["c"] == "galeria" ? "active" : "" ?>" href="?c=galeria">Galéria</a>
                </li>

                <!--<li class="nav-item">
                    <a class="nav-link" href="menu.html">Reštaurácia</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="kontakt.html">Kontakt</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="kniha_navstev.php">Kniha návštev</a>
                </li> -->
            </ul>

            <?php use App\Auth;

            if(!Auth::jePrihlaseny()) { ?>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET["c"] == "auth" && $_GET["a"] == "loginForm") ? "active" : "" ?>" href="?c=auth&a=loginForm">Prihlásiť sa</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($_GET["c"] == "auth" && $_GET["a"] == "registraciaForm") ? "active" : "" ?>" href="?c=auth&a=registraciaForm">Registrovať</a>
                </li>
            </ul>

            <?php } else { ?>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <div class="navbar-text text-light">Ste prihlásený ako <strong><?php echo Auth::getEmail() ?></strong></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="?c=auth&a=odhlas">Odhlásiť sa</a>
                </li>
            </ul>

            <?php } ?>


        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col">
            <?= $contentHTML ?>
        </div>
    </div>
</div>

<div class="container footer-hide">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            &copy; 2021 Adam Parimucha
        </div>
    </footer>
</div>

</body>
</html>