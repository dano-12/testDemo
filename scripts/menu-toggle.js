const hamMenu = document.querySelector('.ham-menu');
const overlay = document.querySelector('.overlay');
const offScreen = document.querySelector('.off-screen-menu');
const menuLinks = document.querySelectorAll('.off-screen-menu a');

function openMenu() {
  hamMenu.classList.add('active');
  offScreen.classList.add('active');
  overlay.classList.add('active');
}

function closeMenu() {
  hamMenu.classList.remove('active');
  offScreen.classList.remove('active');
  overlay.classList.remove('active');
}

hamMenu.addEventListener('click', () => {
  if (offScreen.classList.contains('active')) closeMenu();
  else openMenu();
});

overlay.addEventListener('click', closeMenu);
menuLinks.forEach(link => link.addEventListener('click', closeMenu));
