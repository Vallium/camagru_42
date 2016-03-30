<head>
    <link href="/css/signin.css" rel="stylesheet" type="text/css">
    <title>Camagru - Sign-up</title>
    <script src="/scripts/signup.js"></script>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
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
            </div>
            <button id="button" class="button orange">SIGN-UP</button>
        </form>
    </div>
</body>