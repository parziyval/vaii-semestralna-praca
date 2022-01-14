class Prehlad {
    nacitajTabulku(pole = "", vzostupne = "") {
        let url_adresa = "?c=prehlad&a=dajZoradene";
        if(pole != "" && vzostupne != "") {
            url_adresa += "&pole=" + pole + "&vzostupne=" + vzostupne;
        }
        fetch("?c=prehlad&a=dajZoradene")
            .then(response => response.json())
            .then(data => {
                let html = "";
                for(let zaznam of data) {
                    html = html + "<tr>" +
                        "<td>" + zaznam.id + "</td>" +
                        "<td>" + zaznam.email + "</td>" +
                        "<td>" + zaznam.meno + "</td>" +
                        "<td>" + zaznam.priezvisko + "</td>" +
                        "</tr>";
                }
                document.getElementById("tab_uzivatelia").innerHTML = html;
            });
    }
}

window.onload = function() {
    var prehlad = new Prehlad();

    prehlad.nacitajTabulku();

    /*document.getElementById('zorad_email').onclick = () => {
        prehlad.nacitajTabulku("email","false");
    }*/

    /*document.getElementById("kn_btn_odoslat").onclick = () => {
        kn.pridajPrispevok();
    }*/
}