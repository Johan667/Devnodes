/* MENU BURGER */
var sidenav = document.getElementById("mySidenav");
var openBtn = document.getElementById("openBtn");
var closeBtn = document.getElementById("closeBtn");

openBtn.onclick = openNav;
closeBtn.onclick = closeNav;

/* Set the width of the side navigation to 250px */
function openNav() {
    sidenav.classList.add("active");
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    sidenav.classList.remove("active");
}
/* MENU BURGER */

/* CAPTCHA */

function onSubmit(token) {
    document.getElementById("demo-form").submit();
}

/* FIN CAPTCHA */



/* CHARGEMENT */

// JavaScript pour afficher le GIF de chargement pendant le chargement de la page
window.addEventListener('beforeunload', function() {
    // Récupération de l'élément où afficher le GIF de chargement
    const loaderContainer = document.querySelector('#loader-container');

    // Affichage du GIF de chargement dans l'élément récupéré
    loaderContainer.style.display = 'block';
});

// JavaScript pour masquer le GIF de chargement lorsque la page est complètement chargée
window.addEventListener('load', function() {
    // Récupération de l'élément où afficher le GIF de chargement
    const loaderContainer = document.querySelector('#loader-container');

    // Masquage du GIF de chargement dans l'élément récupéré
    loaderContainer.style.display = 'none';
});

/* FIN CHARGEMENT */