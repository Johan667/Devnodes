let currentStep = 1;
let testing ="ok";

/* formulaire dynamique freelance */
function nextStep(step) {

    currentStep = step;

    for (let i = 1; i <= 5; i++) {
        if (i !== step) {
            document.getElementById(`step${i}`).style.display = "none";
        } else {
            document.getElementById(`step${i}`).style.display = "block";
        }
    }

    // supprimer la classe "active" de tous les boutons
    let stepButtons = document.querySelectorAll('.step-button');
    for (let i = 0; i < stepButtons.length; i++) {
        stepButtons[i].classList.remove('active');
    }

    // ajouter la classe "active" au bouton correspondant à l'étape actuelle
    let activeButton = document.querySelector(`.step-button[data-step="${currentStep}"]`);
    activeButton.classList.add('active');
    console.log(activeButton)
    console.log(currentStep)
}