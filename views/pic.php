<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Camagru - Picture</title>
    <script src="/scripts/pic.js"></script>
    <link href="/css/pic.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php //print_r($pic);?>
    <div id="divToScroll">
        <div class="left-col">
            <img src="/img/uploads/<?= $pic['picture'][0]->id?>.jpg" alt="">
        </div>
        <div class="right-col">
            <a id="likeButton" href="/gallery/like/<?= $pic['picture'][0]->id?>">
                <input type="hidden" id="img-id" value="<?= $pic['picture'][0]->id?>">
                <?php if (isset($pic['is_liked'][0]->isLiked) && $pic['is_liked'][0]->isLiked):?>
                    <span id="likeChar" class="like active"</span>
                <?php else:?>
                    <span id="likeChar" class="like"</span>
                <?php endif;?>
            </a>
            <p id="likeNbr"><?=$pic['likes'][0]->count;?></p>
            <?php $imgDate = new DateTime($pic['picture'][0]->created_at);?>
            <h6>Posted on <?=date('l jS \of F Y h:i:s A', $imgDate->getTimestamp());?></h6>
            <h1>Commentaires</h1>
            <div id="comments">
                <?php foreach($pic['comments'] as $comment):?>
                    <p><?=$comment->content;?></p>
                <?php endforeach;?>
            </div>
                <form id="formComment" method="post" action="/gallery/postComment" <?php if (!isset($_SESSION['loggedin'])):?>style="display: none;"<?php endif;?>>
                    <input id="inCom" type="text" name="content">
                    <input type="hidden" name="users_id" value="<?=$_SESSION['id'];?>">
                    <input type="hidden" name="images_id" value="<?=$pic['picture'][0]->id;?>">
                    <button type="submit">Post</button>
                </form>
        </div>
    </div>
</body>