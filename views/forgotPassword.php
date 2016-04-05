<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Retrieve Password</title>
<!--    <script src="/scripts/signin.js"></script>-->
</head>
<body>
<div class="holder">
    <h1>FORGOT PASSWORD?</h1>
    <form id="signInForm" method="post" action="/user/signin">
        <div>
            <label>EMAIL</label>
            <input type="email" name="email" autofocus>
        </div>
        <div id="errors"></div>
        <button id="button" class="button orange" style="font-size: 12px;">SEND RETRIEVING REQUEST</button>
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
