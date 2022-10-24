<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="facebook-domain-verification" content="66oae83puuboeais639w2zg1dkctq5" />
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
    
    <!-- Google tag (gtag.js) Analytics Desenvolvimento YPB
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VPYN5T8RXX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-VPYN5T8RXX');
    </script>-->
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P20Y7HDC0N%22%3E"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-P20Y7HDC0N');
    </script>
  
    
    
  <title>Quero Meu Daddy</title>

		<?= __yesset([
            'dist/css/public-assets-app*.css',
            'dist/fa/css/all.min.css',
			'dist/css/home*.css'
		], true) ?>

    <link rel="shortcut icon" href="<?= __yesset('favicon.ico') ?>" type="image/x-icon">
    <link rel="icon" href="<?= __yesset('favicon.ico') ?>" type="image/x-icon">

    <!-- Custom styles for this wesite-->
    <?= __yesset([
            'css/app.css',  
            'js/app.js'
    ], true) ?>

</head>

<body id="page-top">
    
   <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZHTDXM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

  @include('includes.landing-navbar')
  @include('includes.landing-goldenbar')
  
	<section class="info-section bg-6">
	 		<div class="title"> TERMOS E CONDIÇÕES DE USO </div>
	</section>
	<section class="privacy">
    	<div class="container">
			@include("includes.landing-terms")
   		</div>
  </section>


  <!-- Newsleter -->
  @include('includes.landing-newsleter')

  <!-- Footer -->
  @include("includes.landing-footer")

<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <?= __yesset([
    'dist/js/vendorlibs-public.js',
    // 'dist/js/vendorlibs-datatable.js',
    // 'dist/js/vendorlibs-photoswipe.js',
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

})(jQuery); // End of use strict

</script>

</body>

</html>