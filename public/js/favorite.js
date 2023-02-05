function toggleFavorite(freelancerId) {
    // Get the heart icon element
    var icon = document.getElementById("favorite-icon-" + freelancerId);

    // Check if the freelancer is already a favorite
    if (icon.classList.contains("fas")) {
      // Remove the freelancer from favorites
      icon.classList.remove("fas");
      icon.classList.add("far");

      // Send a DELETE request to the server to remove the freelancer from favorites
      fetch("/favorite/" + freelancerId, {
        method: "DELETE",
      });
    } else {
      // Add the freelancer to favorites
      icon.classList.remove("far");
      icon.classList.add("fas");

      // Send a POST request to the server to add the freelancer to favorites
      fetch("/favorite/" + freelancerId, {
        method: "POST",
      });
    }
  }










/** 
$(document).on('click', '.fa-heart', function () {
    var id = $(this).attr('id').replace('favorite-icon-', '');
    var $icon = $(this);

    $.post('/favorite/' + id + '/toggle', function (data) {
        if (data.status === 'success') {
            $icon.toggleClass('favorited');
        }
    });
});
*/