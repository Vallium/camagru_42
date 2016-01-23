/**
 * Created by aalliot on 1/22/16.
 */

function yHandler () {

    var wrap = document.getElementById('wrap');
    var contentHeight = wrap.offsetHeight;
    var yOffset = window.pageYOffset;
    var y = yOffset + window.innerHeight;

    if (y >= contentHeight && i <= 13)
    {
        wrap.innerHTML += '<img src="/img/uploads/'+ i +'.jpg"></img>';
        i++;
    }
}

i = 2;

window.onscroll = yHandler;
