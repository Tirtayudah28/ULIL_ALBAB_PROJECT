// translate.js

const translations = {
  id: {
    home: "Beranda",
    about: "Tentang Kami",
    program: "Program",
    media: "Media",
    news: "Berita",
    publication: "Publikasi",
    pojok: "Pojok Baca",
    contact: "Hubungi Kami",
    donate: "❤️ Donasi",
  },
  en: {
    home: "Home",
    about: "About Us",
    program: "Programs",
    media: "Media",
    news: "News",
    publication: "Publications",
    pojok: "Reading Corner",
    contact: "Contact Us",
    donate: "❤️ Donate",
  },
};

document.addEventListener("DOMContentLoaded", () => {
  const langLinks = document.querySelectorAll("[href*='?lang=']");

  function changeLanguage(lang) {
    document.querySelectorAll("[data-key]").forEach((el) => {
      const key = el.getAttribute("data-key");
      if (translations[lang] && translations[lang][key]) {
        el.textContent = translations[lang][key];
      }
    });
    localStorage.setItem("lang", lang);
  }

  // Ambil bahasa terakhir (default ID)
  const savedLang = localStorage.getItem("lang") || "id";
  changeLanguage(savedLang);

  // Klik di menu bahasa
  langLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const lang = link.getAttribute("href").split("lang=")[1];
      changeLanguage(lang);
    });
  });
});
