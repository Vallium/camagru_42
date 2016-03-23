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
    document.getElementById("uploadForm").addEventListener("submit", function(){
        event.preventDefault();

        ajaxUpload(this);
    });

};