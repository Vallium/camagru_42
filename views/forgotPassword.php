<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Forgot Password ?</title>
    <script src="/scripts/forgotPassword.js"></script>
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
    </div>
</body>
