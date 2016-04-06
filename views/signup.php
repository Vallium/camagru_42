<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Sign-up</title>
    <script src="/scripts/signup.js"></script>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
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
        <h1>SIGN-UP</h1>
        <form id="signUpForm" method="post" action="/user/signup">
            <div>
                <label>USERNAME</label>
                <input type="text" name="username" autofocus>
            </div>
            <div>
                <label>EMAIL</label>
                <input type="email" name="email">
            </div>
            <div>
                <label>PASSWORD</label>
                <input type="password" name="password">
            </div>
            <div>
                <label>CONFIRM PASSWORD</label>
                <input type="password" name="passwordConf">
            </div>
            <div id="errors">
                <?php
                if (isset($errors))
                {
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
                }
                ?>
            </div>
            <button id="button" class="button orange">SIGN-UP</button>
        </form>
    </div>
</body>