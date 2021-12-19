import { gsap } from "gsap/dist/gsap";
import { ScrollTrigger } from "gsap/dist/ScrollTrigger";
import { ScrollToPlugin } from "gsap/dist/ScrollToPlugin";

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

    
    gsap.utils.toArray(".section-parallax .parallax-content").forEach((section, i) => {
          const heightDiff = section.offsetHeight - section.parentElement.offsetHeight;

      gsap.fromTo(section,{ 
        y: -heightDiff
      }, {
        scrollTrigger: {
          trigger: section.parentElement,
          scrub: true
        },
        y: 0,
        ease: "none"
      });
    });

    require('./panoramic');
