<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Sign-in</title>
    <script src="/scripts/signin.js"></script>
    <style>
        <?php if(isset($errors)): ?>
            #button {
                margin-top: 20px;
            }
        <?php endif;?>
    </style>
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
            <div id="errors">
                <?php
                if (isset($errors))
                {
                    if (isset($errors['username']))
                        echo '<h4>&bull; Invalid username.</h4>';
                    if (isset($errors['user_not_found']))
                        echo '<h4>&bull; Username not found.</h4>';
                    if (isset($errors['password']))
                        echo '<h4>&bull; Invalid password.</h4>';
                    if (isset($errors['bad_pass']))
                        echo '<h4>&bull; Bad password.</h4>';
                    if (isset($errors['user_not_activated']))
                        echo '<h4>&bull; User not activated!</h4>';
                }
                ?>
            </div>
            <button id="button" class="button orange">CONNECT</button>
        </form>
    </div>
</body>
