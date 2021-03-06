<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= loadCss("main") ?>.css">
    <link rel="stylesheet" href="<?= loadCss($css) ?? "none" ?>.css">
    <title><?= $title ?? "Home"; ?></title>
</head>

<body>

    <!-- Nav bar -->
    <div class="navbar">
        <div class="container">
            <h1 class="logo">
                Blog
            </h1>
            <nav class="">
                <div><a href="<?= url() ?>">Home</a></div>
                <div><a href="#">About</a></div>
                <?php if (isLogin()) : ?>

                    <div><a href="<?= url("post/myPost") ?>">My Post</a></div>
                    <div><a href="<?= url("post/create") ?>">New Post</a></div>
                    <div><a class="login" href="<?= url("logout") ?>">Logout</a></div>

                <?php else : ?>
                    <div><a class="login" href="<?= url("login") ?>">Login</a></div>
                    <div><a class="register" href="<?= url("register") ?>">Register</a></div>
                <?php endif; ?>
            </nav>
            <div class="hamburguer">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </div>

    <div class="main container">
        {{content}}
    </div>

    <script src="<?= loadJs("navbar.js") ?>"></script>
</body>

</html>