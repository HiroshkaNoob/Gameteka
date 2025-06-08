// assets/js/main.js

document.addEventListener("DOMContentLoaded", function () {
  // Инициализация мобильного меню
  initMobileMenu();

  // Анимация логотипа при наведении
  initLogoAnimation();

  // Плавная прокрутка для всех ссылок
  initSmoothScrolling();

  // Активация кнопки "Наверх"
  initBackToTop();
});

/**
 * Инициализация мобильного меню
 */
function initMobileMenu() {
  const menuToggle = document.querySelector(".mobile-menu-toggle");
  const navMenu = document.querySelector("header nav");

  if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", function () {
      navMenu.classList.toggle("active");
      this.classList.toggle("active");
    });
  }
}

/**
 * Анимация логотипа
 */
function initLogoAnimation() {
  const logo = document.querySelector(".logo img");
  if (logo) {
    logo.addEventListener("mouseenter", function () {
      this.style.transform = "scale(1.1)";
    });

    logo.addEventListener("mouseleave", function () {
      this.style.transform = "scale(1)";
    });
  }
}

/**
 * Плавная прокрутка
 */
function initSmoothScrolling() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();

      const targetId = this.getAttribute("href");
      if (targetId === "#") return;

      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        targetElement.scrollIntoView({
          behavior: "smooth",
        });
      }
    });
  });
}

/**
 * Кнопка "Наверх"
 */
function initBackToTop() {
  const backToTopButton = document.createElement("button");
  backToTopButton.className = "back-to-top";
  backToTopButton.innerHTML = "↑";
  backToTopButton.title = "Наверх";
  backToTopButton.addEventListener("click", scrollToTop);

  document.body.appendChild(backToTopButton);

  window.addEventListener("scroll", toggleBackToTopButton);

  function toggleBackToTopButton() {
    if (window.pageYOffset > 300) {
      backToTopButton.classList.add("show");
    } else {
      backToTopButton.classList.remove("show");
    }
  }

  function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  }
}

/**
 * Показ уведомлений
 */
function showNotification(message, type = "info") {
  const notification = document.createElement("div");
  notification.className = `notification notification-${type}`;
  notification.textContent = message;

  document.body.appendChild(notification);

  // Автоматическое скрытие через 5 секунд
  setTimeout(() => {
    notification.classList.add("fade-out");
    setTimeout(() => notification.remove(), 300);
  }, 5000);
}

// Добавляем стили для кнопки "Наверх" динамически
const backToTopStyles = `
.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #3498db;
    color: white;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 999;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    background-color: #2980b9;
    transform: translateY(-3px);
}

.notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 5px;
    color: white;
    z-index: 1000;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    animation: slideIn 0.3s ease-out;
}

.notification-success {
    background-color: #2ecc71;
}

.notification-error {
    background-color: #e74c3c;
}

.notification-info {
    background-color: #3498db;
}

.notification-warning {
    background-color: #f39c12;
}

.fade-out {
    animation: fadeOut 0.3s ease-in forwards;
}

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}
`;

const styleElement = document.createElement("style");
styleElement.textContent = backToTopStyles;
document.head.appendChild(styleElement);
