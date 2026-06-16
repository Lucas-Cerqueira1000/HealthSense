const menu = document.querySelector('#mobile-menu');
const navLinks = document.querySelector('.nav-links');
const overlay = document.querySelector('.overlay');
const links = document.querySelectorAll('.nav-links a');

menu.addEventListener('click', () => {
  menu.classList.toggle('active');
  navLinks.classList.toggle('active');
  overlay.classList.toggle('active');
});

// fechar ao clicar no overlay
overlay.addEventListener('click', () => {
  menu.classList.remove('active');
  navLinks.classList.remove('active');
  overlay.classList.remove('active');
});

// fechar ao clicar em um link
links.forEach(link => {
  link.addEventListener('click', () => {
    menu.classList.remove('active');
    navLinks.classList.remove('active');
    overlay.classList.remove('active');
  });
});