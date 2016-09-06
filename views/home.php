<head>
    <link href="/css/gallery.css" rel="stylesheet" type="text/css">
    <title>Camagru - Homepage</title>
</head>
<body>
    <div class="container">
        <h1>LAST PHOTOMONTAGES</h1>
        <div id="wrap">
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
        <?php if ($home['nb_photos'] > 12):?>
        <form id="formLoadMore" method="post" action="/gallery/loadMore/0/<?=$GLOBALS['nb_img_on_gallery_load'] + 12;?>" style="display: none;">
            <input id="nb_img_on_gallery_load" type="hidden" value="<?=$GLOBALS['nb_img_on_gallery_load'];?>">
            <div class="col-xs-12">
                <button class="button orange">LOAD MORE</button>
            </div>
        </form>
        <?php endif;?>
    </div>
    <div class="empty"></div>
</body>

<script src="/js/home.js"></script>


