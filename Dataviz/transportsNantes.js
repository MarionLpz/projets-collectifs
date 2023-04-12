//Appel de l'API - Parkings publics
async function fetchParkingPublics() {
    let response = await fetch('https://data.nantesmetropole.fr/api/records/1.0/search/?dataset=244400404_parkings-publics-nantes-disponibilites&q=&lang=fr&rows=31&facet=grp_nom&facet=grp_statut&timezone=Europe%2FParis')
    let parkingsPublics = await response.json()
    // parkingsPublics = JSON.stringify(parkingsPublics)
    console.log('COUCOU', parkingsPublics)

    //let element = document.getElementById("zoneParkingsPublics")
    let list = document.getElementById("parkingsPublics")

    //affichage des noms + disponibilités en liste
    const parkingsTab = parkingsPublics.records
    console.log(parkingsTab)
    for (const parking of parkingsTab) {
        console.log(parking.fields.grp_nom)
        list.innerHTML += '<li>' + parking.fields.grp_nom + '<br>' + parking.fields.disponibilite + " places restantes" + '</li>'
    }
}
