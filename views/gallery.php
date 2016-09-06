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
    ?>
    <div class="container">
        <h1>GALLERY</h1>
        <input id="nb_img_on_gallery_load" type="hidden" value="<?=$GLOBALS['nb_img_on_gallery_load'];?>">
        <div id="wrap">
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
        </div>
        <form id="formLoadMore" method="post" action="/gallery/loadMore/0/<?=$GLOBALS['nb_img_on_gallery_load'] + 12;?>">
            <button class="button orange">LOAD MORE</button>
        </form>
    </div>
    <div class="empty"></div>
</body>

<script src="/js/gallery.js"></script>
