<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Forgot Password ?</title>
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
        <?php if(isset($retrieve)): ?>
            <?php if(isset($retrieve['bad_link'])): ?>
                <div class="confirm-div error">
                    <h2>YOU TRIED TO REACH A BAD LINK</h2>
                </div>
            <?php else: ?>
            <h1>CHANGE YOUR PASSWORD</h1>
            <form id="forgotForm" method="post" action="/user/changePassword/<?=$retrieve['id'];?>/<?=$retrieve['hash'];?>">
                <input type="hidden" name="id" value="<?=$retrieve['id'];?>">
                <input type="hidden" name="hash" value="<?=$retrieve['hash'];?>">
                <div>
                    <label>NEW PASSWORD</label>
                    <input type="password" name="password">
                </div>
                <div>
                    <label>CONFIRM PASSWORD</label>
                    <input type="password" name="passwordConf">
                </div>
                <div id="errors">
                    <?php
                    if (isset($retrieve['errors']))
                    {
                        if (isset($retrieve['errors']['password']))
                            echo '<h4>&bull; Invalid password.</h4>';
                        if (isset($retrieve['errors']['password_match']))
                            echo '<h4>&bull; Passwords do not match.</h4>';
                        if (isset($retrieve['errors']['password_same']))
                            echo '<h4>&bull; Password can\'t be the same as before.</h4>';
                    }
                    ?>
                </div>
                <button id="button" class="button orange">CHANGE PASSWORD</button>
            </form>
            <?php endif; ?>
        <?php else: ?>
            <h1>FORGOT PASSWORD?</h1>
            <form id="forgotForm" method="post" action="/user/forgotPassword">
                <div>
                    <label>EMAIL</label>
                    <input type="email" name="email" autofocus>
                </div>
                <div id="errors">
                    <?php
                    if (isset($errors))
                    {
                        if (isset($errors['invalid_email_format']))
                            echo '<h4>&bull; Invalid email format.</h4>';
                        if (isset($errors['undefined_email']))
                            echo '<h4>&bull; No user with this email found.</h4>';
                    }
                    ?>
                </div>
                <button id="button" class="button orange" style="font-size: 12px;">SEND RETRIEVING REQUEST</button>
            </form>
        <?php endif; ?>
    </div>
</body>
