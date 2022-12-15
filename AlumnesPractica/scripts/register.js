window.onload = main;

function main() {
    document.getElementById("enviar").addEventListener("click", validar);
}


function validarNom() {
    var element = document.getElementById("nom");
    if (!element.checkValidity()) {
        if (element.validity.valueMissing) {
            error2(element, "Error: Deus introduir un nom");
        }
        if (element.validity.patternMismatch) {
            error2(element, "Error: Nom no valid");
        }
        return false;
    }
    return true;
}

function validarEmail() {
    var element = document.getElementById("email");
    if (!element.checkValidity()) {
        if (element.validity.valueMissing) {
            error2(element, "Error: Deus introduir un email");
        }
        if (element.validity.patternMismatch) {
            error2(element, "Error: Email no valid");
        }
        return false;
    }
    return true;
}

function validarPassword() {
    var element = document.getElementById("password");
    if (!element.checkValidity()) {
        if (element.validity.valueMissing) {
            error2(element, "Error: Deus introduir una contrasenya");
        }
        if (element.validity.patternMismatch) {
            error2(element, "Error: Contrasenya no valida");
        }
        return false;
    }
    return true;
}

function validar(e) {
    e.preventDefault();
    esborrarError();
    if (validarNom() && validarEmail() && validarPassword() && confirm("Confirmar enviament del formulari")) {
        register();
        return true;
    } else {
        return false;
    }
}

function error2(element, missatge) {
    document.getElementById("missatgeError").innerHTML = missatge;
    element.className = "form-control";
    element.focus();
}

function esborrarError() {
    var formulari = document.forms[0];
    for (var i = 0; i < formulari.elements.length - 1; i++) {
        formulari.elements[i].className = "form-control";
    }
}

function register() {
    var nom = document.getElementById("nom").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    let user = {
        name: nom,
        email: email,
        password: password
    }

    fetch('https://userprofile.serverred.es/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(user),
    })
    .then(response=> response.json())
    .then(user => {
        console.log("Succes:", user);
        document.getElementById("missatgeError").innerHTML = user.error;
    })
}