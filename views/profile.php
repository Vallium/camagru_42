<head>
    <link href="/css/profile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Profile</title>
</head>

<div class="contentHolder">
    <section>
        <article>
            <?php if (!empty($profile)):?>
            <div class="top">
                <div class="picture">
                    <div class="hexagon hexagon2">
                        <div class="hexagon-in1">
                            <div id="hexagon-in2">
                                <?php if (file_exists(ROOT.'img'.DS.'users'.DS.$profile['user'][0]->id.'.png')): ?>
                                    <img id="hexaImg" src="/img/users/<?= $profile['user'][0]->id?>.png" alt="Pic" style="display: none;">
                                <?php elseif (file_exists(ROOT.'img'.DS.'users'.DS.$profile['user'][0]->id.'.jpg')): ?>
                                    <img id="hexaImg" src="/img/users/<?= $profile['user'][0]->id?>.jpg" alt="Pic" style="display: none;">
                                <?php else :?>
                                    <img id="hexaImg" src="/img/users/0.png" alt="Pic" style="display: none;">
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user">
                    <h1><?= strtoupper($profile['user'][0]->username)?></h1>
                    <?php $date = new DateTime($profile['user'][0]->created_at); ?>
                    <h6>Member since <?= date('l jS \of F Y', $date->getTimestamp());?></h6>
                    <br>
                </div>
                <div class="clear"></div>
            </div>
            <?php else :?>
            <div>
                USER NOT FOUND
            </div>
            <?php endif; ?>
        </article>
    </section>
</div>
            <?php print_r($profile) ?>
<script src="/scripts/profile.js"></script>