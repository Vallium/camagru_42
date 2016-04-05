/**
 * Created by aalliot on 1/21/16.
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

function ajaxSendRetrieveRequest() {
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/user/sendRetrieveRequest", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var json = JSON.parse(xhr.responseText);
            console.log(json);
        }
    };
    //
    xhr.send();
}

function ajaxSignIn(oFormElem) {
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/user/signin", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var json = JSON.parse(xhr.responseText);

            if (json == true)
            {
                document.getElementById('button').style.marginTop = '40px';
                document.getElementById('errors').innerHTML = '';
                window.location.href = '/';
            }
            else
            {
                var displayErrors = "";

                if (json['username'] == true)
                    displayErrors += '<h4>&bull; Invalid username.</h4>';
                if (json['user_not_found'] == true)
                    displayErrors += '<h4>&bull; Username not found.</h4>';
                if (json['password'] == true)
                    displayErrors += '<h4>&bull; Invalid password.</h4>';
                if (json['bad_pass'] == true)
                    displayErrors += '<h4>&bull; Bad password.</h4>';

                document.getElementById('button').style.marginTop = '20px';
                document.getElementById('errors').innerHTML = displayErrors;

                if (json['user_not_activated'] == true)
                    alert('User not activated!/nIf it is your login, please click on the acivation link your received by email.');
            }
        }
    };

    xhr.send(new FormData(oFormElem));
}

window.onload = function () {
    document.getElementById('signInForm').addEventListener("submit", function () {
        event.preventDefault();
        ajaxSignIn(this);
    });

    //document.getElementById('retrieve').addEventListener("click", function() {
    //   event.preventDefault();
    //    ajaxSendRetrieveRequest();
    //});
};