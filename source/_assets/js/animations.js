import "bootstrap";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { DrawSVGPlugin } from "gsap/DrawSVGPlugin";
gsap.registerPlugin(ScrollTrigger);
gsap.registerPlugin(DrawSVGPlugin);

const animations = (function () {
  function bodyLoad() {
    let theBody = document.querySelector("body");
    let thebodytl = gsap.timeline();
    thebodytl.to(theBody, {
      duration: 2,
      opacity: 1,
    });
  }

  function logo() {
    let logotl = gsap.timeline();
    logotl.set(".nav-item", {
      opacity: 0,
      scale: 0.5,
    });
    logotl.from("#logo-t", {
      delay: 1,
      duration: 1,
      opacity: 0,
    });
    logotl.from("#logo-f", {
      duration: 1,
      opacity: 0,
    });

    logotl.from("#logo-line", {
      duration: 3,
      drawSVG: "0%",
    });

    if (desktopSize) {
      logotl.to(
        ".nav-item",
        {
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

    gsap.set(".outerline", { drawSVG: "0", autoAlpha: 1 });

    let logoTF = document.querySelector("#logo-tf-svg");

    let action = gsap.timeline({ paused: true }).to(".outerline", {
      drawSVG: "100%",
      duration: 1,
      ease: "power1.inOut",
    });

    logoTF.addEventListener("mouseenter", () => {
      action.timeScale(1).play();
    });

    logoTF.addEventListener("mouseleave", () => {
      action.timeScale(3).reverse();
    });
  }

  function hero() {
    let hero = document.getElementById("hero"),
      sun = document.querySelector(".hero-sun"),
      nightSky = document.querySelector(".hero-night-mask"),
      moon = document.querySelector(".hero-moon"),
      stars = document.querySelector(".hero-stars"),
      heroDayMountainsBackground = document.querySelector(
        ".hero-day-mountains-background"
      ),
      heroNightMountainsBackground = document.querySelector(
        ".hero-night-mountains-background"
      ),
      heroDayTrees = document.querySelector(".hero-day-trees"),
      heroNightTrees = document.querySelector(".hero-night-trees"),
      heroDayMountainsMidground = document.querySelector(
        ".hero-day-mountains-midground"
      ),
      heroNightMountainsMidground = document.querySelector(
        ".hero-night-mountains-midground"
      ),
      heroDayMountainsForeground = document.querySelector(
        ".hero-day-mountains-foreground"
      ),
      heroNightMountainsForeground = document.querySelector(
        ".hero-night-mountains-foreground"
      ),
      hgroup = document.querySelector(".hgroup"),
      aboutSection = document.querySelector("#about"),
      aboutSectionContainer = document.querySelector(".about-container");

    let mm = gsap.matchMedia();

    // add a media query. When it matches, the associated function will run

    mm.add("(min-width: 1031px)", () => {
      gsap.set(moon, {
        opacity: 0,
      });

      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: hero,
          start: "top top",
          end: "+=100%",
          pin: true,
          scrub: 2,
          markers: false,
          // invalidateOnRefresh: true,
          id: "hero",
          toggleActions: "play none reverse none",
        },
      });
      tl.to(
        sun,
        {
          yPercent: 75,
          duration: 1,
        },
        "<"
      );
      tl.set(sun, {
        opacity: 0,
      });
      tl.to(
        nightSky,
        {
          opacity: 1,
          duration: 1,
        },
        "<"
      );
      tl.to(
        heroNightMountainsBackground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroDayMountainsBackground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroDayMountainsMidground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroNightMountainsMidground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroNightMountainsForeground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(heroDayMountainsForeground, {
        opacity: 0,
        duration: 0.3,
      });
      tl.to(
        heroNightTrees,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.set(heroDayTrees, {
        opacity: 0,
      });
      tl.to(stars, {
        opacity: 1,
        duration: 1,
      });
      tl.to(moon, {
        yPercent: 74,
        opacity: 0.7,
        duration: 2,
      });
      tl.to(
        hgroup,
        {
          yPercent: 30,
          opacity: 0,
          duration: 4,
        },
        "<"
      );
      tl.to(
        heroNightMountainsForeground,
        {
          yPercent: -30,
          duration: 4,
        },
        "<"
      );
      tl.to(
        heroNightTrees,
        {
          yPercent: -40,
          duration: 4,
        },
        "<"
      );
      tl.to(
        aboutSection,
        {
          yPercent: -7,
          duration: 1,
        },
        "-=4"
      );
      tl.to(aboutSectionContainer, {
        opacity: 1,
        duration: 0.3,
      });
    });

    mm.add("(min-width: 501px) and (max-width: 1030px)", () => {
      gsap.set(moon, {
        opacity: 0,
      });

      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: hero,
          start: "top top",
          end: "+=100%",
          pin: true,
          scrub: 2,
          markers: false,
          // invalidateOnRefresh: true,
          id: "hero",
          toggleActions: "play none reverse none",
        },
      });
      tl.to(
        sun,
        {
          yPercent: 55,
          duration: 1,
        },
        "<"
      );
      tl.set(sun, {
        opacity: 0,
      });
      tl.to(
        nightSky,
        {
          opacity: 1,
          duration: 1,
        },
        "<"
      );
      tl.to(
        heroNightMountainsBackground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroDayMountainsBackground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroDayMountainsMidground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroNightMountainsMidground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroNightMountainsForeground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(heroDayMountainsForeground, {
        opacity: 0,
        duration: 0.3,
      });
      tl.to(
        heroNightTrees,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.set(heroDayTrees, {
        opacity: 0,
      });
      tl.to(stars, {
        opacity: 1,
        duration: 1,
      });
      tl.to(moon, {
        yPercent: 73,
        opacity: 0.7,
        duration: 2,
      });
      tl.to(
        hgroup,
        {
          yPercent: 30,
          opacity: 0,
          duration: 4,
        },
        "<"
      );
      tl.to(
        heroNightMountainsForeground,
        {
          yPercent: -30,
          duration: 4,
        },
        "<"
      );
      tl.to(
        heroNightTrees,
        {
          yPercent: -25,
          duration: 4,
        },
        "<"
      );
      tl.to(
        aboutSection,
        {
          yPercent: -7,
          duration: 1,
        },
        "-=4"
      );
      tl.to(aboutSectionContainer, {
        opacity: 1,
        duration: 0.3,
      });
    });

    mm.add("(max-width: 500px)", () => {
      gsap.set(moon, {
        opacity: 0,
      });

      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: hero,
          start: () => "top top",
          end: "+=100%",
          pin: true,
          scrub: 2,
          markers: false,
          invalidateOnRefresh: true,
          id: "hero",
          toggleActions: "play none reverse none",
        },
      });
      tl.to(
        sun,
        {
          yPercent: 55,
          duration: 1,
        },
        "<"
      );
      tl.set(sun, {
        opacity: 0,
      });
      tl.to(
        nightSky,
        {
          opacity: 1,
          duration: 1,
        },
        "<"
      );
      tl.to(
        heroNightMountainsBackground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroDayMountainsBackground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroDayMountainsMidground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroNightMountainsMidground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(
        heroNightMountainsForeground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.to(heroDayMountainsForeground, {
        opacity: 0,
        duration: 0.3,
      });
      tl.to(
        heroNightTrees,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      );
      tl.set(heroDayTrees, {
        opacity: 0,
      });
      tl.to(
        stars,
        {
          opacity: 1,
          duration: 1,
        },
        "<"
      );

      tl.to(hgroup, {
        yPercent: 55,
        opacity: 0,
        duration: 1,
      });
      tl.to(moon, {
        yPercent: 73,
        opacity: 0.7,
        duration: 2,
      });
      tl.to(
        heroNightMountainsForeground,
        {
          yPercent: -30,
          duration: 4,
        },
        "<"
      );
      tl.to(
        heroNightTrees,
        {
          yPercent: -25,
          duration: 4,
        },
        "<"
      );
      tl.to(
        aboutSection,
        {
          yPercent: -4,
          duration: 1,
        },
        "-=4"
      );
      tl.to(aboutSectionContainer, {
        opacity: 1,
        duration: 0.3,
      });
    });
  }

  return {
    bodyLoad: bodyLoad,
    logo: logo,
    hero: hero,
  };
})();

setTimeout(function () {
  animations.hero();
  animations.bodyLoad();
  animations.logo();
}, "1000");
