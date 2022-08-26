@extends('_layouts.main')

@section('body')


<header>
  <div class="container">
  
      <div class="navigation">
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="/">
              @include('svgs.logo-tf')
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="#about">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#skills-and-experience">Experience</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#portfolio">Work</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#resume">Resume</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#contact">Contact</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
  </div>
</header>

<main id="top">
  <div id="smooth-content">
    <section id="hero">
      <div class="container">
        <div class="hgroup">
          <h1>
            Hi, I'm
            <strong>Thomas Farrell</strong>
          </h1>
          <h2>Front-End Developer, SVG Animator & Outdoors Enthusiast</h2>
        </div>

        <!-- <div class="row">
          <div class="col">
            <p>pic here</p>
          </div>
          <div class="col">
            <h2 class="with-line">
              About Me
            </h2>
            <p>asdf</p>
          </div>
        </div> -->
      </div>
      <img src="assets/images/hero-sun.png" alt="Sun" class="hero-sun">
      

        <img src="assets/images/hero-day-mountains-background.svg" alt="Mountains BG" class="hero-day-mountains-background">
        <img src="assets/images/hero-night-mountains-background.svg" alt="Mountains BG" class="hero-night-mountains-background">
        
        <img src="assets/images/hero-day-mountains-midground.svg" alt="Mountains" class="hero-day-mountains-midground">
        <img src="assets/images/hero-night-mountains-midground.svg" alt="Mountains" class="hero-night-mountains-midground">

        <img src="assets/images/hero-day-mountains-foreground.svg" alt="Mountains" class="hero-day-mountains-foreground">
        <img src="assets/images/hero-night-mountains-foreground.svg" alt="Mountains" class="hero-night-mountains-foreground">

        <img src="assets/images/hero-day-trees.svg" alt="Trees" class="hero-day-trees">
        <img src="assets/images/hero-night-trees.svg" alt="Trees" class="hero-night-trees">
        
      <img src="assets/images/hero-moon.png" alt="Moon" class="hero-moon">
      <img src="assets/images/hero-hiker.svg" alt="Hiker" class="hero-hiker">
      <img src="assets/images/hero-night-mask.png" alt="Night sky" class="hero-night-mask">
      
      <!-- <img src="assets/images/hero-stars.svg" alt="Stars" class="hero-stars"> -->
    </section>


  <section id="skills-and-experience">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-6 col-lg-4">
          <h2 class="with-line">Skills &<br> Experience</h2>
        </div>
        <div class="col-md-6 col-lg-8">
          <p>Front-end developer with over 2 decades of experience developing custom websites and interactive animations. Analytical and detail-oriented with a creative eye and ability to build websites from concept to completion. Experience collaborating with cross functional teams and utilizing agile methodologies.</p>
        </div>
      </div>

      <div class="row row-skills">
        <div class="col">
          <img src="assets/images/icon-fe.svg" alt="">
          <h3 class="with-line-full">Front End</h3>
          <ul>
            <li>JavaScript</li>
            <li>jQuery</li>
            <li>GSAP</li>
            <li>HTML/CSS/SASS/LESS</li>
          </ul>
        </div>
        <div class="col">
          <img src="assets/images/icon-be.svg" alt="">
          <h3 class="with-line-full">Back End</h3>
          <ul>
            <li>PHP</li>
            <li>APIs</li>
            <li>MySQL/Laravel/WP Database</li>
            <li>Firebase Database</li>
          </ul>
        </div>
        <div class="col">
          <img src="assets/images/icon-app.svg" alt="">
          <h3 class="with-line-full">Apps</h3>
          <ul>
            <li>Figma</li>
            <li>XD</li>
            <li>Photoshop</li>
            <li>Illustrator</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section id="portfolio">
    <div class="container">
      <h2 class="with-line mb-5">Portfolio</h2>
      <div class="row row-portfolio">
        <div class="col-site col-md-6 col-lg-4">
          <a href="">
            <img src="assets/images/site-graphitebio-2x.jpg" alt="Graphite Bio website">
          </a>
        </div>
        <div class="col-site col-md-6 col-lg-4">
          <a href="">
            <img src="assets/images/site-itsjustlunch-2x.jpg" alt="It's Just Lunch website">
          </a>
        </div>
        <div class="col-site col-md-6 col-lg-4">
          <a href="#">
            <img src="assets/images/site-itsjustlunch-2x.jpg" alt="It's Just Lunch website">
          </a>
        </div>
        <div class="col-site col-md-6 col-lg-4">
          <a href="#">
            <img src="assets/images/site-itsjustlunch-2x.jpg" alt="It's Just Lunch website">
          </a>
        </div>
        <div class="col-site col-md-6 col-lg-4">
          <a href="#">
            <img src="assets/images/site-itsjustlunch-2x.jpg" alt="It's Just Lunch website">
          </a>
        </div>
        <div class="col-site col-md-6 col-lg-4">
          <a href="#">
            <img src="assets/images/site-itsjustlunch-2x.jpg" alt="It's Just Lunch website">
          </a>
        </div>
      </div>
    </div>
  </section>


  <section id="resume">
    <div class="container">
      <div class="row">
        <div class="col-md-5 col-lg-3">
          <h2 class="with-line">Resume</h2>
        </div>
        <div class="col-md-7 col-lg-9">
          
          <div class="accordion" id="accordionResume">
            <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  Professional Experience
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionResume">
                <div class="accordion-body">
                  <div class="experience-box">
                    <h3 class="job-title">Senior Developer / 2016 - 2022</h3>
                    <h3 class="job-location">Real Chemistry - Florham Park, NJ</h3>
                    <ul>
                      <li>Developed responsive websites, landing pages, interactive animations and Content Management Systems (CMS) for top pharmaceutical and Fortune 500 companies</li>
                      <li>Involved in beginning phases of new website development projects to help make any technical key decisions prior to project kickoff</li>
                      <li>Collaborated with business analysts to help complete accurate and detailed website requirements</li>
                      <li>Devised technical approaches and developer plans to facilitate initial and ongoing development efforts</li>
                      <li>Created actionable JIRA tasks with accurate completion estimations to help drive projects and meet deadlines</li>
                      <li>Worked closely with designers and UX professionals to develop pixel-perfect and user-friendly website experiences</li>
                      <li>Developed accessible websites in compliance with ADA (Americans with Disabilities Act)</li>
                      <li>Ensured cross-browser and device compatibility by testing, troubleshooting and resolving any issues or bugs</li>
                      <li>Developed HTML emails for Veeva CRM as well as promotional email marketing campaigns</li>
                    </ul>
                  </div>

                  <div class="experience-box">
                    <h3 class="job-title">Lead Front-End Developer / 2012 - 2016</h3>
                    <h3 class="job-location">Sentient - Morristown, NJ</h3>
                    <ul>
                      <li>Developed responsive websites, landing pages and interactive visual aids (IVA)</li>
                      <li>Developed various proof of concept demos to help win sales pitches and gain new accounts</li>
                      <li>Developed HTML promotional emails and created standardized templates for company-wide usage</li>
                      <li>Worked closely with QA to identify and resolve bugs on various browsers and devices</li>
                    </ul>
                  </div>


                  <div class="experience-box">
                    <h3 class="job-title">Developer, Designer, SEO Specialist / 2007 - 2012</h3>
                    <h3 class="job-location">Musical Heritage Society - Ocean Township, NJ</h3>
                    <ul>
                      <li>Designed, developed and maintained multiple online membership stores</li>
                      <li>Increased online sales with SEO by drawing in targeted organic web traffic with Google, Yahoo & Bing</li>
                      <li>Designed and developed HTML emails for weekly promotions</li>
                      <li>Managed and updated email lists of over 100,000 contacts</li>
                    </ul>
                  </div>

                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Achievements & Accomplishments
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionResume">
                <div class="accordion-body">
                  <ul>
                    <li>Developed responsive websites, landing pages, interactive animations and Content Management Systems (CMS) for <strong>top pharmaceutical and Fortune 500 companies</strong></li>
                    <li>Developed and standardized email templates for company-wide usage</li>
                    <li>Increased online store sales and web traffic for various companies with Search Engine Optimization</li>
                    <li>Helped develop internal company tools to increase productivity and efficiency</li>
                    <li>Mentored junior developers, producers and account executives on agency processes and procedures</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Proficient/Specialties
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionResume">
                <div class="accordion-body">
                  <div class="row">
                    <div class="col">
                      <ul>
                        <li>SVG animations</li>
                        <li>Custom Wordpress development</li>
                        <li>Laravel & Jigsaw</li>
                        <li>APIs</li>
                        <li>Cross-browser compatibility</li>
                        <li>Web accessibility</li>
                        <li>Americans with Disabilities Act (ADA) compliance</li>
                        <li>Project management</li>
                        <li>Quality assurance</li>
                      </ul>
                    </div>
                    <div class="col">
                      <ul>
                        <li>Email marketing</li>
                        <li>Search Engine Optimization</li>
                        <li>Application management</li>
                        <li>Agile development</li>
                        <li>JIRA</li>
                        <li>Git</li>
                        <li>Veeva CRM Approved Emails</li>
                        <li>Veeva CLM</li>
                      </ul>
                    </div>
                  </div>

                  
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Certifications
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionResume">
                <div class="accordion-body">
                  <div class="experience-box">
                    <h3 class="job-title mb-3">Veeva Systems / 2022</h3>
                    <ul>
                      <li>Veeva CRM Approved Emails / Technical</li>
                      <li>Veeva CRM Approved Emails / Business</li>
                      <li>Veeva CLM (Closed-Loop Marketing) / Technical</li>
                      <li>Veeva Vault Promomats</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-5 col-lg-4">
          <h2 class="with-line mb-5">Lets Chat</h2>
          <dl class="mb-5">
            <dt>Thomas Farrell</dt>
            <dd>
              Senior Front-End Developer
            </dd>
            <dd>
              SVG Animator
            </dd>
            <dd>
              Creative Problem Solver
            </dd>
          </dl>

          <dl class="dl-inline mb-0">
            <dt><strong>Email:</strong>&nbsp;</dt>
            <dd><a href="mailto:tom@iamtomfarrell.com">tom@iamtomfarrell.com</a></dd>
          </dl>

          <p class="small mt-0">Randolph, NJ</p>

          <div class="social">
            <a href="https://www.linkedin.com/in/thomasjfarrell/">
              <img src="assets/images/icon-linkedin.svg" alt="LinkedIn">
            </a>
          </div>
        </div>
        <div class="col-md-7 col-lg-8">
          <form id="contactForm">
          
              <div class="row mb-4">
                <div class="col">
                  <label for="exampleInputEmail1" class="form-label"><span class="visually-hidden">First</span> Name*</label>
                  <input type="text" class="form-control" id="firstName" aria-describedby="firstNameHelp">
                  <div id="firstNameHelp" class="form-text">First Name</div>
                </div>
                <div class="col">
                  <label for="exampleInputEmail1" class="form-label"><span class="visually-hidden">Last Name*</span>&nbsp;</label>
                  <input type="text" class="form-control" id="lastName" aria-describedby="lastNameHelp">
                  <div id="lastNameHelp" class="form-text">Last Name</div>
                </div>
              </div>
          
            <div class="mb-4">
              <label for="email" class="form-label">Email Address*</label>
              <input type="text" class="form-control" id="email">
            </div>

            
              <div class="row mb-4">
                <div class="col-md-2">
                  <label for="phone" class="form-label">Phone <span class="visually-hidden">Area Code</span></label>
                  <input type="tel" class="form-control" id="phone" maxlength="3">
                  <div id="phoneHelp" class="form-text">(###)</div>
                </div>
                <div class="col-md-2">
                  <label for="exampleInputEmail1" class="form-label"><span class="visually-hidden">Phone Exchange Code</span>&nbsp;</label>
                  <input type="tel" class="form-control" id="phone2" maxlength="3">
                  <div id="phone2Help" class="form-text">###</div>
                </div>
                <div class="col-md-2">
                  <label for="exampleInputEmail1" class="form-label"><span class="visually-hidden">Phone Line Number</span>&nbsp;</label>
                  <input type="tel" class="form-control" id="phone3" maxlength="4">
                  <div id="phone3Help" class="form-text">####</div>
                </div>
              </div>

              <div class="mb-4">
                <label for="subject" class="form-label">Subject*</label>
                <input type="text" class="form-control" id="subject">
              </div>


              <div class="mb-4">
                <label for="message" class="form-label">Message*</label>
                <textarea class="form-control" id="message" rows="5"></textarea>
              </div>
            
            
            <button type="submit" class="btn-submit">Submit</button>
          </form> 
        </div>
      </div>
    </div>
  </section>
</main>

<footer>
  <div class="container">
    <div class="footer-row">
      <div class="copy-col">
        <p class="copy">&copy; 2022 iamtomfarrell.com</p>
        <p>Designed by my pal <a href="http://www.jbellinger.com/" target="_blank">JB</a> &amp; developed by me, of course.</p>
      </div>
      <div class="top-col">
        <button id="btn-top">
          @include('svgs.chevron-up')
        </button>
      </div>
    </div>
    

  </div>
</footer>

@endsection