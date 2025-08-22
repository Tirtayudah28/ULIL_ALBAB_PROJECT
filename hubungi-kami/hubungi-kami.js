// Hamburger toggle
const hamburgerIcon = document.getElementById("hamburger-icon");
const closeIcon = document.getElementById("close-icon");
const navbarNav = document.querySelector(".navbar-nav");

hamburgerIcon?.addEventListener("click", () => {
  navbarNav.classList.add("show");
  hamburgerIcon.style.display = "none";
  closeIcon.style.display = "inline-block";
});

closeIcon?.addEventListener("click", () => {
  navbarNav.classList.remove("show");
  hamburgerIcon.style.display = "inline-block";
  closeIcon.style.display = "none";
});

// Dropdown toggle
const mediaToggle = document.getElementById("mediaToggle");
const mediaMenu = document.getElementById("mediaMenu");

mediaToggle?.addEventListener("click", () => {
  mediaMenu.classList.toggle("show");
});

// Tandai link aktif berdasarkan URL
const allNavLinks = document.querySelectorAll('.navbar-nav a, .menu-content a');
const currentUrl = window.location.href;

allNavLinks.forEach(link => {
  const href = link.getAttribute('href');
  if (href && currentUrl.includes(href)) {
    link.classList.add('active');
  }
});


// Hindari reload jika sudah di halaman yang sama
allNavLinks.forEach(link => {
  link.addEventListener("click", (e) => {
    if (window.location.href.includes(link.getAttribute("href"))) {
      e.preventDefault();
    }
  });
});

window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('scrolled', window.scrollY > 1);
  });