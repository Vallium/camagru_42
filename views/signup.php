<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Sign-up</title>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
</head>
<body>
    <div class="container">
        <h1>SIGN-UP</h1>
        <form id="signUpForm" method="post" action="/user/signup">
            <div class="row connect-form">
                <label class="col-xs-12">USERNAME</label>
                <input class="col-xs-12 col-sm-4 col-sm-push-4" type="text" name="username" autofocus>
                <label class="col-xs-12">EMAIL</label>
                <input class="col-xs-12 col-sm-4 col-sm-push-4" type="email" name="email">
                <label class="col-xs-12">PASSWORD</label>
                <input class="col-xs-12 col-sm-4 col-sm-push-4" type="password" name="password">
                <label class="col-xs-12">CONFIRM PASSWORD</label>
                <input class="col-xs-12 col-sm-4 col-sm-push-4" type="password" name="passwordConf">
            </div>
            <div class="row" id="errors">
                <?php
                    if (isset($errors))
                    {
                        echo '<div class="col-xs-12 col-sm-4 col-sm-push-4">';
                        if (isset($errors['username']))
                            echo '<h4>&bull; Invalid username.</h4>';
                        if (isset($errors['login_already_exists']))
                            echo '<h4>&bull; Username already taken.</h4>';
                        if (isset($errors['email']))
                            echo '<h4>&bull; Invalid email.</h4>';
                        if (isset($errors['email_already_exists']))
                            echo '<h4>&bull; An account with this mail already exists.</h4>';
                        if (isset($errors['password']))
                            echo '<h4>&bull; Invalid password.</h4>';
                        if (isset($errors['password_match']))
                            echo '<h4>&bull; Passwords do not match.</h4>';
                        echo '</div>';
                    }
                ?>
            </div>
            <button id="button" class="button orange">SIGN-UP</button>
        </form>
    </div>
</body>
