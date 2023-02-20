const form = document.querySelector('form[name="comment"]')
const textarea = form.querySelector('textarea')
const parentMessage = document.querySelector("#comment_parentid")
let close = null
document.querySelectorAll("[data-reply]").forEach(element => {
    element.addEventListener("click", function(evt){

        if (close !== null) close.remove()

        const parentAuthor = this.parentNode
        const textAuthor = parentAuthor.textContent
        const parentElement = parentAuthor.parentNode
        const message = parentElement.querySelector('.commentContent')

        parentMessage.value = this.dataset.id;
        textarea.placeholder = 'test'

        close = document.createElement('i')
        close.addEventListener('click', e => {
            textarea.value = ''
            textarea.placeholder = ''
            parentMessage.value = ''
            close.remove()
        })
        close.classList.add('fa', 'fa-x')


        form.append(close)
    })
})