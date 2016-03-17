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

function ajaxPostCom(oFormElem)
{
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/gallery/postComment", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var json = JSON.parse(xhr.responseText);

            if (json = true)
            {
                document.getElementById('comments').innerHTML += '<p>' + document.getElementById('inCom').value + '</p>';
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
        if (xhr.readyState == 4 && xhr.status == 200) {
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
                likeButton.className = "like";
            }
            else if (json == "noUserConnected")
                alert('You must be connected to like a photo');
        }
    };
    xhr.send();
}


window.onload = function () {
    document.getElementById("divToScroll").scrollIntoView({behavior: "smooth"});

    document.getElementById("formComment").addEventListener("submit", function(){
        event.preventDefault();

        ajaxPostCom(this);
    });

    document.getElementById("likeButton").addEventListener("click", function(){
        event.preventDefault();

        ajaxLike();

    });
};
