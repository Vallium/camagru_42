<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="/web/img/favicon/orange.png" />
        <link href="/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="/css/grid.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <header>
            <nav>
                <div class="container">
                    <div class="bar">
                        <div class="brand">CAMAGRU</div>
                        <div class="mobile-nav" id="mobile-nav-icon">
                            <i class="fa nav-icon"></i>
                        </div>
                    </div>
                    <div class="main-nav" id="menu">
                        <ul>
                            <li>
                                <a href="/">HOME</a>
                            </li>
                            <li>
                                <a href="/gallery">GALLERY</a>
                            </li>
                            <li>
                                <a href="/upload">UPLOAD A FILE</a>
                            </li>
                            <li>
                                <a href="/upload/takePicture">TAKE A PICTURE</a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <?php if (isset($_SESSION['username'])):?>
                            <li>
                                <a href="/user/profile/<?= $_SESSION['id']?>">
                                    <img src="<?=$_SESSION['gravatar'];?>" alt="Pic">
                                    PROFILE
                                </a>
                            </li>
                            <li>
                                <a href="/user/logout">LOGOUT</a>
                            </li>
                            <?php else : ?>
                            <li>
                                <a href="/user/signin">SIGN-IN</a>
                            </li>
                            <li>
                                <a href="/user/signup">SIGN-UP</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <?php echo $content_for_layout;?>

        <footer>COPYRIGHT @ 2016 - CAMAGRU MADE BY VALLIUM FOR 42</footer>
    </body>
    <script src="/js/layout.js"></script>
</html>
