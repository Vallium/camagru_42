<head>
    <link href="/css/uploadFile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Upload a picture</title>
    <script src="/scripts/uploadFile.js"></script>
</head>
<body>
    <div class="holder">
        <section>
            <article>
                <?php if(isset($_SESSION['loggedin'])):?>
                    <h1>UPLOAD A PICTURE</h1>
                    <form id="uploadForm" method="post" action="/upload/uploadImage" enctype="multipart/form-data">
                        <div>
                            <label>FILE TO UPLOAD</label>
                            <input type="file" name="fileToUpload">
                        </div>
                        <input type="hidden" name="MAX_UPLOAD_SIZE" value="<?=$GLOBALS['MAX_UPLOAD_SIZE'];?>">
                        <button class="button orange">UPLOAD</button>
                    </form>
                <?php else:?>
                    <h1>YOU HAVE TO BE LOGGED TO POST A PICTURE</h1>
                <?php endif;?>
            </article>
        </section>
    </div>
</body>