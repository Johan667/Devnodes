document.addEventListener("DOMContentLoaded", function() {
    const preferredChoices = document.querySelectorAll('.preferred-choice');
    preferredChoices.forEach(choice => {
        const deleteLink = document.createElement('a');
        deleteLink.href = '#';
        deleteLink.innerHTML = ' Supprimer <i class="fas fa-trash"></i>';
        choice.appendChild(deleteLink);

        deleteLink.addEventListener('click', function(event) {
            event.preventDefault();
            // Ajoutez ici le code pour supprimer la compétence sélectionnée
        });
    });
});