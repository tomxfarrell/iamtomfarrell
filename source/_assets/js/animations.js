import "bootstrap";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";
import { DrawSVGPlugin } from "gsap/DrawSVGPlugin";
gsap.registerPlugin(ScrollTrigger, ScrollSmoother);
gsap.registerPlugin(DrawSVGPlugin);

const animations = (function () {
  // function scrollSmoother() {
  //   const smoother = ScrollSmoother.create({
  //     content: "#smooth-content",
  //     smooth: 1,
  //   });
  // }
  function logo() {
    let logotl = gsap.timeline();
    logotl.from("#logo-t", {
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
  }

  function hero() {
    let hero = document.getElementById("hero"),
      sun = document.querySelector(".hero-sun"),
      nightSky = document.querySelector(".hero-night-mask"),
      moon = document.querySelector(".hero-moon"),
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
      );

    gsap.set(moon, {
      opacity: 0,
    });

    let tl = gsap
      .timeline({
        scrollTrigger: {
          trigger: hero,
          start: "top top",
          end: "+=90%",
          pin: true,
          scrub: true,
          markers: false,
          id: "hero",
          toggleActions: "play none reverse none",
        },
      })
      .to(
        sun,
        {
          yPercent: 30,
          opacity: 0,
          duration: 0.3,
        },
        "<"
      )
      .to(
        nightSky,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      )
      .to(heroNightMountainsBackground, {
        opacity: 1,
        duration: 0.3,
      })
      .to(
        heroDayMountainsBackground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      )

      .to(
        heroDayMountainsMidground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      )
      .to(
        heroNightMountainsMidground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      )

      .to(
        heroNightMountainsForeground,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      )
      .to(
        heroDayMountainsForeground,
        {
          opacity: 0,
          duration: 0.3,
        },
        "<"
      )

      .to(
        heroNightTrees,
        {
          opacity: 1,
          duration: 0.3,
        },
        "<"
      )

      .to(moon, {
        yPercent: 73,
        opacity: 1,
        duration: 0.3,
      });
  }

  return {
    // scrollSmoother: scrollSmoother,
    logo: logo,
    hero: hero,
  };
})();
animations.logo();
animations.hero();
