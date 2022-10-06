@extends('_layouts.main')

@section('body')

@include('_layouts._partials.header')

<main id="top">
  <div id="smooth-content">
  
    @include('_layouts._sections.hero')
    @include('_layouts._sections.about')
    @include('_layouts._sections.skills')
  
    <section id="portfolio">
      <div class="container">
        <h2 class="with-line mb-5">Portfolio</h2>

        <div class="see-portfolio">
          <p>If you would like to see more of my work, <a href="#contact" class="link-main scroll-to">send me a quick email</a>. Already have access? <a href="/unlocked" class="with-icon">Click here to login <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="link-icon"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z"/></svg></a></p>
        </div>

        <div class="row row-portfolio">
          <div class="col-site col-md-6 col-lg-4">
            <a data-bs-toggle="modal" href="#ijlModal" role="button">
              <img src="/assets/images/site-itsjustlunch-2x.jpg" alt="It's Just Lunch website">
            </a>
          </div>
          <div class="col-site col-md-6 col-lg-4">
            <a href="/unlocked" role="button" class="locked-out" title="click here to unlock">
              <img src="/assets/images/site-gb-blur.jpg" alt="">
              <div class="locked-txt">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="link-icon"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
              </div>
            </a>
          </div>
          <div class="col-site col-md-6 col-lg-4">
            <a href="/unlocked" role="button" class="locked-out" title="click here to unlock">
              <img src="/assets/images/site-ar-blur.jpg" alt="">
              <div class="locked-txt">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="link-icon"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
              </div>
            </a>
          </div>
          <div class="col-site col-md-6 col-lg-4">
            <a href="/unlocked" role="button" class="locked-out" title="click here to unlock">
              <img src="/assets/images/site-mmh-blur.jpg" alt="">
              <div class="locked-txt">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="link-icon"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
              </div>
            </a>
          </div>
          <div class="col-site col-md-6 col-lg-4">
            <a href="/unlocked" role="button" class="locked-out" title="click here to unlock">
              <img src="/assets/images/site-ob-blur.jpg" alt="">
              <div class="locked-txt">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="link-icon"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
              </div>
            </a>
          </div>
          <div class="col-site col-md-6 col-lg-4">
            <a href="/unlocked" role="button" class="locked-out" title="click here to unlock">
              <img src="/assets/images/site-ug-blur.jpg" alt="">
              <div class="locked-txt">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="link-icon"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
              </div>
            </a>
          </div>
        </div>

        <h2 class="with-line mb-5">CONCEPTS & DEMOS</h2>
        <div class="row row-concepts">
          <div class="col-md-6 col-concept">
            <p class="codepen" data-height="450" data-slug-hash="QeqKXe" data-user="tomfarrell" style="height: 450px; box-sizing: border-box; display: flex; align-items: center; justify-content: center; border: 2px solid; margin: 1em 0; padding: 1em;">
              <span>See the Pen <a href="https://codepen.io/tomfarrell/pen/QeqKXe">
              Pure CSS Animated Halloween Ghost</a> by Tom Farrell (<a href="https://codepen.io/tomfarrell">@tomfarrell</a>)
              on <a href="https://codepen.io">CodePen</a>.</span>
            </p>
            <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
            <div class="codepen-caption">&mdash;Pure CSS Animation&mdash;</div>
          </div>
          <div class="col-md-6 col-concept">
            <p class="codepen" data-height="450" data-default-tab="result" data-slug-hash="QeMoZr" data-user="tomfarrell" style="height: 450px; box-sizing: border-box; display: flex; align-items: center; justify-content: center; border: 2px solid; margin: 1em 0; padding: 1em;">
              <span>See the Pen <a href="https://codepen.io/tomfarrell/pen/QeMoZr">
              Pure CSS Animated Halloween Jack-o-lantern</a> by Tom Farrell (<a href="https://codepen.io/tomfarrell">@tomfarrell</a>)
              on <a href="https://codepen.io">CodePen</a>.</span>
            </p>
            <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
            <div class="codepen-caption">&mdash;Pure CSS Animation&mdash;</div>
          </div>
        </div>
      </div>
    </section>

    @include('_layouts._sections.resume')
    @include('_layouts._sections.contact')
  
</main>

@include('_layouts._partials.footer')

<div class="modal fade" id="ijlModal" tabindex="-1" aria-labelledby="ijlModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row row-work">
          <div class="col-md-7 col-screens">
            <img src="assets/images/ijl-screens.png" alt="">
          </div>
          <div class="col-md-5">
            <h3>It's Just Lunch</h3>
            <h4>Custom CMS</h4>
            <div class="tags">
              <div>JavaScript</div>
              <div>SASS/CSS</div>
              <div>HTML</div>
              <div>Bootstrap</div>
              <div>GSAP</div>
            </div>
            
            <a href="http://www.itsjustlunch.com" target="_blank" class="btn-main">Visit Website</a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

@endsection