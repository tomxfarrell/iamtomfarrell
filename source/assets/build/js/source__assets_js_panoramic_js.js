(self["webpackChunk"] = self["webpackChunk"] || []).push([["source__assets_js_panoramic_js"],{

/***/ "./source/_assets/js/panoramic.js":
/*!****************************************!*\
  !*** ./source/_assets/js/panoramic.js ***!
  \****************************************/
/***/ (() => {

function panoramic() {
  var dataDirection;
  gsap.utils.toArray('.panoramic-block img').forEach(function (el, i) {
    dataDirection = el.closest('.panoramic-block').getAttribute('data-direction');
    gsap.to(el, {
      scrollTrigger: {
        trigger: el,
        start: "top center",
        end: "bottom center",
        scrub: 2
      },
      xPercent: dataDirection === 'left' ? '-35' : '35'
    });
  });
}

panoramic();

/***/ })

}]);