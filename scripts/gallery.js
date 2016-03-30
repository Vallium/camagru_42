/**
 * Created by aalliot on 1/22/16.
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

function fileExists(url)
{
    var http = getXMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status != 404;
}

function ajaxLoadMore()
{
    var xhr = getXMLHttpRequest();
    xhr.open("GET", "/gallery/loadMore/" + imgNb + "/3", false);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var json  = JSON.parse(xhr.responseText);
            if (json == false)
                document.getElementById('formLoadMore').style.display = 'none';
            else
            {
                for (var i = 0; i < json.length; i++)
                {
                    var ext;
                    if (fileExists('/img/uploads/' + json[i].id + '.jpg'))
                        ext = '.jpg';
                    else if (fileExists('/img/uploads/' + json[i].id + '.png'))
                        ext = '.png';
                    wrap.innerHTML += '<a href="/gallery/pic/' + json[i].id + '"><img src="/img/uploads/' + json[i].id + ext + '" class="grayscale"></img></a>';
                }
                imgNb += 3;
            }
        }
    };

    xhr.send();
}

function yHandler()
{

    var wrap = document.getElementById('wrap');
    var contentHeight = wrap.offsetHeight;
    var yOffset = window.pageYOffset;
    var y = yOffset + window.innerHeight;

    if (y >= contentHeight)
    {
        ajaxLoadMore();
    }
}

window.onload = function () {
    imgNb = parseInt(document.getElementById('nb_img_on_gallery_load').value);

    window.onscroll = yHandler;

    document.getElementById("formLoadMore").addEventListener("submit", function(){
        event.preventDefault();
        ajaxLoadMore();
    });
};