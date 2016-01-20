<head>
    <link href="/css/home.css" rel="stylesheet" type="text/css">
</head>

    <h1><span>L</span><span>E</span><span>S</span> <span>D</span><span>E</span><span>R</span><span>N</span><span>I</span><span>E</span><span>R</span><span>S</span> <span>M</span><span>O</span><span>N</span><span>T</span><span>A</span><span>G</span><span>E</span><span>S</span></h1>
<!--    <h1>-->
<!--        --><?php
//            $h1 = 'LES DERNIERS MONTAGES';
//            for ($i = 0; $i < strlen($h1); $i++) {
//                if ($h1[$i] != ' ') {?>
<!--                    <span>--><?//=$h1[$i];?><!--</span>-->
<!--                --><?php //} else { ?>
<!--                    <span style="color: rgba(0, 0, 0, 0);">--><?//='s'?><!--</span>-->
<!--                --><?php //}?>
<!--        --><?php //} ?>
<!--    </h1>-->
    <div class="images-holder">
        <?php for($i = 1; $i <= 12; $i++) {?>
            <?php if ($i % 3 == 1): ?>
                <div class="col-1">
                    <img src="https://www.petfinder.com/wp-content/uploads/2012/11/155293403-cat-adoption-checklist-632x475-e1354290788940.jpg" alt="" class="grayscale">
                </div>
            <?php elseif ($i % 3 == 2): ?>
                <div class="col-2">
                    <img src="https://www.petfinder.com/wp-content/uploads/2012/11/155293403-cat-adoption-checklist-632x475-e1354290788940.jpg" alt="" class="grayscale">
                </div>
            <?php else: ?>
                <div class="col-3">
                    <img src="https://www.petfinder.com/wp-content/uploads/2012/11/155293403-cat-adoption-checklist-632x475-e1354290788940.jpg" alt="" class="grayscale">
                </div>
            <?php endif; ?>
        <?php }?>
    </div>
    <div class="empty">
    </div>

<script src="../scripts/home.js"></script>
<!--    <ul>-->
<!--    <li>Username : --><?//= $home['username']; ?><!--</li>-->
<!--    <li>Age : --><?//= $home['age']; ?><!--</li>-->
<!--    </ul>-->

