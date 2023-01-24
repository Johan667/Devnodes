const input = document.getElementById('city');
var autocomplete = new google.maps.places.Autocomplete(input);
google.maps.event.addListener(autocomplete, 'place_changed', function(){
    const place = autocomplete.getPlace();
    input.value = place.name
});

