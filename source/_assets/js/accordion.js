import { gsap } from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(ScrollToPlugin);

const accordion = (function () {
  function scrollWhenOpen() {
    const accordionItems = document.querySelectorAll(".collapse");

    accordionItems.forEach(function (accordionItem) {
      accordionItem.addEventListener("shown.bs.collapse", function () {
        gsap.to(window, {
          scrollTo: accordionItem.parentNode.offsetTop - 10,
          duration: 0.3,
          ease: "power3.out",
        });
      });
    });
  }

  return {
    scrollWhenOpen: scrollWhenOpen,
  };
})();
accordion.scrollWhenOpen();
