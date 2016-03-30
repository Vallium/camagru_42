<head>
    <link href="/css/uploadFile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Take a picture</title>
    <script src="/scripts/takePicture.js"></script>
</head>
<body>
    <div class="holder">
        <?php if(isset($_SESSION['loggedin'])):?>
            <h1>TAKE A PICTURE</h1>
            <div id="camera" style="position: relative; width: 640px; height: 480px; margin: 0 auto;">
                <video id="video"></video>
                <div id="calque" style="position: absolute; top: 0; left: 0; z-index: 2; width: 100%; height: 100%; background-image: url('/img/filters/1.png'); opacity: 1; background-repeat: no-repeat;"></div>
            </div>
            <div class="filters">
                <?php $i = 1;?>
                <?php for (; $i <= 10; $i++):?>
                    <img id="filter-<?=$i;?>" src="/img/filters/<?=$i;?>.png" alt="<?=$i;?>">
                <?php endfor;?>
                <input id="nbrFilters" type="hidden" value="<?=$i - 1;?>">
            </div>
            <button id="startbutton" class="button orange">TAKE PICTURE</button>
            <canvas id="canvas"></canvas>
            <img src="#" id="photo" alt="photo" style="display: none;">
            <form id="uploadFromWebcamForm" method="post" action="/upload/uploadImageFromWebcam" enctype="multipart/form-data">
                <input type="hidden" id="base64img" name="base64img" value="none">
                <input id="filter-id" type="hidden" name="filterId" value="1">
                <button id="submit-button" class="button orange" style="display: none;">UPLOAD</button>
            </form>
        <?php else:?>
            <h1>YOU HAVE TO BE LOGGED TO TAKE A PICTURE</h1>
        <?php endif;?>
    </div>
</body>