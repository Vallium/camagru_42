<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Sign-in</title>
    <script src="/scripts/signin.js"></script>
</head>
<body>
    <div class="holder">
        <h1>SIGN-IN</h1>
        <?php if(isset($confirm)):?>
            <?php
            if (isset($confirm['ok']))
                $div = 'ok';
            else if (isset($confirm['errors']))
                $div = 'error';
            ?>
            <div class="confirm-div <?=$div?>">
                <?php if(isset($confirm['errors']['userNotFound'])):?>
                    <h2>USER DOES NOT EXISTS</h2>
                <?php elseif(isset($confirm['errors']['active'])):?>
                    <h2>USER ALREADY ACTIVE</h2>
                <?php elseif(isset($confirm['ok'])):?>
                    <h2>ACCOUNT CONFIRMED WITH SUCCESS</h2>
                <?php endif;?>
            </div>
        <?php endif;?>
        <form id="signInForm" method="post" action="/user/signin">
            <div>
                <label>USERNAME</label>
                <input id="username" type="text" name="username" autofocus>
            </div>
            <div>
                <label>PASSWORD</label>
                <input id="password" type="password" name="password">
            </div>
            <div class="toSubscribe">
                <a href="/user/signup">If you don't have an account, you can sign-up now</a>
                <a href="/user/forgotPassword">Forgot your password? Send me an email</a>
            </div>
            <div id="errors"></div>
            <button id="button" class="button orange">CONNECT</button>
        </form>
    </div>
    <?php
//    if (isset($confirm))
//    {
//        echo '<pre>';
//        print_r($confirm);
//    }
    ?>
</body>
