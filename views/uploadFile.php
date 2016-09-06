<head>
    <link href="/css/uploadFile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Upload a picture</title>
</head>
<body>
    <div class="container">
        <h1>UPLOAD A PICTURE</h1>
        <?php if (!empty($upload['errors'])): ?>
        <div class="col-xs-12" id="errors">
            <h4> AN ERROR OCCURED</h4>
        </div>
        <?php endif; ?>
<!--        --><?php //  echo '<pre>';
//        print_r($upload); ?>
        <div class="col-xs-12 col-sm-9">
            <form id="uploadForm" method="post" action="/upload/uploadImage" enctype="multipart/form-data">
                <div class="col-xs-12" id="file-to-upload">
                    <div id="upload-area">
                        <p>
                            <i class="fa upload-icon"></i>
                            Drop your image here or click to upload
                        </p>
                        <input id="input-file" type="file" name="fileToUpload" accept="image/*">
                    </div>
                    <div id="preview" style="display: none">
                        <img id="calque" src="/img/filters/0.png" />
                    </div>
                </div>
                <input id="filter-id" type="hidden" name="filterId" value="0">
                <div class="col-xs-12 filters">
                    <?php $i = 0;?>
                    <?php for (; $i <= 10; $i++):?>
                        <img id="filter-<?=$i;?>" src="/img/filters/<?=$i;?>.png" alt="<?=$i;?>">
                    <?php endfor;?>
                    <input id="nbrFilters" type="hidden" value="<?=$i - 1;?>">
                </div>
                <input type="hidden" name="MAX_UPLOAD_SIZE" value="<?=$GLOBALS['MAX_UPLOAD_SIZE'];?>">
                <div class="row" id="buttons" style="display: none;">
                    <div class="col-xs-12 col-sm-6">
                        <button class="button orange" type="submit">UPLOAD</button>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <button class="button orange" id="reset-button" type="reset">CLEAR & RETRY</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-12 col-sm-3 right-col">
            <h2>LAST UPLOADS</h2>
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

<script src="/js/uploadFile.js"></script>
