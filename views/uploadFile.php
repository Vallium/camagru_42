<head>
    <link href="/css/uploadFile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Upload a picture</title>
    <script src="/scripts/uploadFile.js"></script>
</head>
<body>
    <div class="holder">
        <?php if(isset($_SESSION['loggedin'])):?>
            <h1>UPLOAD A PICTURE</h1>
            <div id="preview" style="position: relative; width: 640px; height: 480px; margin: 0 auto; border: 2px solid black;">
                <img id="image">
<!--                <div id="infoDragNDrop" style="position: absolute; top: 0; left: 0; z-index: 3; width: 100%; height: 100%; font-size: 50px;">YOU CAN DRAG AND DROP YOUR FILE!</div>-->
                <div id="calque" style="position: absolute; top: 0; left: 0; z-index: 2; width: 100%; height: 100%; background-image: url('/img/filters/1.png'); opacity: 1; background-repeat: no-repeat;"></div>
            </div>
            <div class="filters">
                <?php $i = 1;?>
                <?php for (; $i <= 10; $i++):?>
                    <img id="filter-<?=$i;?>" src="/img/filters/<?=$i;?>.png" alt="<?=$i;?>">
                <?php endfor;?>
                <input id="nbrFilters" type="hidden" value="<?=$i - 1;?>">
            </div>
            <form id="uploadForm" method="post" action="/upload/uploadImage" enctype="multipart/form-data">
            <div>
                <label>FILE TO UPLOAD</label>
                <input id="file" type="file" name="fileToUpload">
            </div>
                <input type="hidden" id="base64img" name="base64img" value="none">
                <input id="filter-id" type="hidden" name="filterId" value="1">
                <input type="hidden" name="MAX_UPLOAD_SIZE" value="<?=$GLOBALS['MAX_UPLOAD_SIZE'];?>">
                <button class="button orange">UPLOAD</button>
            </form>
        <?php else:?>
            <h1>YOU HAVE TO BE LOGGED TO POST A PICTURE</h1>
        <?php endif;?>
    </div>
</body>