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
    //xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('inCom').value = "";
            //var json  = JSON.parse(xhr.responseText);
            //for (var i = 0; i < json.length; i++) {
            //    //wrap.innerHTML += '<div class="col-' + (i + 1) + '"><img src="/img/uploads/' + json[i].id + '.jpg" class="grayscale"></img></div>';
            //    wrap.innerHTML += '<a href="/gallery/pic/' +json[i].id + '"><img src="/img/uploads/' + json[i].id + '.jpg" class="grayscale"></img></a>';
            //}
            //imgNb += 3;
        }
    }

    xhr.send(new FormData(oFormElem));
    return false;
}

window.onload = function () {
    document.getElementById("divToScroll").scrollIntoView({behavior: "smooth"});
};
