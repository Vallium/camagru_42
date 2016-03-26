<head>
    <link href="/css/home.css" rel="stylesheet" type="text/css">
    <title>Camagru - Homepage</title>
    <script src="../scripts/home.js"></script>
</head>
<body>
<!--    <h1><span>L</span><span>E</span><span>S</span> <span>D</span><span>E</span><span>R</span><span>N</span><span>I</span><span>E</span><span>R</span><span>S</span> <span>M</span><span>O</span><span>N</span><span>T</span><span>A</span><span>G</span><span>E</span><span>S</span></h1>-->
    <div class="holder">
        <h1>LAST PHOTOMONTAGES</h1>
        <?php foreach($home['images'] as $img): ?>
            <?php
            if (file_exists(ROOT.'img'.DS.'uploads'.DS.$img->id.'.jpg'))
                $ext = 'jpg';
            elseif (file_exists(ROOT.'img'.DS.'uploads'.DS.$img->id.'.png'))
                $ext = 'png';
            ?>
            <a href="/gallery/pic/<?=$img->id?>">
                <img src="/img/uploads/<?=$img->id?>.<?=$ext?>" alt="" class="grayscale">
            </a>
        <?php endforeach; ?>
    </div>
    <div class="empty"></div>
</body>



