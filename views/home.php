<head>
    <link href="/css/gallery.css" rel="stylesheet" type="text/css">
    <title>Camagru - Homepage</title>
</head>
<body>
    <div class="container">
        <h1>LAST PHOTOMONTAGES</h1>
        <?php foreach($home['images'] as $img): ?>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <a href="/gallery/pic/<?=$img->id?>">
                    <div class="image">
                        <img src="/img/uploads/<?=$img->id?><?=$img->ext?>" alt="" class="grayscale" />
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="empty"></div>
</body>



