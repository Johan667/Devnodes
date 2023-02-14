function toggleFavorite(freelancerId) {
    // Get the heart icon element
    var icon = document.getElementById("favorite-icon-" + freelancerId);

    // Check if the freelancer is already a favorite
    if (icon.classList.contains("fa-solid")) {

        // Send a DELETE request to the server to remove the freelancer from favorites
        fetch("/favorite/" + freelancerId, {
            method: "DELETE",
        }).then(r => r.json()).then(data => {
            if (data.success) {
                icon.classList.remove("fa-solid");
                icon.classList.add("fa-regular");
            }
        }).then(()=>{
            location.reload();
        })
    } else {
        // Add the freelancer to favorites


        // Send a POST request to the server to add the freelancer to favorites
        fetch("/favorite/" + freelancerId, {
            method: "POST",
        }).then(r => r.json()).then(data => {
            icon.classList.remove("fa-regular");
            icon.classList.add("fa-solid");
        }).then(()=>{
            location.reload();
        });
    }
}