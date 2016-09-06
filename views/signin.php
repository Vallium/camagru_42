<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Sign-in</title>
</head>
<body>
    <div class="container">
        <h1>SIGN-IN</h1>
        <?php if(isset($confirm)):?>
            <?php
            if (isset($confirm['ok']))
                $div = 'ok';
            else if (isset($confirm['errors']))
                $div = 'error';
            ?>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-push-2 confirm-div <?=$div?>">
                    <?php if(isset($confirm['errors']['userNotFound'])):?>
                        <h2>USER DOES NOT EXISTS</h2>
                    <?php elseif(isset($confirm['errors']['active'])):?>
                        <h2>USER ALREADY ACTIVE</h2>
                    <?php elseif(isset($confirm['errors']['error_occured'])):?>
                        <h2>AN ERROR OCCURED</h2>
                    <?php elseif(isset($confirm['ok'])):?>
                        <h2>ACCOUNT CONFIRMED WITH SUCCESS</h2>
                    <?php endif;?>
                </div>
            </div>
        <?php endif;?>
        <form id="signInForm" method="post" action="/user/signin">
            <div class="row connect-form">
                <label class="col-xs-12">USERNAME</label>
                <input class="col-xs-12 col-sm-4 col-sm-push-4" id="username" type="text" name="username" autofocus>
                <div class="col-xs-12" style="height: 10px;"></div>
                <label class="col-xs-12">PASSWORD</label>
                <input class="col-xs-12 col-sm-4 col-sm-push-4" id="password" type="password" name="password">
            </div>
            <div class="row">
                <div class="col-xs-12" style="height: 20px;"></div>
                <div class="col-xs-12 col-sm-4 col-sm-push-4">
                    <div class="link">
                        <a href="/user/signup">If you don't have an account, you can sign-up now</a>
                    </div>
                    <div class="link">
                        <a href="/user/forgotPassword">Forgot your password? Send me an email</a>
                    </div>
                </div>
            </div>
            <div class="row" id="errors">
                <?php
                    if (isset($errors))
                    {
                        echo '<div class="col-xs-12 col-sm-4 col-sm-push-4">';
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
                        echo '</div>';
                    }
                ?>
            </div>
            <button id="button" class="button orange">CONNECT</button>
        </form>
    </div>
</body>

<script src="/js/signin.js"></script>
