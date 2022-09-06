import "bootstrap";

import { gsap } from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);
gsap.registerPlugin(ScrollToPlugin);

const portfolio = (function () {
  function portfolioScrollTo() {
    let portfolioSection = document.querySelector("#portfolio"),
      unlocked = document.querySelector(".unlocked");

    if (portfolioSection.contains(unlocked)) {
      setTimeout(function () {
        gsap.to(window, {
          scrollTo: portfolioSection,
          duration: 0.65,
          ease: "power3.out",
        });
      }, "1000");
    }
  }

  return {
    portfolioScrollTo: portfolioScrollTo,
  };
})();
portfolio.portfolioScrollTo();
