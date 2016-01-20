<!DOCTYPE html>
<html>
    <head>
        <link href="/css/layout.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <header>
            <nav class="secondary-nav">
                <div class="content-holder">
        <!--            --><?php //if ():?>
        <!--                Connecté-->
        <!--            --><?php //else : ?>
                    <a href="/user/login">CONNEXION</a> / <a href="/user/signup">INSCRIPTION</a>
        <!--            --><?php //endif; ?>
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

        <script src="../../scripts/particles/particles.js"></script>
        <script src="../../scripts/particles/app.js"></script>
    </body>
</html>