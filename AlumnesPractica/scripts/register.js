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
    esborrarError();
    if (validarNom() && validarEmail() && validarPassword() && confirm("Confirmar enviament del formulari")) {
        location.href = "index.html";
        return true;
    } else {
        e.preventDefault();
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
    for (var i = 0; i < formulari.elements.length -1; i++) {
        formulari.elements[i].className = "form-control";
    }
}




function register() {

    fetch('', {
        method: 'POST',

    })

}