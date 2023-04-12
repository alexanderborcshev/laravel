import Velocity from 'velocity-animate';

export function flyToFavorite(item) {
    const target = document.querySelector('#h-favorite');
    let btnFly;
    let btnFlyStartX;
    let btnFlyStartY;
    let btnFlyFinalX;
    let btnFlyFinalY;
    let btnTemp;

    if (!item.classList.contains('active')) {
        btnTemp = document.querySelector('.check-favorites-fly');

        if (typeof (btnTemp) !== 'undefined' && btnTemp !== null) {
            btnTemp.remove();
        }

        btnFlyFinalY = target.getBoundingClientRect().top + window.pageYOffest;
        btnFlyFinalX = target.getBoundingClientRect().left;

        btnFly = document.createElement('div');
        btnFly.classList.add('check-favorites-fly');

        document.querySelector('body').appendChild(btnFly);

        btnFlyStartX = item.getBoundingClientRect().left;
        btnFlyStartY = item.getBoundingClientRect().top + window.pageYOffest;
        btnFly.style.top = `${btnFlyStartY}px`;
        btnFly.style.left = `${btnFlyStartX}px`;

        Velocity(document.querySelector('.check-favorites-fly'), 'finish');
        Velocity(document.querySelector('.check-favorites-fly'), { top: btnFlyFinalY, left: btnFlyFinalX }, { duration: 750 });

        setTimeout(() => {
            btnFly.classList.add('done');

            setTimeout(() => {
                if (typeof (btnFly) !== 'undefined' && btnFly !== null) {
                    btnFly.remove();
                }
            }, 800);
        }, 750);
    }
}

export function scrollTo(target, margin, isScroll = true) {
    if ((isScroll && document.querySelector(target)) || target === 'up' || target === 'down') {
        const mr = margin || 12;
        let $top;

        if (target === 'up') {
            $top = 0;
        } else if (target === 'down') {
            $top = document.body.scrollHeight;
        } else {
            const box = document.querySelector(target).getBoundingClientRect();
            $top = box.top + window.scrollY - mr;
        }

        Velocity(document.querySelector('body'), 'finish');
        Velocity(document.querySelector('body'), 'scroll', { duration: 450, offset: $top });
    }
}

// необходимо блокам-родителям задавать positon: relative (для подсчета offsetTop)
export function scrollToModal(target, margin, targetWrap, isScroll = true) {
    if ((isScroll && document.querySelector(target)) || target === 'up') {
        const mr = margin || 24;
        let $top = 0;
        let tempElem = 'test';

        const tr = document.querySelector(target);
        let pr = tr.parentNode;

        while (tempElem !== targetWrap && tempElem !== 'app') {
            $top += parseFloat(pr.offsetTop);
            pr = pr.parentNode;
            tempElem = pr.id;
        }

        document.querySelector(`#${targetWrap}`).scrollTo({ top: $top - mr, left: 0, behavior: 'smooth' });
    }
}

export function flyToWork(item) {
    const target = document.querySelector('.flyToWork');
    let btnFly;
    let btnFlyStartX;
    let btnFlyStartY;
    let btnFlyFinalX;
    let btnFlyFinalY;
    let btnTemp;

    if (!item.classList.contains('active')) {
        btnTemp = document.querySelector('.coupon-fly');

        if (typeof (btnTemp) !== 'undefined' && btnTemp !== null) {
            btnTemp.remove();
        }

        btnFlyFinalY = target.getBoundingClientRect().top + window.pageYOffest;
        btnFlyFinalX = target.getBoundingClientRect().left;

        btnFly = document.createElement('div');
        btnFly.classList.add('coupon', '--ghost', 'coupon-fly');
        btnFly.innerHTML = '<div class="coupon__wrap"><div class="coupon__img"></div> <div class="coupon__content"><div class="coupon__favorite"><span class="check-favorites"></span></div><div class="coupon__stat"><span class="elem --views"><span class="i i-eye"></span><span class="t"></span></span><span class="elem --buy"><span class="i i-cart"></span><span class="t"></span></span><span class="elem --comment"><span class="i i-comment"></span><span class="t"></span></span></div><div class="coupon__name">&nbsp;</div><div class="coupon__company">&nbsp;</div><div class="w"><div class="coupon__economy"><div class="t">Экономия</div><div class="p"></div></div><div class="coupon__info">Средний чек<span class="n" >%</span></div></div></div></div>';

        document.querySelector('body').appendChild(btnFly);

        btnFlyStartX = item.getBoundingClientRect().left;
        btnFlyStartY = item.getBoundingClientRect().top + window.pageYOffest;
        btnFly.style.top = `${btnFlyStartY}px`;
        btnFly.style.left = `${btnFlyStartX}px`;

        Velocity(document.querySelector('.coupon-fly'), 'finish');
        Velocity(document.querySelector('.coupon-fly'), {
            top: btnFlyFinalY, left: btnFlyFinalX + 40, width: 0, height: 0, opacity: 0,
        }, { duration: 750 });
        target.style.color = '#fff';
        setTimeout(() => {
            btnFly.classList.add('done');
            target.style.color = '';
            setTimeout(() => {
                if (typeof (btnFly) !== 'undefined' && btnFly !== null) {
                    btnFly.remove();
                }
            }, 800);
        }, 750);
    }
}
