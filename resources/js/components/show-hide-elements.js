/*
    para mostrar/ocultar elementos
*/

export function show_hide_list(input_list, state) {
    const promises = [];

    input_list.forEach((input_e) => {
        const p = new Promise((resolve) => {
            if (state === 'none') {
                if (window.getComputedStyle(input_e).display === 'none') {
                    resolve();
                    return;
                }

                input_e.classList.remove('anim-appear');
                input_e.classList.add('anim-disappear');

                input_e.addEventListener('animationend', () => {
                    if (input_e.classList.contains('anim-disappear')) {
                        input_e.style.display = 'none';
                        input_e.classList.remove('anim-disappear');
                    }
                    resolve();
                }, { once: true });
            } else {
                input_e.style.display = state;
                input_e.classList.remove('anim-disappear');
                input_e.classList.add('anim-appear');
                resolve();
            }
        });
        promises.push(p);
    });

    return Promise.all(promises);
}
