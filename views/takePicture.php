<head>
    <link href="/css/uploadFile.css" rel="stylesheet" type="text/css">
    <title>Camagru - Upload a picture</title>
    <script src="/scripts/takePicture.js"></script>
</head>
<body>
<div class="holder">
    <section>
        <article>
            <?php if(isset($_SESSION['loggedin'])):?>
                <h1>TAKE A PICTURE</h1>
                <div id="camera" style="position: relative; width: 640px; height: 480px;">
                    <video id="video"></video>
                    <div id="calque" style="position: absolute; top: 0; left: 0; z-index: 2; width: 100%; height: 100%; background-image: url('https://moniquemauve.files.wordpress.com/2014/12/ddd8f-2014-11-302b20-43-092727272727tm100c2727.png?w=640&h=480%27%27%27%27%27tm100C%27%27.png'); opacity: 1; background-repeat: no-repeat;"></div>
                </div>
                <button id="startbutton" class="button orange">TAKE PICTURE</button>
<!--                    <button id="startbutton">Prendre une photo</button>-->
                <canvas id="canvas"></canvas>
                <img src="http://placekitten.com/g/320/261" id="photo" alt="photo" style="display: none;">
                <form id="uploadFromWebcamForm" method="post" action="/upload/uploadImageFromWebcam" enctype="multipart/form-data">
                    <input type="hidden" id="base64img" name="base64img" value="none">
                    <button id="submit-button" class="button orange" style="display: none;">UPLOAD</button>
                </form>
            <?php else:?>
                <h1>YOU HAVE TO BE LOGGED TO TAKE A PICTURE</h1>
            <?php endif;?>
        </article>
    </section>
</div>
</body>