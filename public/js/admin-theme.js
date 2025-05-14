/**
 * Скрипт для управления боковой панелью в админ-панели
 * Тема управляется через функцию toggleAdminTheme в <head>
 */

(function() {
    // DOM элементы для боковой панели
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    
    // Управление боковой панелью
    const SidebarManager = {
        // Переменная для отслеживания состояния сайдбара
        sidebarOpen: true,
        
        // Инициализация менеджера боковой панели
        init: function() {
            console.log('%c[SidebarManager] Инициализация', 'color: orange');
            this.setupSidebar();
            this.setupEventListeners();
        },
        
        // Настройка обработчиков событий
        setupEventListeners: function() {
            console.log('%c[SidebarManager] Настройка слушателей событий для боковой панели', 'color: orange');
            
            // Добавляем обработчики для кнопок переключения боковой панели
            if (sidebarToggle) {
                console.log('%c[SidebarManager] Настройка кнопки sidebarToggle', 'color: orange');
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    SidebarManager.toggleSidebar();
                });
            }
            
            if (mobileSidebarToggle) {
                console.log('%c[SidebarManager] Настройка кнопки mobileSidebarToggle', 'color: orange');
                mobileSidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    SidebarManager.toggleSidebar();
                });
            }
            
            // Обработчик изменения размера окна
            window.addEventListener('resize', function() {
                SidebarManager.updateSidebar();
            });
        },
        
        // Переключение состояния боковой панели
        toggleSidebar: function() {
            console.log('%c[SidebarManager] Переключение состояния боковой панели', 'color: orange');
            SidebarManager.sidebarOpen = !SidebarManager.sidebarOpen;
            SidebarManager.updateSidebar();
        },
        
        // Обновление отображения боковой панели
        updateSidebar: function() {
            if (!sidebar || !content) {
                console.log('%c[SidebarManager] Элементы sidebar или content не найдены', 'color: red');
                return;
            }
            
            if (window.innerWidth < 768) {
                if (SidebarManager.sidebarOpen) {
                    sidebar.classList.add('translate-x-0');
                    sidebar.classList.remove('-translate-x-full');
                    console.log('%c[SidebarManager] Открыта боковая панель (мобильная версия)', 'color: orange');
                } else {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    console.log('%c[SidebarManager] Закрыта боковая панель (мобильная версия)', 'color: orange');
                }
                content.classList.remove('md:pl-64');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                content.classList.add('md:pl-64');
                SidebarManager.sidebarOpen = true;
                console.log('%c[SidebarManager] Установлен десктопный режим боковой панели', 'color: orange');
            }
        },
        
        // Начальная установка состояния боковой панели
        setupSidebar: function() {
            if (!sidebar || !content) {
                console.log('%c[SidebarManager] Элементы sidebar или content не найдены при начальной установке', 'color: red');
                return;
            }
            
            // Инициализация состояния сайдбара
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                content.classList.remove('md:pl-64');
                SidebarManager.sidebarOpen = false;
                console.log('%c[SidebarManager] Начальная установка: мобильный режим (закрыто)', 'color: orange');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                content.classList.add('md:pl-64');
                SidebarManager.sidebarOpen = true;
                console.log('%c[SidebarManager] Начальная установка: десктопный режим', 'color: orange');
            }
        }
    };
    
    // Инициализация после загрузки DOM
    document.addEventListener('DOMContentLoaded', function() {
        console.log('%c[SidebarManager] DOM загружен, запуск SidebarManager', 'color: orange; font-weight: bold');
        SidebarManager.init();
    });
})(); 