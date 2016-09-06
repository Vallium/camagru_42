<head>
    <link href="/css/uploadFile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Take a picture</title>
</head>
<body>
    <div class="container">
        <h1>TAKE A PICTURE</h1>
        <?php if (!empty($upload['errors'])): ?>
            <div class="col-xs-12" id="errors">
                <h4> AN ERROR OCCURED</h4>
            </div>
        <?php endif; ?>
        <div class="col-xs-12 col-sm-9">
            <input id="connected" type="hidden" value="1">
            <div class="col-xs-12" id="camera">
                <div id="preview">
                    <video id="video" style="width: 100%; height: auto;"></video>
                    <canvas id="canvas"></canvas>
                    <img src="#" id="photo" alt="photo" style="display: none;">
                    <img id="calque" src="/img/filters/0.png" />
                </div>
            </div>
            <div class="col-xs-12 filters">
                <?php $i = 0;?>
                <?php for (; $i <= 10; $i++):?>
                    <img id="filter-<?=$i;?>" src="/img/filters/<?=$i;?>.png" alt="<?=$i;?>">
                <?php endfor;?>
                <input id="nbrFilters" type="hidden" value="<?=$i - 1;?>">
            </div>
            <div class="col-xs-12">
                <button id="snapbutton" class="button orange display">TAKE PICTURE</button>
            </div>
            <form id="uploadFromWebcamForm" method="post" action="/upload/uploadImageFromWebcam" enctype="multipart/form-data">
                <input type="hidden" id="base64img" name="base64img" value="none">
                <input id="filter-id" type="hidden" name="filterId" value="0">
                <div class="col-xs-12 col-sm-6">
                    <button id="submit-button" class="button orange" style="display: none;">UPLOAD</button>
                </div>
            </form>
            <div class="col-xs-12 col-sm-6">
                <button id="retake-button" class="button orange" style="display: none;">RETAKE</button>
            </div>
            <div class="col-sm-12" style="height: 30px;"></div>
        </div>
        <div class="col-xs-12 col-sm-3 right-col">
            <h2>LAST UPLOADS</h2>
<!--            --><?php //  echo '<pre>';
//                    print_r($upload); ?>
            <?php foreach($upload['last_pics'] as $img): ?>
                <div class="col-sm-12">
                    <a href="/gallery/pic/<?=$img->id?>">
                        <img src="/img/uploads/<?=$img->id?><?=$img->ext?>" alt="" class="grayscale" />
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-xs-12" style="height: 50px;"></div>
    </div>
</body>

<script src="/js/takePicture.js"></script>
