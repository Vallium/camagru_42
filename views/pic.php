<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Camagru - Picture</title>
    <script src="/scripts/pic.js"></script>
    <link href="/css/pic.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php print_r($pic);?>
    <div id="divToScroll">
        <div class="left-col">
            <img src="/img/uploads/<?= $pic['picture'][0]->id?>.jpg" alt="">
        </div>
        <div class="right-col">
            <h1>Commentaires</h1>
        </div>
    </div>
</body>