const burgerBtn =document.querySelector('.burger-btn')

burgerBtn.addEventListener('click', () => {
    burgerBtn.parentNode.classList.toggle('activeMenuBar');
})
