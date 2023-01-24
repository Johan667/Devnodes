const input = document.getElementById('autocomplete');

var options = {
    types: ['(cities)'],
    componentRestrictions: {country: ['fr', 'de', 'lu', 'ch', 'be', 'mc']} // Liste des codes ISO des pays à inclure
};
var autocomplete = new google.maps.places.Autocomplete(input,options);

google.maps.event.addListener(autocomplete, 'place_changed', function(){
    const place = autocomplete.getPlace();

    // Récupération de la ville
    let city;
    for (let i = 0; i < place.address_components.length; i++) {
        const addressType = place.address_components[i].types[0];
        if (addressType === 'locality') {
            city = place.address_components[i]['long_name'];
            break;
        }
    }

    // Récupération du pays
    let country;
    for (let i = 0; i < place.address_components.length; i++) {
        const addressType = place.address_components[i].types[0];
        if (addressType === 'country') {
            country = place.address_components[i]['long_name'];
            break;
        }
    }
    console.log("OK")
    console.log(`Ville : ${city}`);
    console.log(`Pays : ${country}`);
    // Envoi des données en ajax au serveur
    const data = { city: city, country: country };
    fetch('/save-location', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest' // Pour indiquer que la requête est en ajax
        }
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        console.log('Enregistrement réussi :', data);
    }).catch(function(error) {
        console.error('Erreur lors de l\'enregistrement :', error);
    });


});