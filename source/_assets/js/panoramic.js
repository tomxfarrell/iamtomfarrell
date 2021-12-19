import { gsap } from "gsap/dist/gsap";
import { ScrollTrigger } from "gsap/dist/ScrollTrigger";
import { ScrollToPlugin } from "gsap/dist/ScrollToPlugin";

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

function panoramic() {

  let dataDirection;

  gsap.utils.toArray('.panoramic-block img').forEach((el, i) => {

      dataDirection = el.closest('.panoramic-block').getAttribute('data-direction');

      gsap.to(el, {
          scrollTrigger: {
              trigger: el,
              start: "top top",
              end: "bottom top",
              scrub: 2,
              pin: true,
          },
          xPercent: ((dataDirection === 'left') ? '-35' : '35'),
      });
  });

}

panoramic();