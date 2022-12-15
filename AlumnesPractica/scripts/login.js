window.onload = main;

function main() {
    document.getElementById("enviar").addEventListener("click", login);
}


function login() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    let user = {
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
    })
    .catch((error) => {
        console.error("Error: ", error);
    });
}