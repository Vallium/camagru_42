<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Camagru - Gallery</title>
    <link href="/css/gallery.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
//    echo $GLOBALS['nb_img_on_gallery_load'].PHP_EOL;
//    echo '<pre>';
//    print_r($gallery);
//    die()
    ?>
    <div class="container">
        <h1>GALLERY</h1>
        <?php foreach($gallery['images'] as $img):?>
            <?php
                if (file_exists(ROOT.'web'.DS.'img'.DS.'uploads'.DS.$img->id.'.jpg'))
                    $ext = 'jpg';
                elseif (file_exists(ROOT.'web'.DS.'img'.DS.'uploads'.DS.$img->id.'.png'))
                    $ext = 'png';
            ?>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <a href="/gallery/pic/<?=$img->id;?>">
                    <div class="image">
                        <img src="/img/uploads/<?=$img->id;?>.<?=$ext?>" class="grayscale" />
                    </div>
                </a>
            </div>
        <?php endforeach;?>
        <?php if ($gallery['nb_pages'] > 1): ?>
        <div class="col-xs-12 pagination">
            <?php if ($gallery['page'] > 1): ?>
                <a href="/gallery"><i class="fa left-icon-double"></i></a>
                <a href="/gallery/page/<?= $gallery['page'] - 1;?>"><i class="fa left-icon"></i></a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $gallery['nb_pages']; $i++): ?>
                <a class="<?= ($i == $gallery['page']) ? 'active' : ''?>" href="/gallery/page/<?=$i;?>"><?=$i;?></a>
            <?php endfor;?>
            <?php if ($gallery['page'] < $gallery['nb_pages']): ?>
                <a href="/gallery/page/<?= $gallery['page'] + 1;?>"><i class="fa right-icon"></i></a>
                <a href="/gallery/page/<?= $gallery['nb_pages'];?>"><i class="fa right-icon-double"></i></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="empty"></div>
</body>

