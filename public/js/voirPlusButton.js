function togglePlus() {
    //
    const voirPlusBtn = document.getElementById("voirPlusBtn");
    const icon = voirPlusBtn.querySelector(".fa");


    if (icon.classList.contains("fa-minus")) {
        icon.classList.remove("fa-minus");
        icon.classList.add("fa-plus");
    } else {
        icon.classList.remove("fa-plus");
        icon.classList.add("fa-minus");
    }
}