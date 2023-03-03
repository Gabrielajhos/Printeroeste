const slider = document.querySelector('.slider');
var sliderSection = document.querySelectorAll('.slider_section');

var sliderSectionFirst = document.querySelectorAll('.slider_section')[0];
var sliderSectionLast = sliderSection[sliderSection.length -1];
var sliderSectionSecond = document.querySelector('.img2');

var siguiente = document.querySelector('.btn-right');
var anterior= document.querySelector('.btn-left');

//slider.insertAdjacentElement("afterbegin", sliderSectionLast);

function next() {
    sliderSectionFirst.insertAdjacentElement('beforebegin', sliderSectionSecond);
}


siguiente.addEventListener('click', function () {
next();

})

function back() {
    sliderSectionSecond.insertAdjacentElement('beforebegin', sliderSectionFirst)
}

anterior.addEventListener('click', function () {
    back();
} )
