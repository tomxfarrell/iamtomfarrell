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
    logotl.from(
      ".navbar-toggler",
      {
        duration: 1,
        opacity: 0,
      },
      "<"
    );
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

      gsap.to(hgroup, {
        delay: 3,
        opacity: 1,
        duration: 2,
      });

      let tl = gsap
        .timeline({
          scrollTrigger: {
            trigger: hero,
            start: "top top",
            end: "+=100%",
            pin: true,
            scrub: 2,
            markers: false,
            id: "hero",
            toggleActions: "play none reverse none",
          },
        })
        .to(
          sun,
          {
            yPercent: 75,
            duration: 1,
          },
          "<"
        )
        .set(sun, {
          opacity: 0,
        })
        .to(
          nightSky,
          {
            opacity: 1,
            duration: 1,
          },
          "<"
        )
        .to(
          heroNightMountainsBackground,
          {
            opacity: 1,
            duration: 0.3,
          },
          "<"
        )
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
        .to(heroDayMountainsForeground, {
          opacity: 0,
          duration: 0.3,
        })

        .to(
          heroNightTrees,
          {
            opacity: 1,
            duration: 0.3,
          },
          "<"
        )
        .set(heroDayTrees, {
          opacity: 0,
        })

        .to(stars, {
          opacity: 1,
          duration: 1,
        })
        .to(moon, {
          yPercent: 74,
          opacity: 0.7,
          duration: 2,
        })
        .to(
          hgroup,
          {
            yPercent: 30,
            opacity: 0,
            duration: 4,
          },
          "<"
        )
        .to(
          heroNightMountainsForeground,
          {
            yPercent: -30,
            duration: 4,
          },
          "<"
        )
        .to(
          heroNightTrees,
          {
            yPercent: -40,
            duration: 4,
          },
          "<"
        )
        .to(
          aboutSection,
          {
            yPercent: -7,
            duration: 1,
          },
          "-=4"
        )
        .to(aboutSectionContainer, {
          opacity: 1,
          duration: 0.3,
        });
    });

    mm.add("(max-width: 1030px)", () => {
      gsap.set(moon, {
        opacity: 0,
      });

      gsap.to(hgroup, {
        delay: 3,
        opacity: 1,
        duration: 2,
      });

      let tl = gsap
        .timeline({
          scrollTrigger: {
            trigger: hero,
            start: "top top",
            end: "+=100%",
            pin: true,
            scrub: 2,
            markers: false,
            id: "hero",
            toggleActions: "play none reverse none",
          },
        })
        .to(
          sun,
          {
            yPercent: 55,
            duration: 1,
          },
          "<"
        )
        .set(sun, {
          opacity: 0,
        })
        .to(
          nightSky,
          {
            opacity: 1,
            duration: 1,
          },
          "<"
        )
        .to(
          heroNightMountainsBackground,
          {
            opacity: 1,
            duration: 0.3,
          },
          "<"
        )
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
        .to(heroDayMountainsForeground, {
          opacity: 0,
          duration: 0.3,
        })

        .to(
          heroNightTrees,
          {
            opacity: 1,
            duration: 0.3,
          },
          "<"
        )
        .set(heroDayTrees, {
          opacity: 0,
        })

        .to(stars, {
          opacity: 1,
          duration: 1,
        })
        .to(moon, {
          yPercent: 73,
          opacity: 0.7,
          duration: 2,
        })
        .to(
          hgroup,
          {
            yPercent: 30,
            opacity: 0,
            duration: 4,
          },
          "<"
        )
        .to(
          heroNightMountainsForeground,
          {
            yPercent: -30,
            duration: 4,
          },
          "<"
        )
        .to(
          heroNightTrees,
          {
            yPercent: -25,
            duration: 4,
          },
          "<"
        )
        .to(
          aboutSection,
          {
            yPercent: -7,
            duration: 1,
          },
          "-=4"
        )
        .to(aboutSectionContainer, {
          opacity: 1,
          duration: 0.3,
        });
    });

    mm.add("(max-width: 500px)", () => {
      gsap.set(moon, {
        opacity: 0,
      });

      gsap.to(hgroup, {
        delay: 3,
        opacity: 1,
        duration: 2,
      });

      let tl = gsap
        .timeline({
          scrollTrigger: {
            trigger: hero,
            start: "top top",
            end: "+=100%",
            pin: true,
            scrub: 2,
            markers: false,
            id: "hero",
            toggleActions: "play none reverse none",
          },
        })
        .to(
          sun,
          {
            yPercent: 55,
            duration: 1,
          },
          "<"
        )
        .set(sun, {
          opacity: 0,
        })
        .to(
          nightSky,
          {
            opacity: 1,
            duration: 1,
          },
          "<"
        )
        .to(
          heroNightMountainsBackground,
          {
            opacity: 1,
            duration: 0.3,
          },
          "<"
        )
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
        .to(heroDayMountainsForeground, {
          opacity: 0,
          duration: 0.3,
        })

        .to(
          heroNightTrees,
          {
            opacity: 1,
            duration: 0.3,
          },
          "<"
        )
        .set(heroDayTrees, {
          opacity: 0,
        })

        .to(stars, {
          opacity: 1,
          duration: 1,
        })
        .to(moon, {
          yPercent: 73,
          opacity: 0.7,
          duration: 2,
        })
        .to(
          hgroup,
          {
            yPercent: 30,
            opacity: 0,
            duration: 4,
          },
          "<"
        )
        .to(
          heroNightMountainsForeground,
          {
            yPercent: -30,
            duration: 4,
          },
          "<"
        )
        .to(
          heroNightTrees,
          {
            yPercent: -25,
            duration: 4,
          },
          "<"
        )
        .to(
          aboutSection,
          {
            yPercent: -4,
            duration: 1,
          },
          "-=4"
        )
        .to(aboutSectionContainer, {
          opacity: 1,
          duration: 0.3,
        });
    });

    ScrollTrigger.refresh();
  }

  return {
    // scrollSmoother: scrollSmoother,
    bodyLoad: bodyLoad,
    logo: logo,
    hero: hero,
  };
})();
animations.bodyLoad();
animations.logo();
animations.hero();
