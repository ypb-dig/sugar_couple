<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="facebook-domain-verification" content="66oae83puuboeais639w2zg1dkctq5" />

  <title><?= getStoreSettings('name') ?></title>
    
    
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '412802423360279');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=412802423360279&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5ZHTDXM');</script>
    <!-- End Google Tag Manager -->
    
    
    
		<?= __yesset([
            'dist/css/public-assets-app*.css',
            'dist/fa/css/all.min.css',
			'dist/css/home*.css'
		], true) ?>


    <!-- Custom styles for this template-->
    <?= __yesset([
      'dist/css/public-assets-app*.css',
      'dist/fa/css/all.min.css',
      "dist/css/vendorlibs-datatable.css",
      "dist/css/vendorlibs-photoswipe.css",
      "dist/css/vendorlibs-smartwizard.css",
      'dist/css/custom.src.css',
      'dist/css/messenger*.css',
      'dist/css/login-register*.css'          
    ], true) ?>

    <link rel="shortcut icon" href="<?= __yesset('favicon.ico') ?>" type="image/x-icon">
    <link rel="icon" href="<?= __yesset('favicon.ico') ?>" type="image/x-icon">

    <!-- Custom styles for this wesite-->
    <?= __yesset([
            'css/app.css',  
            'js/app.js'            
    ], true) ?>

</head>

<body id="page-top" class="landing-page">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZHTDXM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

  @include('includes.landing-navbar')
  @include('includes.landing-goldenbar')
  
  <style>
  .title.alt2{
    margin-bottom: 30px;
    padding-left: 15px;
  }
  </style>
  <section class="info-section bg-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-7 col-xs-10 text-center">
          <div class="title alt2">
            RELAÇÃO SUGAR - UM NAMORO À MODA ANTIGA
          </div>
          <div class="title">
            Tenha as mais excitantes <br/>Experiências da sua vida!</div>
          @if(!isLoggedIn())
          <a class="btn btn-sugar" href="<?= route('user.sign_up') ?>"> Cadastre-se </a>
          @endif
        </div>
      </div>
    </div>
  </section>

  <section class="info-section bg-4">
    <div class="container">
      <div class="row">
        <div class="offset-lg-4 col-lg-6 col-sm-12 col-xs-12">
          <div class="title">O que são sugars babies?</div>
          <p>As Sugar Babies são mulheres lindas, decididas que gostam<br/>
            de se cuidar e sabem qual o verdadeiro preço da beleza.</p>
          <p>
          Nossas Babies buscam homens bem sucedidos,<br/>
          elegantes e charmosos, influentes que possam<br/>
          oferecer um mundo de oportunidades<br/>
          e momentos incríveis. 
          </p>
          <p>
          As Babies possuem objetivos específicos:<br/>
          crescer de forma pessoal e intelectual,<br/>
          ter luxo, requinte e conforto sem<br/>
          se preocupar com as contas.
          </p>
          <p class="mobile">As Sugar Babies são mulheres lindas, decididas que gostam
            de se cuidar e sabem qual o verdadeiro preço da beleza.</p>
          <p class="mobile">
          Nossas Babies buscam homens bem sucedidos,
          elegantes e charmosos, influentes que possam
          oferecer um mundo de oportunidades
          e momentos incríveis. 
          </p>
          <p class="mobile">
          As Babies possuem objetivos específicos:
          crescer de forma pessoal e intelectual,
          ter luxo, requinte e conforto sem
          se preocupar com as contas.
          </p>
        </div>
        <div class="col"></div>
      </div>
    </div>
  </section>

  <section class="info-section bg-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
          <div class="title">As vantagens de ser sugars baby</div>
          <span class="dot"></span>
          <p>Experiências incríveis, viagens fantásticas, 
          mimos e muitos presentes.</p>
          <br/>
          <span class="dot"></span>
          <p>Networking com excelentes relações
          para um crescimento pessoal ainda maior</p>
          <br/>
          <span class="dot"></span>
          <p>Relacionamentos sinceros e objetivos, 
          sem rodeios e em comum acordo</p>
        </div>
      </div>
    </div>
  </section>


  <section class="info-section bg-2">
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-6 col-lg-5 offset-lg-7">
          <div class="title">O que são sugar daddy & sugar mommy?</div>
          
          <p>Homens e mulheres experientes, elegantes,
          bem sucedidos, confiantes e influentes. 
          Gostam de dividir conhecimento, experiências
          incríveis e momentos especiais com 
          sua Baby.
          </p>
          <p>
          Os Daddies e as mommies são, acima 
          de tudo, generosos, por isso as Babies
          que buscam por homens maduros e bem
           sucedidos esperam aprender
          coisas novas, ganhar mimos e garantir
          experiências incríveis.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="info-section bg-1">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="title">O que Mommies e Daddies oferecem?</div>
          <span class="dot"></span>
          <p>Viagens, mimos e presentes são pontos garantidos
            em uma relação Sugar. Muitas viagens de negócio
            dos Daddies se tornam uma excelente oportunidade 
            para conhecer o mundo e renovar seu guarda roupas.</p>
          <br/>
          <span class="dot"></span>
          <p>Os Daddies são bem relacionados, trabalham em grandes 
          companhias, e às vezes, são os donos de grandes 
          empresas. Viajam com frequência, vão a jantares, 
          almoços e festas regadas a boas companhias, 
          bebidas de luxo e muito networking.</p>
          <br/>
          <span class="dot"></span>
          <p>Nada de jogos ou mentiras. Tudo é definido
          bem antes, para que não haja dúvida para
          nenhum dos lados. Tudo no relacionamento 
          Sugar é baseado na transparência, mas 
          principalmente nos benefícios que 
          ambos terão.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- Newsleter -->
  @include('includes.landing-newsleter')

  <!-- Footer -->
  @include("includes.landing-footer")

<style>

</style>
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <?= __yesset([
    'dist/js/vendorlibs-public.js',
    'dist/js/vendorlibs-datatable.js',
    'dist/js/vendorlibs-photoswipe.js',
    // 'dist/js/common-app.*.js',
    // 'dist/js/vendor-second.js',
    // 'dist/js/vendorlibs-smartwizard.js'
], true) ?>

<script>
(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 70)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 100
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-shrink");
    } else {
      $("#mainNav").removeClass("navbar-shrink");
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);

  $('.login-popover').popover({
    html: true, 
    content: function() {
      return $('#popover-login-content').html();
    }
  });

})(jQuery); // End of use strict

</script>

</body>

</html>
