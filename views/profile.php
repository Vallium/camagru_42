<head>
    <link href="/css/profile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Profile</title>
</head>
<body>
    <div class="holder">
        <?php
        function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g') {
            $url = 'http://www.gravatar.com/avatar/';
            $url .= md5(strtolower(trim($email)));
            $url .= "?s=$s&d=$d&r=$r";

            return $url;
        }
        ?>
        <?php if (!empty($profile['user'])):?>
        <div class="first-col">
            <div class="picture">
                <div class="hexagon hexagon2">
                    <div class="hexagon-in1">
                        <div id="hexagon-in2">
<!--                            --><?php //if (file_exists(ROOT.'img'.DS.'users'.DS.$profile['user'][0]->id.'.png')): ?>
<!--                                <img id="hexaImg" src="/img/users/--><?//= $profile['user'][0]->id?><!--.png" alt="Pic" style="display: none;">-->
<!--                            --><?php //elseif (file_exists(ROOT.'img'.DS.'users'.DS.$profile['user'][0]->id.'.jpg')): ?>
<!--                                <img id="hexaImg" src="/img/users/--><?//= $profile['user'][0]->id?><!--.jpg" alt="Pic" style="display: none;">-->
<!--                            --><?php //else :?>
<!--                                <img id="hexaImg" src="/img/users/0.png" alt="Pic" style="display: none;">-->
<!--                            --><?php //endif;?>
                            <img id="hexaImg" src="<?=get_gravatar($profile['user'][0]->email, 360);?>" alt="Pic" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="user">
                <h2><?= strtoupper($profile['user'][0]->username)?></h2>
                <?php $date = new DateTime($profile['user'][0]->created_at); ?>
                <h6>Member since <?= date('l jS \of F Y', $date->getTimestamp());?></h6>
<!--                <span class="fa pencil"></span>-->
            </div>
            <div class="clear"></div>
        </div>
        <div class="sec-col">
            <h1>LAST UPLOADS</h1>
            <div class="img-holder">
                <?php foreach($profile['pictures'] as $img): ?>
                    <a href="/gallery/pic/<?=$img->id?>">
                        <img src="/img/uploads/<?=$img->id?><?=$img->ext?>" alt="" class="grayscale">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else :?>
        <h1>USER NOT FOUND</h1>
        <?php endif; ?>
    </div>
    <div class="empty"></div>
    <?php
    echo '<pre>';
    print_r($profile);
    ?>
</body>
<script src="/scripts/profile.js"></script>