import './bootstrap';

// Функция для переключения темы (светлая/темная)
function setupThemeToggle() {
    const themeToggle = document.querySelector('.theme-toggle');
    if (!themeToggle) return;

    // Проверка сохраненной темы в localStorage
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);
    
    // Обновление иконки в зависимости от темы
    updateThemeIcon(currentTheme);

    // Обработчик клика по кнопке переключения темы
    themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        updateThemeIcon(newTheme);
    });
}

// Обновление иконки темы
function updateThemeIcon(theme) {
    const themeToggle = document.querySelector('.theme-toggle');
    if (!themeToggle) return;
    
    if (theme === 'dark') {
        themeToggle.innerHTML = '<i class="fa fa-sun"></i>';
        themeToggle.setAttribute('title', 'Переключить на светлую тему');
    } else {
        themeToggle.innerHTML = '<i class="fa fa-moon"></i>';
        themeToggle.setAttribute('title', 'Переключить на темную тему');
    }
}

// Функция для мобильного меню
function setupMobileMenu() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (!mobileMenuToggle || !navMenu) return;
    
    mobileMenuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('open');
        
        // Обновление иконки меню
        const isOpen = navMenu.classList.contains('open');
        mobileMenuToggle.innerHTML = isOpen ? 
            '<i class="fa fa-times"></i>' : 
            '<i class="fa fa-bars"></i>';
    });
    
    // Закрытие меню при клике по ссылке
    const navLinks = navMenu.querySelectorAll('a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('open');
            mobileMenuToggle.innerHTML = '<i class="fa fa-bars"></i>';
        });
    });
}

// Закрытие уведомлений
function setupAlertDismiss() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                alert.style.display = 'none';
            });
        }
    });
}

// Инициализация после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    setupThemeToggle();
    setupMobileMenu();
    setupAlertDismiss();
});
