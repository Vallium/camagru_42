<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/png" href="/img/favicon/orange.png" />
        <link href="/css/layout.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <header>
            <nav class="secondary-nav">
                <div class="content-holder">
                    <div class="left-side">
                        <?php if (isset($_SESSION['username'])):?>
                            <?php if (file_exists(ROOT.'img'.DS.'users'.DS.$_SESSION['id'].'.png')): ?>
                                <img src="/img/users/<?= $_SESSION['id']?>.png" alt="Pic">
                            <?php elseif (file_exists(ROOT.'img'.DS.'users'.DS.$_SESSION['id'].'.jpg')): ?>
                                <img src="/img/users/<?= $_SESSION['id']?>.jpg" alt="Pic">
                            <?php else :?>
                                <img src="/img/users/0.png" alt="Pic">
                            <?php endif;?>
                            <a href="/user/profile/<?= $_SESSION['id']?>">PROFILE</a>
                            <a href="/user/mount">TAKE A PICTURE</a>
                            <a href="/user/logout">LOGOUT</a>
                        <?php else : ?>
                        <a href="/user/signin">SIGN-IN</a> / <a href="/user/signup">SIGN-UP</a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
            <div class="contenHolder">
                <div id="particles-js">
                    <nav class="primary-nav">
                        <ul>
                            <li><a href="/">HOME</a></li>
                            <li><a href="/gallery">GALLERY</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <?php echo $content_for_layout;?>

        <footer>COPYRIGHT @ 2016 - CAMAGRU MADE BY VALLIUM FOR 42</footer>

        <script src="/scripts/particles/particles.js"></script>
        <script src="/scripts/particles/app.js"></script>
    </body>
</html>