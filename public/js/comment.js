const form = document.querySelector('form[name="comment"]')
const buttonsPlacement = form.querySelector('.buttonsPlacement')
const textarea = form.querySelector('textarea')
const parentMessage = document.querySelector("#comment_parentid")
let close = null
let replyBtn = null
let replyTooltip = null
document.querySelectorAll("[data-reply]").forEach(element => {
    element.addEventListener("click", function(evt){

        if (close !== null) close.remove()
        if (replyBtn !== null) replyBtn.remove()
        if (replyTooltip !== null) replyTooltip.remove()

        const parentAuthor = this.parentNode
        const parentElement = parentAuthor.parentNode
        const textAuthor = parentElement.querySelector('.commentAuthor').textContent
        const message = parentElement.querySelector('.commentContent').textContent


        parentMessage.value = this.dataset.id;
        textarea.placeholder = 'replying to: ' + textAuthor + '\n' + message

        replyBtn = document.createElement('button')
        close = document.createElement('i')
        replyTooltip = document.createElement('span')
        replyTooltip.innerHTML = "click to remove reply"

        replyBtn.addEventListener('click', e => {
            textarea.value = ''
            textarea.placeholder = ''
            parentMessage.value = ''
            close.remove()
            replyBtn.remove()
            replyTooltip.remove()
        })
        close.classList.add('fa', 'fa-x', 'reply-icon')
        replyBtn.classList.add('btn', 'btn-danger', 'reply-button')
        replyTooltip.classList.add('tooltiptext')

        buttonsPlacement.append(replyBtn)
        replyBtn.append(replyTooltip)
        replyBtn.append(close)
    })
})