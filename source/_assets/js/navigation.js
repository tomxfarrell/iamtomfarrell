import "bootstrap";

import { gsap } from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);
gsap.registerPlugin(ScrollToPlugin);

const navigation = (function () {
  function pinNav() {
    let nav = document.querySelector(".navigation");

    let tl = gsap.timeline({
      scrollTrigger: {
        trigger: nav,
        start: "top top",
        end: "+=100%",
        pin: true,
        scrub: false,
        markers: false,
        id: "nav",
        toggleActions: "play none reverse none",
      },
    });
  }

  function scrollTo() {
    let navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach(function (navLink) {
      navLink.addEventListener("click", function (e) {
        e.preventDefault();
        gsap.to(window, {
          scrollTo: navLink.hash,
          duration: 0.65,
          ease: "power3.out",
        });
      });
    });
  }

  function toTop() {
    let topLink = document.getElementById("btn-top");

    topLink.addEventListener("click", function (e) {
      e.preventDefault();
      gsap.to(window, {
        scrollTo: "#top",
        duration: 0.65,
        ease: "power3.out",
      });
    });
  }

  return {
    pinNav: pinNav,
    scrollTo: scrollTo,
    toTop: toTop,
  };
})();
navigation.pinNav();
navigation.scrollTo();
navigation.toTop();
