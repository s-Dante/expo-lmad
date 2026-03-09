/*
    para mover elementos con animación
*/

export function move_list(input_list, state) {
    const promises = [];

    input_list.forEach((input_e) => {
        const p = new Promise((resolve) => {
            if (window.getComputedStyle(input_e).display === state) {
                resolve();
                return;
            }

            input_e.classList.remove('anim-appear');
            input_e.classList.add('anim-disappear');

            input_e.addEventListener('animationend', () => {
                input_e.style.display = state;
                input_e.classList.remove('anim-disappear');
                input_e.classList.add('anim-appear');
                resolve();
            }, { once: true });
        });
        promises.push(p);
    });

    return Promise.all(promises);
}