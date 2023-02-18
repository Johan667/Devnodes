document.querySelectorAll("[data-reply]").forEach(element => {
    element.addEventListener("click", function(){
        document.querySelector("#comment_parentid").value = this.dataset.id;
    })
})