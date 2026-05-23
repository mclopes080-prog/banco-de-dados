const menuToggle = document.querySelector(".menu-toggle");
const mainNav = document.querySelector(".main-nav");
const filterButtons = document.querySelectorAll(".filter-button");
const productCards = document.querySelectorAll(".product-card");
const productSearch = document.querySelector("#productSearch");
const cartButtons = document.querySelectorAll(".cart-button");
const cartCount = document.querySelector("#cartCount");

let activeFilter = "todos";
let cartTotal = 0;

function applyProductFilters() {
  const searchTerm = productSearch ? productSearch.value.trim().toLowerCase() : "";

  productCards.forEach((card) => {
    const categoryMatches = activeFilter === "todos" || card.dataset.category === activeFilter;
    const searchMatches = !searchTerm || card.dataset.name.includes(searchTerm);
    card.classList.toggle("hidden", !(categoryMatches && searchMatches));
  });
}

if (menuToggle && mainNav) {
  menuToggle.addEventListener("click", () => {
    const isOpen = mainNav.classList.toggle("open");
    menuToggle.setAttribute("aria-expanded", String(isOpen));
  });

  mainNav.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      mainNav.classList.remove("open");
      menuToggle.setAttribute("aria-expanded", "false");
    });
  });
}

filterButtons.forEach((button) => {
  button.addEventListener("click", () => {
    filterButtons.forEach((item) => item.classList.remove("active"));
    button.classList.add("active");
    activeFilter = button.dataset.filter;
    applyProductFilters();
  });
});

if (productSearch) {
  productSearch.addEventListener("input", applyProductFilters);
}

cartButtons.forEach((button) => {
  button.addEventListener("click", () => {
    cartTotal += 1;
    if (cartCount) {
      cartCount.textContent = String(cartTotal);
    }

    button.classList.add("added");
    button.textContent = "Adicionado";

    window.setTimeout(() => {
      button.classList.remove("added");
      button.textContent = "Adicionar";
    }, 1100);
  });
});
