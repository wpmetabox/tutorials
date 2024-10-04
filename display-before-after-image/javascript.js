const slider = document.getElementById('before-after-slider');
const before = document.getElementById('before-image');
const beforeImage = before.getElementsByTagName('img')[0];
const resizer = document.getElementById('resizer');

let active = false;

document.addEventListener("DOMContentLoaded", function () {
    let width = slider.offsetWidth;
    console.log(width);
    beforeImage.style.width = width + 'px';
});

window.addEventListener('resize', function () {
    let width = slider.offsetWidth;
    console.log(width);
    beforeImage.style.width = width + 'px';
})

resizer.addEventListener('mousedown', function () {
    active = true;
    resizer.classList.add('resize');
});

document.body.addEventListener('mouseup', function () {
    active = false;
    resizer.classList.remove('resize');
});

document.body.addEventListener('mouseleave', function () {
    active = false;
    resizer.classList.remove('resize');
});

document.body.addEventListener('mousemove', function (e) {
    if (!active) return;
    let x = e.pageX;
    x -= slider.getBoundingClientRect().left;
    slideIt(x);
    pauseEvent(e);
});

function slideIt(x) {
    let transform = Math.max(0, (Math.min(x, slider.offsetWidth)));
    before.style.width = transform + "px";
    resizer.style.left = transform - 0 + "px";
}

function pauseEvent(e) {
    if (e.stopPropagation) e.stopPropagation();
    if (e.preventDefault) e.preventDefault();
    e.cancelBubble = true;
    e.returnValue = false;
    return false;
}
