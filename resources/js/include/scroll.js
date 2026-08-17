export function scroll() {
// Функция, которая возвращает элемент по ID
    const button = document.getElementById('scrollTopBtn');
    const absol = document.querySelector('.connection_absol');

// Обработчик события прокрутки окна браузера
    window.addEventListener('scroll', function() {
        // Если страница была прокручена хотя бы немного вниз,
        const isVisible = document.body.scrollTop > 20 || document.documentElement.scrollTop > 20;

        button.classList.toggle("show", isVisible);       // показываем/скрываем кнопку
        // и на столько же поднимаем панель контактов, чтобы кнопка «наверх»
        // не накладывалась на её нижнюю кнопку (как в generalre)
        absol?.classList.toggle("scroll-btn-offset", isVisible);
    });
// Когда клюкают на кнопку, плавно поднимаемся
    button.onclick = function(){
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
}
