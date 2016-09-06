<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Change your Password.</title>
</head>
<body>
    <div class="container">
        <?php if(isset($retrieve['bad_link'])): ?>
            <div class="confirm-div error">
                <h2>YOU TRIED TO REACH A BAD LINK</h2>
            </div>
        <?php else: ?>
            <h1>CHANGE YOUR PASSWORD</h1>
            <form id="forgotForm" method="post" action="">
                <div class="row connect-form">
                    <div>
                        <label class="col-xs-12">NEW PASSWORD</label>
                        <input class="col-xs-12 col-sm-4 col-sm-push-4" type="password" name="password">
                    </div>
                    <div class="col-xs-12" style="height: 10px;"></div>
                    <div>
                        <label class="col-xs-12">CONFIRM PASSWORD</label>
                        <input class="col-xs-12 col-sm-4 col-sm-push-4" type="password" name="passwordConf">
                    </div>
                </div>
                <div class="row" id="errors">
                    <?php
                    if (isset($retrieve['errors']))
                    {
                        echo '<div class="col-xs-12 col-sm-4 col-sm-push-4">';
                        if (isset($retrieve['errors']['password']))
                            echo '<h4>&bull; Invalid password.</h4>';
                        if (isset($retrieve['errors']['password_match']))
                            echo '<h4>&bull; Passwords do not match.</h4>';
                        if (isset($retrieve['errors']['password_same']))
                            echo '<h4>&bull; Password can\'t be the same as before.</h4>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <button id="button" class="button orange">CHANGE PASSWORD</button>
            </form>
        <?php endif; ?>
    </div>
</body>
