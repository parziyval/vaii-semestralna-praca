class KnihaNavstev {
    pridajPrispevok() {
        console.log("pridaj");
        let text = document.getElementById("kn_text").value;
        if(text.length == 0) {
            alert("Vyplňte text príspevku.");
            return;
        }

        fetch("?c=knihanavstev&a=pridajPrispevok", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                //'Content-Type': 'application/json',
                //'Accept': 'application/json'
            },
            body: "kn_text=" + text
        })
            .then(response => response.json())
            .then(response => {
                if(response === "error") {
                    alert("Vyplňte text príspevku.");
                }
            });
    }

    getVsetkyPrispevky() {
        fetch('?c=knihanavstev&a=getVsetkyPrispevky')
            .then(response => response.json())
            .then(data => {
                let html = "";
                for(let prispevok of data) {
                    html = "<div class=\"card my-3 cierne-pismo\">\n" +
                        "                    <div class=\"card-body\">\n" +
                        "                        <h5 class=\"card-title\">" + prispevok.uzivatel_email  + "</h5>\n" +
                        "                        <h6 class=\"card-subtitle mb-2 text-muted\">" + prispevok.datum_pridania + "</h6>\n" +
                        "                        <p class=\"card-text\">" + prispevok.text + "</p>\n" +
                        "                    </div>\n" +
                        "                </div>" + html;
                    //html = "<div>" + prispevok.text + "</div>" + html;
                }
                document.getElementById("kn_prispevky").innerHTML = html;
            });
    }

    zacniNacitavatPrispevky() {
        setInterval(()=> {
            this.getVsetkyPrispevky()
        }, 1000);
    }
}

window.onload = function() {
    var kn = new KnihaNavstev();

    kn.getVsetkyPrispevky();
    kn.zacniNacitavatPrispevky();

    document.getElementById("kn_btn_odoslat").onclick = () => {
        kn.pridajPrispevok();
    }
}