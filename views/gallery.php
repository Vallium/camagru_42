
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Camagru - Gallery</title>
    <script src="/scripts/gallery.js"></script>
    <link href="/css/gallery.css" rel="stylesheet" type="text/css">

</head>
<body>
    <?php //print_r($gallery);?>
    <input id="nb_img_on_gallery_load" type="hidden" value="<?=$GLOBALS['nb_img_on_gallery_load']?>">
    <div class="images-holder">
        <div id="wrap">
            <?php foreach($gallery['images'] as $img):?>
                <?php
                if (file_exists(ROOT.'img'.DS.'uploads'.DS.$img->id.'.jpg'))
                    $ext = 'jpg';
                elseif (file_exists(ROOT.'img'.DS.'uploads'.DS.$img->id.'.png'))
                    $ext = 'png';
                ?>
                <a href="/gallery/pic/<?=$img->id;?>"><img src="/img/uploads/<?=$img->id;?>.<?=$ext?>" class="grayscale"></a>
            <?php endforeach;?>
        </div>
        <form id="formLoadMore" action="/gallery/loadMore/0/<?=$GLOBALS['nb_img_on_gallery_load'] + 3?>">
            <button class="button orange">LOAD MORE</button>
        </form>
    </div>
    <div class="empty"></div>
</body>