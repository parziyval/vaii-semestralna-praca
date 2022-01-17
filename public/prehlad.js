class Prehlad {
    constructor() {
        this.lastVzostupne = null;
        this.lastStlpec = "";
    }

    nacitajZoradenu(stlpec="") {
        let url_adresa = "?c=prehlad&a=dajZoradene";
        let vzostupne;
        let lastStlpecId = "sipka_" + this.lastStlpec;
        let lastHeaderId = "zorad_" + this.lastStlpec;
        let currStlpecId = "sipka_" + stlpec;
        let currHeaderId = "zorad_" + stlpec;
        this.lastStlpec = stlpec;


        if(this.lastVzostupne == null) { //ak sa povodne nezoradovala, nastavi sa zoradenie na vzostupne
            vzostupne = "true";
            this.lastVzostupne = true;
            document.getElementById(currStlpecId).classList.add("bi-caret-up-fill");
            document.getElementById(currHeaderId).classList.add("selected");
        } else if(this.lastVzostupne) { //ak bola naposledy zoradovana vzostupne, nastavi sa zoradenia na zostupne
            vzostupne = "false";
            this.lastVzostupne = false;
            document.getElementById(lastStlpecId).classList.remove("bi-caret-up-fill");
            document.getElementById(lastHeaderId).classList.remove("selected");
            document.getElementById(currStlpecId).classList.add("bi-caret-down-fill");
            document.getElementById(currHeaderId).classList.add("selected");
        } else { //if this.lastVzostupne == false //ak bola naposledy zoradovana zostupne, nastavi sa ze sa nebude zoradovat
            vzostupne = ""
            this.lastVzostupne = null;
            document.getElementById(lastStlpecId).classList.remove("bi-caret-down-fill");
            document.getElementById(lastHeaderId).classList.remove("selected");
        }

        if(stlpec != "" && vzostupne != "") {
            url_adresa += "&stlpec=" + stlpec + "&vzostupne=" + vzostupne;
        }

        this.nacitajTabulku(url_adresa);

    }

    nacitajTabulku(url_adresa) {
        fetch(url_adresa)
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

    prehlad.nacitajTabulku("?c=prehlad&a=dajZoradene");

    document.getElementById('zorad_id').onclick = () => {
        prehlad.nacitajZoradenu("id");
    }

    document.getElementById('zorad_email').onclick = () => {
        prehlad.nacitajZoradenu("email");
    }

    document.getElementById('zorad_meno').onclick = () => {
        prehlad.nacitajZoradenu("meno");
    }

    document.getElementById('zorad_priezvisko').onclick = () => {
        prehlad.nacitajZoradenu("priezvisko");
    }
}