window.onscroll = function showHeader() {
    var headtb = document.querySelector('.thead');

    if(window.pageYOffset > 167) {
        headtb.classList.add('thead_fixed');
    } else {
        headtb.classList.remove('thead_fixed');
    }
}