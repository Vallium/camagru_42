<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Camagru - Picture</title>
    <script src="/scripts/pic.js"></script>
    <link href="/css/pic.css" rel="stylesheet" type="text/css">
    <?php if (!empty($pic['errors'])): ?>
        <style>
            #formComment {
                border: 2px solid rgba(255, 0, 0, 0.7);
            }
        </style>
    <?php endif;?>
</head>

<body>
    <div class="holder" id="holder">
        <div class="first-col">
            <?php
            if (file_exists(ROOT.'img'.DS.'uploads'.DS.$pic['picture'][0]->id.'.jpg'))
                $ext = 'jpg';
            elseif (file_exists(ROOT.'img'.DS.'uploads'.DS.$pic['picture'][0]->id.'.png'))
                $ext = 'png';
            ?>
            <img id="dblClickOnImg" src="/img/uploads/<?= $pic['picture'][0]->id?>.<?=$ext;?>" alt="">
        </div>
        <div class="sec-col">
            <a id="likeButton" href="/gallery/like/<?= $pic['picture'][0]->id?>">
                <input type="hidden" id="img-id" value="<?= $pic['picture'][0]->id?>">
                <?php if (isset($pic['is_liked'][0]->isLiked) && $pic['is_liked'][0]->isLiked):?>
                    <span id="likeChar" class="fa like active"></span>
                <?php else:?>
                    <span id="likeChar" class="fa like"></span>
                <?php endif;?>
            </a>
            <p id="likeNbr"><?=number_format($pic['likes'][0]->count);?></p>
            <?php if (isset($_SESSION['loggedin']) && $pic['picture'][0]->users_id == $_SESSION['id']): ?>
                <form id="formDelete" method="post" action="/upload/deleteImage">
                    <input type="hidden" name="imgId" value="<?=$pic['picture'][0]->id?>">
                    <input type="hidden" name="imgUserId" value="<?=$pic['picture'][0]->users_id?>">
                    <button id="delButton">
                        <span id="delChar" class="fa cross"></span>
                    </button>
                </form>
            <?php endif;?>
            <?php $imgDate = new DateTime($pic['picture'][0]->created_at);?>
            <h6>Posted by
                <a href="/user/profile/<?=$pic['author'][0]->id;?>"><?=$pic['author'][0]->username;?></a>
                on <?=date('jS \of F Y H:i:s', $imgDate->getTimestamp());?>
            </h6>
            <div id="comments">
                <?php foreach($pic['comments'] as $comment):?>
                    <p>
                        <a class="comLink" href="/user/profile/<?=$comment->users_id->id;?>"><?=$comment->users_id->username;?></a>
                        : <?=htmlspecialchars($comment->content);?>
                    </p>
                    <?php $comDate = new DateTime($comment->created_at);?>
                    <h4><?=date('l jS \of F Y H:i:s', $comDate->getTimestamp());?></h4>
                <?php endforeach;?>
            </div>
            <?php if (isset($_SESSION['loggedin'])):?>
                <form id="formComment" method="post" action="/gallery/postComment">
                    <input id="inCom" type="text" name="content" placeholder="Post your comment...">
                    <input type="hidden" name="users_id" value="<?=$_SESSION['id'];?>">
                    <input type="hidden" name="images_id" value="<?=$pic['picture'][0]->id;?>">
                    <button type="submit">POST COMMENT</button>
                </form>
            <?php endif;?>
        </div>
    </div>
    <div class="empty"></div>
    <?php
//        echo '<pre>';
//        print_r($pic);
    ?>
</body>
