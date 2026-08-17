export function cabinetMenuOverflow() {
    const nav = document.querySelector('.hbox__submenu .v_s_c__flex');
    if (!nav) return;

    const moreWrapper = nav.querySelector('.v_s_c__more');
    if (!moreWrapper) return;

    const moreBtn  = moreWrapper.querySelector('.v_s_c__more-btn');
    const dropdown = moreWrapper.querySelector('.v_s_c__more-dropdown');
    const allItems = [...nav.querySelectorAll('.v_s_c__item')];

    let moreBtnWidth = 0;

    function getMorBtnWidth() {
        if (moreBtnWidth) return moreBtnWidth;
        moreWrapper.style.display    = 'flex';
        moreWrapper.style.visibility = 'hidden';
        moreBtnWidth = moreWrapper.offsetWidth || 44;
        moreWrapper.style.display    = 'none';
        moreWrapper.style.visibility = '';
        return moreBtnWidth;
    }

    function update() {
        // Пропускаем hamburger-режим (nav скрыт)
        if (!nav.offsetWidth) return;

        // Сброс: показываем все пункты
        allItems.forEach(item => { item.style.display = ''; });
        moreWrapper.style.display = 'none';
        dropdown.classList.remove('open');
        dropdown.innerHTML = '';

        // getBoundingClientRect — работает независимо от offsetParent
        const navRight    = nav.getBoundingClientRect().right;
        const lastItem    = allItems[allItems.length - 1];
        const lastItemRight = lastItem ? lastItem.getBoundingClientRect().right : 0;

        // Все пункты помещаются — кнопка не нужна
        if (lastItemRight <= navRight + 1) return;

        const btnWidth      = getMorBtnWidth();
        const availableRight = navRight - btnWidth;

        let cutoff = allItems.length;
        for (let i = 0; i < allItems.length; i++) {
            if (allItems[i].getBoundingClientRect().right > availableRight + 1) {
                cutoff = i;
                break;
            }
        }

        for (let i = cutoff; i < allItems.length; i++) {
            allItems[i].style.display = 'none';
            const clone = allItems[i].cloneNode(true);
            clone.style.display = '';
            dropdown.appendChild(clone);
        }

        moreWrapper.style.display = 'flex';
    }

    update();

    let timer;
    window.addEventListener('resize', () => {
        clearTimeout(timer);
        timer = setTimeout(update, 80);
    });

    moreBtn.addEventListener('click', e => {
        e.stopPropagation();
        dropdown.classList.toggle('open');
    });

    document.addEventListener('click', () => {
        dropdown.classList.remove('open');
    });
}
