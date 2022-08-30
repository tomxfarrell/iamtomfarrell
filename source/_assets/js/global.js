// Define our viewportWidth variable
window.viewportWidth;
window.mobileSize;
window.desktopSize;

// Set/update the viewportWidth value
var setViewportWidth = function () {
  viewportWidth = window.innerWidth || document.documentElement.clientWidth;
};

// Log the viewport width into the console
var logWidth = function () {
  if (viewportWidth > 991) {
    desktopSize = true;
    mobileSize = false;
    // console.log("desktop:" + desktopSize);
    // console.log("mobile:" + mobileSize);
  } else {
    desktopSize = false;
    mobileSize = true;

    // console.log("desktop:" + desktopSize);
    // console.log("mobile:" + mobileSize);
  }
};

// Set our initial width and log it
setViewportWidth();
logWidth();

// On resize events, recalculate and log
window.addEventListener(
  "resize",
  function () {
    setViewportWidth();
    logWidth();
  },
  false
);
