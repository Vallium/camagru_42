<head>
    <link href="/css/profile.css" rel="stylesheet" type="text/css">
    <title>Camagru - <?=$profile['user'][0]->username?></title>
</head>
<body>
    <div class="container">
        <?php
        function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g') {
            $url = 'https://www.gravatar.com/avatar/';
            $url .= md5(strtolower(trim($email)));
            $url .= "?s=$s&d=$d&r=$r";

            return $url;
        }
        ?>
        <?php if (!empty($profile['user'])):?>
        <div class="col-xs-12 col-sm-7">
            <div class="row">
                <div class="col-xs-12 col-sm-4" style="text-align: center">
                    <img class="img-user" src="<?=get_gravatar($profile['user'][0]->email, 360);?>" alt="Pic">
                </div>
                <div class="col-xs-12 col-sm-8">
                    <h2><?= strtoupper($profile['user'][0]->username)?></h2>
                    <?php $date = new DateTime($profile['user'][0]->created_at); ?>
                    <h6>Member since <?= date('l jS \of F Y', $date->getTimestamp());?></h6>
                </div>
                <div class="col-xs-12" style="height: 30px;"></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-5">
            <h1>LAST UPLOADS</h1>
            <div class="row img-holder">
                <?php foreach($profile['pictures'] as $img): ?>
                    <div class="col-xs-12 col-sm-6">
                        <a href="/gallery/pic/<?=$img->id?>">
                            <div class="image">
                                <img src="/img/uploads/<?=$img->id?><?=$img->ext?>" alt="" class="grayscale">
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else :?>
        <h1>USER NOT FOUND</h1>
        <?php endif; ?>
    </div>
    <div class="empty"></div>
    <?php
//    echo '<pre>';
//    print_r($profile);
    ?>
</body>
