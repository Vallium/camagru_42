<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Camagru - Picture</title>
    <script src="/scripts/pic.js"></script>
    <link href="/css/pic.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php print_r($pic);?>
    <div id="divToScroll">
        <div class="left-col">
            <img src="/img/uploads/<?= $pic['picture'][0]->id?>.jpg" alt="">
        </div>
        <div class="right-col">
            <?php $imgDate = new DateTime($pic['picture'][0]->created_at);?>
            <h4>Posted on <?=date('l jS \of F Y h:i:s A', $imgDate->getTimestamp());?></h4>
            <h1>This pic was liked <?=$pic['likes'][0]->count;?> times</h1>

            <h1>Commentaires</h1>
            <?php foreach($pic['comments'] as $comment):?>
                <p><?=$comment->content;?></p>
            <?php endforeach;?>
            <?php if (isset($_SESSION['loggedin'])):?>
                <form method="post" onsubmit="return ajaxPostCom(this);">
                    <input id="inCom" type="text" name="content">
                    <input type="hidden" name="users_id" value="<?=$_SESSION['id'];?>">
                    <input type="hidden" name="images_id" value="<?=$pic['picture'][0]->id;?>">
                    <button type="submit">Post</button>
                </form>
            <?php endif;?>
        </div>
    </div>
</body>