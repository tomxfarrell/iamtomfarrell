const setHeight = () => {
  document.getElementById("hero").style.minHeight = window.innerHeight + "px";
};

let test123;
// define mobile screen size:

let deviceWidth = window.matchMedia("(max-width: 415px)");

if (deviceWidth.matches) {
  window.addEventListener("resize", setHeight);

  setHeight();
}
