const openPopUpIn = document.getElementById('open_sign_in');
const closePopUpIn = document.getElementById('close_sign_in');
const popUpIn = document.getElementById('pop_up_sign_in')

openPopUpIn.addEventListener("click", function (e) {
    e.preventDefault();
    popUpIn.classList.add('active');
})
closePopUpIn.addEventListener("click", () => {
    popUpIn.classList.remove('active');
})



const openPopUpUp = document.getElementById('open_sign_up');
const closePopUpUp = document.getElementById('close_sign_up');
const popUpUp = document.getElementById('pop_up_sign_up')

openPopUpUp.addEventListener("click", function (e) {
    e.preventDefault();
    popUpUp.classList.add('active');
})
closePopUpUp.addEventListener("click", () => {
    popUpUp.classList.remove('active');
})


const textarea = document.getElementById('myTextarea');

textarea.addEventListener('input', function () {
    this.style.height = 'auto'; // Автоматична висота для перерахунку розміру
    this.style.height = (this.scrollHeight) + 'px'; // Розрахунок висоти на основі контенту
});
