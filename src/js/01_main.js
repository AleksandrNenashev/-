window.addEventListener('DOMContentLoaded', () => {
    fix100vh();
    window.addEventListener('resize', () => {
        fix100vh();
        getScrollBarSize()
    })

    getScrollBarSize()

})

function fix100vh() {
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}
