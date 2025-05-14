/**
 * Скрипт для управления темой сайта
 */

(function() {
    // DOM элементы
    const themeToggle = document.getElementById('theme-toggle');
    const htmlRoot = document.documentElement;
    
    // Эффект звездочек на фоне
    const starsEffect = {
        init: function() {
            this.appendStars();
            this.animateStars();
        },
        
        appendStars: function() {
            const starsContainer = document.createElement('div');
            starsContainer.className = 'stars-container';
            starsContainer.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 0;
                overflow: hidden;
            `;
            
            // Создаем 50 звездочек
            for (let i = 0; i < 50; i++) {
                const star = document.createElement('div');
                const size = Math.random() * 4 + 1; // размер от 1 до 5px
                const x = Math.random() * 100; // положение по X (в процентах)
                const y = Math.random() * 100; // положение по Y (в процентах)
                const opacity = Math.random() * 0.5 + 0.1; // прозрачность от 0.1 до 0.6
                
                star.className = 'star';
                star.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background-color: var(--color-primary);
                    left: ${x}%;
                    top: ${y}%;
                    opacity: ${opacity};
                    border-radius: 50%;
                    transition: opacity 0.5s ease;
                `;
                
                starsContainer.appendChild(star);
            }
            
            document.body.appendChild(starsContainer);
        },
        
        animateStars: function() {
            const stars = document.querySelectorAll('.star');
            
            // Анимируем звездочки
            stars.forEach((star) => {
                setInterval(() => {
                    const currentOpacity = parseFloat(star.style.opacity);
                    const newOpacity = Math.random() * 0.5 + 0.1;
                    star.style.opacity = newOpacity;
                }, Math.random() * 5000 + 2000); // интервал от 2 до 7 секунд
            });
        }
    };
    
    // Управление темой
    const themeManager = {
        init: function() {
            this.setInitialTheme();
            this.setupEventListeners();
        },
        
        setInitialTheme: function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            this.applyTheme(savedTheme);
        },
        
        setupEventListeners: function() {
            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const currentTheme = htmlRoot.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    this.applyTheme(newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            }
        },
        
        applyTheme: function(theme) {
            if (theme === 'dark') {
                htmlRoot.setAttribute('data-theme', 'dark');
                document.body.classList.add('dark');
                if (themeToggle) {
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                }
            } else {
                htmlRoot.setAttribute('data-theme', 'light');
                document.body.classList.remove('dark');
                if (themeToggle) {
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                }
            }
        }
    };
    
    // Инициализация
    document.addEventListener('DOMContentLoaded', function() {
        themeManager.init();
        starsEffect.init();
    });
})(); 