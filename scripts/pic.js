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

function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function ajaxPostCom(oFormElem)
{
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/gallery/postComment", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            console.log(xhr.responseText);
            var json = JSON.parse(xhr.responseText);
            if (json['status'] == true)
            {
                document.getElementById('comments').innerHTML += '<p><a class="comLink" href="/user/profile/' + json['authorId'] + '">' + json['author'] + '</a>: ' + escapeHtml(document.getElementById('inCom').value) + '</p>';
                document.getElementById('comments').innerHTML += '<h4>' + json['date'] + '</h4>';
                var comDiv = document.getElementById("comments");
                comDiv.scrollTop = comDiv.scrollHeight;
            }
            else if (json == "noUserConnected")
                alert('You must be connected to post a comment');

            document.getElementById('inCom').value = "";
        }
    };

    xhr.send(new FormData(oFormElem));
}

function ajaxLike()
{
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/gallery/like/" + document.getElementById('img-id').value, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            var json  = JSON.parse(xhr.responseText);
            var likeButton = document.getElementById("likeChar");

            if (json == true)
            {
                document.getElementById('likeNbr').innerHTML = parseInt(document.getElementById('likeNbr').innerHTML) + 1;
                likeButton.className += " active";
            }
            else if (json == false)
            {
                document.getElementById('likeNbr').innerHTML = parseInt(document.getElementById('likeNbr').innerHTML) - 1;
                likeButton.className = "fa like";
            }
            else if (json['not_connected'] == true)
                alert('You must be connected to like a photo');
        }
    };
    xhr.send();
}


function ajaxDelImg(oFormElem)
{
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/upload/deleteImage", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            var json = JSON.parse(xhr.responseText);

            if (json == true)
            {
                alert('Your image was delete with success!');
                window.location.replace('/home');
            }
        }
    };

    xhr.send(new FormData(oFormElem));
}

window.onload = function() {
    document.getElementById("holder").scrollIntoView();

    var comDiv = document.getElementById("comments");
    comDiv.scrollTop = comDiv.scrollHeight;

    // if (document.getElementById("formComment"))
    //     document.getElementById("formComment").addEventListener("submit", function(){
    //         event.preventDefault();
    //
    //         ajaxPostCom(this);
    //     });

    if (document.getElementById("formDelete"))
        document.getElementById("formDelete").addEventListener("submit", function(){
            event.preventDefault();

            if (confirm('Are you sure you want to delete this image? You will not undo this action!'))
                ajaxDelImg(this);
        });

    // document.getElementById("likeButton").addEventListener("click", function(){
    //     event.preventDefault();
    //     //if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    //     //    alert('detect mobile');
    //     //}
    //     ajaxLike();
    // });

    document.getElementById('dblClickOnImg').addEventListener('dblclick', function() {
        event.preventDefault();

        ajaxLike();
    });
};
