<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Forgot Password ?</title>
</head>
<body>
    <div class="container">
        <h1>FORGOT PASSWORD?</h1>
        <form id="forgotForm" method="post" action="/user/forgotPassword">
            <div class="row connect-form">
                <label class="col-xs-12" style="margin-top: 20px; margin-bottom: 20px;">Please enter your email to reset your password</label>
                <input class="col-xs-12 col-sm-4 col-sm-push-4" type="email" name="email" autofocus>
            </div>
            <div class="row" id="errors">
                <?php
                if (isset($errors))
                {
                    echo '<div class="col-xs-12 col-sm-4 col-sm-push-4">';
                    if (isset($errors['invalid_email_format']))
                        echo '<h4>&bull; Invalid email format.</h4>';
                    if (isset($errors['undefined_email']))
                        echo '<h4>&bull; No user with this email found.</h4>';
                    if (isset($errors['user_not_activated']))
                        echo '<h4>&bull; User not activated.</h4>';
                    echo '</div>';
                }
                ?>
            </div>
            <button id="button" class="button orange" style="font-size: 12px;">SEND RETRIEVING REQUEST</button>
        </form>
    </div>
</body>
