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

function ajaxPostImgFromWebcam(oFormElem)
{
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/upload/uploadImageFromWebcam", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var json = JSON.parse(xhr.responseText);
            if (json['state'] == true)
            {
                // alert('Your file was upload with success!');
                window.location.href = '/gallery/pic/' + json['last_insert_id'];
            }
            else
                console.log(json);
        }
    };

    xhr.send(new FormData(oFormElem));
}

(function () {
    if (document.getElementById('connected').value == 0)
        return;

    var streaming = false,
        video = document.querySelector('#video'),
        cover = document.querySelector('#cover'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#photo'),
        snapbutton = document.querySelector('#snapbutton'),
        retakebutton = document.querySelector('#retake-button'),
        width = 640,
        height = 480;

    navigator.getMedia = ( navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

    navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function (stream) {
            if (navigator.mozGetUserMedia) {
                video.mozSrcObject = stream;
            } else {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
        },
        function (err) {
            console.log("An error occured! " + err);
        }
    );

    video.addEventListener('canplay', function (ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    function takepicture() {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        document.getElementById('base64img').setAttribute('value', data);
    }

    snapbutton.addEventListener('click', function (ev) {
        document.getElementById('submit-button').style.display = 'block';
        retakebutton.style.display = 'block';
        snapbutton.style.display = 'none';

        takepicture();
        ev.preventDefault();
    }, false);

    retakebutton.addEventListener('click', function () {
        photo.setAttribute('src', ' ');
        document.getElementById('base64img').setAttribute('value', ' ');
        canvas.getContext('2d').clearRect(0, 0, width, height);

        document.getElementById('submit-button').style.display = 'none';
        retakebutton.style.display = 'none';
        snapbutton.style.display = 'block';
    });

    for (var i = 0; i <= document.getElementById('nbrFilters').value; i++) {
        if (i == 0)
            document.getElementById('filter-' + i).style.borderColor = '#ff6800';

        document.getElementById('filter-' + i).addEventListener('click', function () {
            // console.log('Filter ' + this.alt);

            document.getElementById('calque').src = '/img/filters/' + this.alt + '.png';
            document.getElementById('filter-id').value = this.alt;
            for (var i = 0; i <= document.getElementById('nbrFilters').value; i++) {
                var target = document.getElementById('filter-' + i);

                if (target.alt == this.alt)
                    target.style.borderColor = '#ff6800';
                else
                    target.style.borderColor = 'transparent';
            }
        });
    }

})();