/* formulaire dynamique freelance */
    function nextStep(step) {
    for (let i = 1; i <= 5; i++) {
    if (i !== step) {
    document.getElementById(`step${i}`).style.display = "none";
} else {
    document.getElementById(`step${i}`).style.display = "block";
}
}
}
