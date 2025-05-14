// Главный JavaScript файл Olympecs
document.addEventListener('DOMContentLoaded', function() {
    // Переключение темы
    initThemeToggle();
    
    // Мобильное меню
    initMobileMenu();
    
    // Плавный скролл
    initSmoothScroll();
    
    // Анимации при скролле
    initScrollAnimations();
    
    // Подсветка активного пункта меню
    highlightActiveMenuItem();
});

// Инициализация переключателя темы
function initThemeToggle() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const htmlElement = document.documentElement;
    
    if (!themeToggleBtn) return;
    
    // Проверяем сохраненную тему в localStorage
    if (localStorage.getItem('theme') === 'dark' || 
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.setAttribute('data-theme', 'dark');
        themeToggleLightIcon.classList.remove('hidden');
        themeToggleDarkIcon.classList.add('hidden');
    } else {
        htmlElement.setAttribute('data-theme', 'light');
        themeToggleLightIcon.classList.add('hidden');
        themeToggleDarkIcon.classList.remove('hidden');
    }
    
    // Обработчик клика на кнопку переключения темы
    themeToggleBtn.addEventListener('click', function() {
        if (htmlElement.getAttribute('data-theme') === 'light') {
            htmlElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            htmlElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
            themeToggleLightIcon.classList.add('hidden');
            themeToggleDarkIcon.classList.remove('hidden');
        }
        
        // Добавляем анимацию перехода
        document.body.classList.add('theme-transition');
        setTimeout(() => {
            document.body.classList.remove('theme-transition');
        }, 1000);
    });
}

// Инициализация мобильного меню
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (!mobileMenuBtn || !mobileMenu) return;
    
    mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('show');
        
        // Анимация кнопки меню
        this.classList.toggle('is-active');
        
        // Если меню открыто, запретить скролл страницы
        if (!mobileMenu.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });
    
    // Закрытие меню при клике вне его
    document.addEventListener('click', function(e) {
        if (!mobileMenu.classList.contains('hidden') && 
            !mobileMenu.contains(e.target) && 
            !mobileMenuBtn.contains(e.target)) {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('show');
            mobileMenuBtn.classList.remove('is-active');
            document.body.style.overflow = '';
        }
    });
}

// Плавный скролл
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const target = document.querySelector(this.getAttribute('href'));
            if (!target) return;
            
            window.scrollTo({
                top: target.offsetTop,
                behavior: 'smooth'
            });
        });
    });
}

// Анимации при скролле
function initScrollAnimations() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    
    if (elements.length === 0) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    elements.forEach(element => {
        observer.observe(element);
    });
    
    // Добавление анимации к карточкам продуктов при прокрутке
    const productCards = document.querySelectorAll('.product-card');
    if (productCards.length > 0) {
        const productObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('animate-slide-up');
                    }, index * 100); // Добавляет задержку для эффекта каскада
                    productObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        productCards.forEach(card => {
            productObserver.observe(card);
        });
    }
}

// Подсветка активного пункта меню
function highlightActiveMenuItem() {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.nav-menu a, #mobile-menu a');
    
    menuItems.forEach(item => {
        const itemPath = item.getAttribute('href');
        if (itemPath === currentPath || (currentPath.includes(itemPath) && itemPath !== '/')) {
            item.classList.add('active');
        }
    });
} 