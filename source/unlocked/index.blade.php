@extends('_layouts.main-unlocked')

@section('body')

@include('_layouts._partials.header')

<main id="top">
  <div id="smooth-content">
    @include('_layouts._sections.hero')
    @include('_layouts._sections.about')
    @include('_layouts._sections.skills') 

    <section id="portfolio" class="unlocked">
      <div class="container">
        <h2 class="with-line mb-5">Portfolio</h2>

        @include('_unlocked-partials._portfolio-unlocked')

        <h2 class="with-line mb-5">CONCEPTS & DEMOS</h2>
        <div class="row row-concepts">
          <div class="col-md-6 col-concept">
            <p class="codepen" data-height="450" data-slug-hash="QeqKXe" data-user="tomfarrell" style="height: 450px; box-sizing: border-box; display: flex; align-items: center; justify-content: center; border: 2px solid; margin: 1em 0; padding: 1em;">
              <span>See the Pen <a href="https://codepen.io/tomfarrell/pen/QeqKXe">
              Pure CSS Animated Halloween Ghost</a> by Tom Farrell (<a href="https://codepen.io/tomfarrell">@tomfarrell</a>)
              on <a href="https://codepen.io">CodePen</a>.</span>
            </p>
            <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
          </div>
          <div class="col-md-6 col-concept">
            <p class="codepen" data-height="450" data-default-tab="result" data-slug-hash="QeMoZr" data-user="tomfarrell" style="height: 450px; box-sizing: border-box; display: flex; align-items: center; justify-content: center; border: 2px solid; margin: 1em 0; padding: 1em;">
              <span>See the Pen <a href="https://codepen.io/tomfarrell/pen/QeMoZr">
              Pure CSS Animated Halloween Jack-o-lantern</a> by Tom Farrell (<a href="https://codepen.io/tomfarrell">@tomfarrell</a>)
              on <a href="https://codepen.io">CodePen</a>.</span>
            </p>
            <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
          </div>
        </div>
      </div>
    </section>

    @include('_layouts._sections.resume')
    @include('_layouts._sections.contact')

</main>

@include('_layouts._partials.footer')

@endsection