const addImage = document.querySelector('#add-image');
addImage.addEventListener('click', ()=>{
    //compter combien j'ai de form group pour les indeices ex annonce image 0 url
    const widgetCounter = document.querySelector("#widgets-counter")
    const index = +widgetCounter.value // le + transforme un string en nombre
    const annonceImages = document.querySelector("#product_backgrounds")
    //recup le prototype dans la div

    const prototype = annonceImages.dataset.prototype.replace(/__name__/g, index)// drapeau g pour indiquer que l'on va le faire plusieurs fois
    annonceImages.insertAdjacentHTML('beforeend', prototype)
    widgetCounter.value = index+1
    handleDeleteButtons()
})

const updateCounter = () => {
    const count = document.querySelectorAll("#product_backgrounds div.form-group").length
    document.querySelector("#widgets-counter").value = count
}

const handleDeleteButtons = () => {
    let deletes = document.querySelectorAll("button[data-action='delete']")
    deletes.forEach(button => {
        button.addEventListener('click', ()=>{
            const target = button.dataset.target
            const elementTarget = document.querySelector(target)
            if(elementTarget){
                elementTarget.remove() //supprimer l'element
            }
        })
    })
}

updateCounter()
handleDeleteButtons()