var theForm = document.forms["calculator"];

var ciudadPrices = new Array();
ciudadPrices["nada"] = 0;
ciudadPrices["cali"] = .77;
ciudadPrices["medellin"] = .77;
ciudadPrices["barranquilla"] = .77;
ciudadPrices["bogota"] = .67;

function getCiudadPrice() {
    var ciudadPrice = 0;
    var theForm = document.forms["calculator"];
    var selectedCiudad = theForm.elements["ciudad"];

    ciudadPrice = ciudadPrices[selectedCiudad.value];
    return ciudadPrice;
}

function getPeso() {
    var howmany = 0;
    var theForm = document.forms["calculator"];
    var peso = theForm.elements["peso"];

    if (peso.value != "") {
        howmany = parseInt(peso.value);
    }
    return howmany;
}

function getLargo() {
    var howmany = 0;
    var theForm = document.forms["calculator"];
    var largo = theForm.elements["largo"];

    if (largo.value != "") {
        howmany = parseInt(largo.value);
    }
    return howmany;
}

function getAncho() {
    var howmany = 0;
    var theForm = document.forms["calculator"];
    var ancho = theForm.elements["ancho"];

    if (ancho.value != "") {
        howmany = parseInt(ancho.value);
    }
    return howmany;
}

function getAlto() {
    var howmany = 0;
    var theForm = document.forms["calculator"];
    var alto = theForm.elements["alto"];

    if (alto.value != "") {
        howmany = parseInt(alto.value);
    }
    return howmany;
}

function getMayor() {
    var mayor = 0;
    var volumen = parseFloat(getLargo() * getAncho() * getAlto() / 166);
    var peso = parseFloat(getPeso());

    if (peso > volumen) {
        mayor = peso;
    } else {
        mayor = volumen;
    }
    return mayor;
}

function getTotal() {
    var total = parseInt(getCiudadPrice() * getMayor());
    var result = document.getElementById('totalPrice');

    result.style.display = "block";

    result.innerHTML = "Total fletes aereos $" + total;
}
