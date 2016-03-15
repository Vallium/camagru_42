<head>
    <link href="/css/home.css" rel="stylesheet" type="text/css">
    <title>Camagru - Homepage</title>
</head>

    <h1><span>L</span><span>E</span><span>S</span> <span>D</span><span>E</span><span>R</span><span>N</span><span>I</span><span>E</span><span>R</span><span>S</span> <span>M</span><span>O</span><span>N</span><span>T</span><span>A</span><span>G</span><span>E</span><span>S</span></h1>
    <div class="images-holder">
        <!--<?php for($i = 1; $i <= 12; $i++) {?>
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
        <?php }?>-->

        <?php for($i = 1; $i <= 12; $i++): ?>
            <img src="/img/uploads/<?=$home['images'][$i - 1]->id?>.jpg" alt="" class="grayscale">
        <?php endfor; ?>
    </div>
    <div class="empty">
    </div>

<script src="../scripts/home.js"></script>


