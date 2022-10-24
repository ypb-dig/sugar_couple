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
			'dist/css/home*.css',
      'css/plans.css'  
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
  
	<section class="info-section bg-7">
	 		<div class="title"> Como funciona? </div>
  </section>
  <script>
    function selectPlan(plan){
      window.location = "/user/premium?plan=" + plan;
    }
  </script>
  <style>
    .info {
      color: #000;
      margin-top: 40px;
      padding-bottom: 20px;
    }

    .info b {
      font-family: "Myriad Apple Bold";
    }

    h1.title {
        font-size: 20px;
        /*text-align: center;*/
        margin-top: 40px;
        margin-bottom: 20px;
        color: #9e221f;
    }

    p {
        /*text-align: center;*/
        color: #585858;
        margin-bottom: 0px;
    }

  </style>
  <section class="container info texto-cinza">
      <h1 class="title">IMPORTANTE: NÃO PERMITIMOS PROSTITUIÇÃO E PROMISCUIDADE NESTE SITE</h1>
      <p>Atenção! Para sua própria segurança, não armazenaremos seu login e senha. Tendo que inseri-los a cada entrada.</p>
      <p>Esta plataforma foi desenvolvida para que você possa encontrar o AMOR da sua VIDA.</p>
      <p>Desfrutar de momentos inesquecíveis através da última geração de ferramentas digitais, com total segurança de seus dados.</p>
      <p>Faremos todo esforço para manter o alto nível das interações e que as informações dos assinantes sejam verídicas, pois serão verificadas.</p>
      
      <h1 class="title">Vantagens de ser PLATINUM ou GOLD:</h1>
      <p>Ao escolher um de nossos planos PREMIUM, você obterá inúmeras vantagens.</p>
      <p>Nesta plataforma, você terá a possibilidade de usar moedas virtuais, que são as nossas COINS (C$), para mandar mimos e presentes virtuais para as pessoas com quem você escolher conversar.</p>
      <p><i>Sugestão: Inicie uma conversa mandando um presente virtual ao se apresentar para a pessoa escolhida, demonstrando assim todo seu potencial.</i></p>
      <p>Nesta plataforma o valor pago pelo seu plano é transformada em Coins (C$) da seguinte maneira:</p>
      <p>
          PLATINUM = 100%<br />
          GOLD = 50%<br />
      </p>
      <p>Procuramos criar uma plataforma com ambiente clean, moderno, de fácil utilização e que você possa ter a oportunidade de demonstrar todo o seu PODER, bastando enquadrar-se em um dos nossos planos VIP´s.</p>
      
      <h1 class="title">Atenção MOMMIES &amp; DADDIES:</h1>
      <p>Ao fazer sua pesquisa, deem preferência às pagantes, pois as chances de encontrar uma pessoa de bom nível são maiores.</p>
      <p>Da mesma forma, elas preferirão os DADDY e MOMMY mais “ricos”, pois demonstram mais poder e status.</p>
      <p>Use suas COINS (SC$) e mande muitos presentes.</p>
      
      <h1 class="title">Atenção BABIES:</h1>
      <p>Ao procurar uma pessoa, deem preferência ao DADDY/MOMMY mais RICOS (VIP´s), pois as chances de encontrar uma pessoa disposta a dar mimos, presentes etc. são muito maiores.</p>
      <p>Da mesma forma, DADDY/MOMMY preferirão BABBY PLATINUM ou GOLD, pois demonstram maior interesse no tema.</p>
      <p>Use suas COINS (SC$) e mande muitos presentes.</p>
      
      <h1 class="title">ATENÇÃO : PROMOÇÃO DE INAUGURAÇÃO</h1>
      <p>
          NOSSOS PLANOS “PREMIUM” ESTÃO COM 80% DE DESCONTO.<br />
          APROVEITE A OPORTUNIDADE E ASSINE JÁ!
      </p>
      @if(!isLoggedIn())
        <a class="btn btn-sugar" href="<?= route('user.sign_up') ?>"> Cadastre-se </a>
      @endif
  </section>

    

	</section>
  @if(isLoggedIn())
	<section class="plans premium-plans">
      @if(isSugarDaddyOrMommy())
      <div class="container p-5 gray-container ">
        <!-- <p>(Para suggar mommies e sugar daddies)</p> -->
         <div class="plan plan-plantium">
          <div class="title">
            <i class="fa fa-trophy"></i> Platinum
          </div>
          <div class="highlight">
            <div class="white-line"></div>
            <p> Valores a partir de :</p>
            <div class="price" onclick="selectPlan('plantium_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_1") ?> / mês</div>
          </div>
          <div class="row m-0 p-0">
            <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_3") ?>/ 3 meses</div> </div>
            <!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('plantium_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_6") ?> / 6 meses</div> </div> -->
            <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_12") ?> / 12 meses</div> </div>
          </div>
          <div class="content">
            <ul>
              <li> <i class="fa fa-check-circle"></i> Direito à 20 fotos no seu perfil, com moldura PLATINUM na foto do perfil que demonstra ser um “ RICH MAN/WOMAN” </li>
              <li> <i class="fa fa-check-circle"></i> Direito à postagem de 5 vídeos;</li>
              <li> <i class="fa fa-check-circle"></i> Retorno de 100% do valor pago pela assinatura em SC$ (Sugar Coins), ou seja, por exemplo: SC$ 18570 (plano anual);</li>
              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
              <li> <i class="fa fa-check-circle"></i> Prioridade de mensagens (sua mensagem passará na frente das mensagens enviadas por outros usuários com planos inferiores);</li>
              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato para ser contatado; </li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Quem te viu, quem você vê”;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou “Localizador”;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que você tem interesse, podendo deixar recados e emojis;</li>
              <li> <i class="fa fa-check-circle"></i> Direito de receber recados em suas fotos, podendo deixá-los públicos ou privados;</li>
              <li> <i class="fa fa-check-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato coloca uma foto nova, para poder comentar).</li>

            </ul>
            <p>Lembrando que ao optar pelo plano PLATINUM ANUAL, você terá 100% (cem porcento) do valor pago em reais convertido em Sugar Coins (SC$ 18.570).</p>
          </div>

        </div>

        <div class="plan plan-gold">
          <div class="title">
            <i class="fa fa-users"></i>  GOLD
          </div>
          <div class="highlight">
            <div class="white-line"></div>
            <p> Valores a partir de :</p>
            <div class="price" onclick="selectPlan('gold_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_1") ?> / mês</div>
          </div>
          <div class="row m-0 p-0">
            <div class="_col col-md-6 col-sm-12"> <div class="price"  onclick="selectPlan('gold_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_3") ?> / 3 meses</div> </div>
            <!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('gold_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_6") ?> / 6 meses</div> </div> -->
            <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_12") ?> / 12 meses</div> </div>
          </div>
          <div class="content">
            <ul>

              <li> <i class="fa fa-check-circle"></i> Direito à 5 fotos, com moldura GOLD na foto do perfil; </li>
              <li> <i class="fa fa-check-circle"></i> Direito à postagem de 2 vídeos;</li>
              <li> <i class="fa fa-check-circle"></i> Retorno de 50% do valor pago pela assinatura em SC$ (Sugar Coins), ou seja, por exemplo: SC$ 6.470 (plano anual);</li>
              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato para ser contatado; </li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Quem te viu, quem você vê”; </li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou “Localizador”;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que você tem interesse, podendo deixar recados e emojis;</li>
              <li> <i class="fa fa-check-circle"></i> Direito de receber recados em suas fotos, podendo deixá-los públicos ou privados;</li>
              <li> <i class="fa fa-times-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato coloca uma foto nova, para poder comentar).</li>             
            </ul>
            <p>Lembrando que ao optar pelo plano GOLD ANUAL, você terá 50% (cinquenta porcento) do valor pago em reais convertido em Sugar Coins (SC$ 6.470).</p>
          </div>
        </div>
      </div>
      @endif
   
      @if(isSugarBaby())
      <div class="container p-5 gray-container ">
        <!-- <p>(Para suggar babies)</p> -->
        <div class="plan plan-plantium">
          <div class="title">
            <i class="fa fa-trophy"></i> Platinum
          </div>
          <div class="highlight">
            <div class="white-line"></div>
            <p> Valores a partir de :</p>
            <div class="price" onclick="selectPlan('plantium_baby_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_1") ?> / mês</div>
          </div>
          <div class="row m-0 p-0">
            <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_3") ?> / 3 meses</div> </div>
            <!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_6") ?> / 6 meses</div> </div> -->
            <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_12") ?> / 12 meses</div> </div>
          </div>
          <div class="content">
            <ul>
              <li> <i class="fa fa-check-circle"></i> Direito à 20 fotos, com moldura GOLD na foto do perfil;  </li>
              <li> <i class="fa fa-check-circle"></i> Direito à postagem de 2 vídeos;</li>
              <li> <i class="fa fa-check-circle"></i> Retorno de 100% do valor pago pela assinatura em SC$ (Sugar Coins), ou seja, por exemplo: SC$ 5.630 (plano anual);</li>
              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato para ser contatado;  </li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Quem te viu, quem você vê”; </li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou “Localizador”;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que você tem interesse, podendo deixar recados e emojis;</li>
              <li> <i class="fa fa-check-circle"></i> Direito de receber recados em suas fotos, podendo deixá-los públicos ou privados;</li>
              <li> <i class="fa fa-check-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato coloca uma foto nova, para poder comentar).</li>
            </ul>
            <p>Lembrando que ao optar por esse plano, você terá 100% (cem porcento) do valor pago em reais convertido em Sugar Coins (SC$ 5.630).</p>
          </div>
        </div>

        <div class="plan plan-gold">
          <div class="title">
            <i class="fa fa-users"></i> GOLD
          </div>
          <div class="highlight">
            <div class="white-line"></div>
            <p> Valores a partir de :</p>
            <div class="price" onclick="selectPlan('gold_baby_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_1") ?> / mês</div>
          </div>
          <div class="row m-0 p-0">
            <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_3") ?> / 3 meses</div> </div>
            <!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_6") ?> / 6 meses</div> </div> -->
            <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_12") ?> / 12 meses</div> </div>
          </div>
          <div class="content">
            <ul>
              <li> <i class="fa fa-check-circle"></i> Direito à 5 fotos, com moldura GOLD na foto do perfil; </li>
              <li> <i class="fa fa-check-circle"></i> Direito à postagem de 2 vídeos;</li>
              <li> <i class="fa fa-check-circle"></i> Retorno de 50% do valor pago pela assinatura em SC$ (Sugar Coins), ou seja, por exemplo: SC$ 1.555 (plano anual);</li>
              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato para ser contatado; </li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Quem te viu, quem você vê”; </li>
              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou “Localizador”;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que você tem interesse, podendo deixar recados e emojis;</li>
              <li> <i class="fa fa-check-circle"></i> Direito de receber recados em suas fotos, podendo deixá-los públicos ou privados;</li>
              <li> <i class="fa fa-times-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato coloca uma foto nova, para poder comentar).</li>
            </ul>
            <p>Lembrando que ao optar por esse plano, você terá 50% (cinquenta porcento) do valor pago em reais convertido em Sugar Coins (SC$ 1.555).</p>
          </div>
        </div>
      </div>
      @endif

      <div class="container p-5">
        <div class="plan">
          <div class="title">
            <i class="fa fa-user"></i> FREE
          </div>
          <div class="content">
            <p> Poderá usar o QUERO MEU DADDY todos os dias por 5 minutos por dia;  </p>
            <ul>

              <li> <i class="fa fa-check-circle"></i> Poderá usar o QUERO MEU DADDY todos os dias por 5 minutos por dia;</li>
              <li> <i class="fa fa-check-circle"></i> Direito a uma foto no seu perfil;</li>
              <li> <i class="fa fa-times-circle"></i> Direito de postar vídeos;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso à compra de SC$ ;</li>
              <li> <i class="fa fa-check-circle"></i> Direito a mandar 2 mensagens por dia;</li>
              <li> <i class="fa fa-check-circle"></i> Acesso nítido às fotos;</li>
              <li> <i class="fa fa-times-circle"></i> Mandar o telefone ou contato para ser contatado;</li>
              <li> <i class="fa fa-check-circle"></i> Receber o contato de outro cliente PLATINUM ou GOLD .</li>
              <li> <i class="fa fa-times-circle"></i> Acesso ao quem te viu quem você vê</li>
              <li> <i class="fa fa-times-circle"></i> Acesso à recadinhos nas fotos</li>
              <li> <i class="fa fa-times-circle"></i> Receber recadinhos em sua foto.</li>              
          </div>
        </div>
      </div>


  </section>
  @endif
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