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

function ajaxSignUp(oFormElem) {
    var xhr = getXMLHttpRequest();
    xhr.open("POST", "/user/signup", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var json = JSON.parse(xhr.responseText);

            if (json == true)
            {
                document.getElementById('button').style.marginTop = '40px';
                document.getElementById('errors').innerHTML = '';
                alert('Account created with success!\nYou will receive your confirmation link by email.');
                window.location.href = '/';
            }
            else
            {
                var displayErrors = "";
                
                if (json['username'] == true)
                    displayErrors += '<h4>&bull; Invalid username.</h4>';
                if (json['login_already_exists'] == true)
                    displayErrors += '<h4>&bull; Username already taken.</h4>';
                if (json['email'] == true)
                    displayErrors += '<h4>&bull; Invalid email.</h4>';
                if (json['email_already_exists'])
                    displayErrors += '<h4>&bull; An account with this mail already exists.</h4>';
                if (json['password'] == true)
                    displayErrors += '<h4>&bull; Invalid password.</h4>';
                if (json['password_match'] == true)
                    displayErrors += '<h4>&bull; Passwords do not match.</h4>';

                document.getElementById('button').style.marginTop = '20px';
                document.getElementById('errors').innerHTML = displayErrors;
            }
        }
    };

    xhr.send(new FormData(oFormElem));
}

window.onload = function () {
    document.getElementById('signUpForm').addEventListener("submit", function () {
        event.preventDefault();
        ajaxSignUp(this);
    });
};