<!-- <head>
    <link href="/css/gallery.css" rel="stylesheet" type="text/css">
    <title>Camagru - Gallery</title>
</head>

<h1>Gallery</h1>
<div class="images-holder">
    <?php for($i = 1; $i <= 12; $i++) {?>
        <?php if ($i % 3 == 1): ?>
            <div class="col-1">
                <img src="/img/uploads/<?=$home['images'][$i - 1]->id?>.jpg" alt="" class="grayscale">
            </div>
        <?php elseif ($i % 3 == 2): ?>
            <div class="col-2">
                <img src="/img/uploads/<?=$home['images'][$i - 1]->id?>.jpg" alt="" class="grayscale">
            </div>
        <?php else: ?>
            <div class="col-3">
                <img src="/img/uploads/<?=$home['images'][$i - 1]->id?>.jpg" alt="" class="grayscale">
            </div>
        <?php endif; ?>
    <?php }?>
</div>
<div class="empty">
            <?php print_r($home['images'][0]->id);?>
</div>

<script src="../scripts/gallery.js"></script> -->

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
    <script src="/scripts/gallery.js"></script>
        <link href="/css/gallery.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="wrap"><img src="/img/uploads/1.jpg" alt=""></div>
<div style="height: 200px"></div>
</body>
</html>