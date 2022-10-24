<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="/">
          <img class="lw-logo-img" src="/imgs/logotipo-quero-p.png" alt="<?= getStoreSettings('name') ?>">
    </a>
    <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger  {{(strpos(Route::currentRouteName(), 'landing_page') == 0) ? 'active' : '' }}" href="<?= route('landing_page') ?>"><?= __tr('HOME') ?></a>
        </li>
        <li class="nav-item {{ (strpos(Route::currentRouteName(), 'plans') == 0) ? 'active' : '' }}">
          <a class="nav-link js-scroll-trigger" href="<?= route('plans') ?>"><?= __tr('COMO FUNCIONA') ?></a>
        </li>
        <li class="nav-item {{ (strpos(Route::currentRouteName(), 'policy') == 0) ? 'active' : '' }}">
          <a class="nav-link js-scroll-trigger" href="<?= route('privacy') ?>"><?= __tr('POLÍTICA DE PRIVACIDADE') ?></a>
        </li>
        @if(!isLoggedIn())
        <li class="nav-item">
          <div class="nav-link d-none d-lg-block" onclick="showLoginForm()"><?= __tr('LOGIN') ?></div>
          <a class="nav-link d-lg-none" href="<?= route('user.login') ?>"><?= __tr('LOGIN') ?></a>

          <div id="popover-login-content">
            <div class="arrow-up"></div>
            @include("user.login-landing")
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-sugar" href="<?= route('user.sign_up') ?>"><?= __tr('CADASTRE-SE') ?></a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link btn btn-sugar" href="<?= url('/home') ?>"><?= __tr('Entrar') ?></a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>

<script>
function showLoginForm(){
  if($("#popover-login-content").is(":visible")){
    $("#popover-login-content").hide();
  } else {
    $("#popover-login-content").show();
  }
}

</script>