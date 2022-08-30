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

  function navScrollTo() {
    let navbarToggler = document.querySelector(".navbar-toggler"),
      hamburger = document.querySelector("#hamburger"),
      theBody = document.querySelector("body"),
      navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach(function (navLink) {
      navLink.addEventListener("click", function (e) {
        e.preventDefault();
        if (mobileSize) {
          console.log("mobile");
          toggleMenu();
          gsap.to(window, {
            scrollTo: navLink.hash,
            duration: 0.65,
            ease: "power3.out",
          });
        } else {
          gsap.to(window, {
            scrollTo: navLink.hash,
            duration: 0.65,
            ease: "power3.out",
          });
          console.log("desktop");
        }
      });
    });

    navbarToggler.addEventListener("click", function () {
      toggleHamburger();

      if (theBody.classList.contains("freeze")) {
        theBody.classList.remove("freeze");
      } else {
        theBody.classList.add("freeze");

        let navfadeintl = gsap.timeline();
        gsap.set(".nav-item", { opacity: 0, scale: 0 });
        navfadeintl.to(
          ".nav-item",
          {
            delay: 0.5,
            duration: 0.3,
            opacity: 1,
            scale: 1,

            stagger: {
              each: 0.3,
            },
          },
          "<"
        );
      }
    });

    function toggleMenu() {
      navbarToggler.click();
    }

    function toggleHamburger() {
      if (navbarToggler.classList.contains("collapsed")) {
        hamburger.classList.remove("is-active");
      } else {
        hamburger.classList.add("is-active");
      }
    }

    function closeMenuOnResize() {
      window.addEventListener(
        "resize",
        function () {
          if (theBody.classList.contains("freeze")) {
            toggleMenu();
            theBody.classList.remove("freeze");
          }
        },
        false
      );
    }
    closeMenuOnResize();
  }

  return {
    navScrollTo: navScrollTo,
    pinNav: pinNav,
    toTop: toTop,
  };
})();
navigation.navScrollTo();
navigation.pinNav();
navigation.toTop();
