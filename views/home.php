<head>
    <link href="/css/home.css" rel="stylesheet" type="text/css">
    <title>Camagru - Homepage</title>
    <script src="../scripts/home.js"></script>
</head>
<body>
    <h1><span>L</span><span>E</span><span>S</span> <span>D</span><span>E</span><span>R</span><span>N</span><span>I</span><span>E</span><span>R</span><span>S</span> <span>M</span><span>O</span><span>N</span><span>T</span><span>A</span><span>G</span><span>E</span><span>S</span></h1>
    <div class="images-holder">
        <?php for($i = 1; $i <= 12; $i++): ?>
            <a href="/gallery/pic/<?=$home['images'][$i - 1]->id?>">
                <img src="/img/uploads/<?=$home['images'][$i - 1]->id?>.jpg" alt="" class="grayscale">
            </a>
        <?php endfor; ?>
    </div>
    <div class="empty"></div>
</body>



