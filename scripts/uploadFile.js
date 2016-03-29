/**
 * Created by Vallium on 18/03/2016.
 */

function getXMLHttpRequest() {
    var xhr = null;
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }

    return xhr;
}

function ajaxUpload(oFormElem)
{
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/upload/uploadImage", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            //console.log(xhr.responseText);
            var json = JSON.parse(xhr.responseText);

            if (json == true)
                alert('Your file was upload with success!');
            else
                console.log(json);
        }
    };

    xhr.send(new FormData(oFormElem));
}

window.onload = function(){
    var dropper = document.querySelector('#preview');

    dropper.addEventListener('dragenter', function() {
        dropper.style.borderStyle = 'dashed';
    });

    dropper.addEventListener('dragleave', function() {
        dropper.style.borderStyle = 'solid';
    });

    window.addEventListener("dragover",function(e){
        e = e || event;
        e.preventDefault();
    },false);

    //window.addEventListener("drop",function(e){
    //    e = e || event;
    //    e.preventDefault();
    //},false);

    dropper.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();

        //var files = e.dataTransfer.files,
        //    filesLen = files.length,
        //    filenames = "";
        var files = e.target.files || e.dataTransfer.files;

        //for (var i = 0 ; i < filesLen ; i++) {
            //filenames += '\n' + files[i].name;
            for (var i = 0, file; file = files[i]; i++) {
                if (file.type.indexOf("image") == 0) {
                    var reader = new FileReader();
                    reader.onload = function(e) {

                        document.getElementById("image").src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
        }
        dropper.style.borderStyle = 'solid';
        //document.getElementById('infoDragNDrop').style.display = 'none';
        //alert(files.length + ' fichier(s) :\n' + filenames);
    });

    document.getElementById("file").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").style.display = 'block';
            document.getElementById("image").src = e.target.result;
            document.getElementById('base64img').setAttribute('value', e.target.result);
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    document.getElementById("uploadForm").addEventListener("submit", function(){
        event.preventDefault();

        ajaxUpload(this);
    });
};