const hamburgerMenu = document.querySelector(".hamburger-menu");
const pageHeader = document.querySelector(".header");

hamburgerMenu.addEventListener('click', function(){
    pageHeader.classList.toggle('header-visible');
});