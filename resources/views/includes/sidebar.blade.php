<!-- Sidebar -->
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="<?= route('user.profile_view', ['username' => getUserAuthInfo('profile.username')]) ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= getStoreSettings('small_logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= makeLinkActive('manage.dashboard') ?> mt-2">
        <a class="nav-link" href="<?= route('manage.dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span><?= __tr( 'Dashboard' ) ?></span>
        </a>
    </li>
    @if(isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'cupom']) ?>">
            <!-- <i class="fas fa-broom"></i> -->
            <span><?= __tr('Cupom') ?></span>
        </a>
    </li>
    @endif
    @if(isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'email']) ?>">
            <i class="fas fa-envelope-open-text"></i>
            <span><?= __tr('Email') ?></span>
        </a>
    </li>
    @endif
    <li class="nav-item <?= makeLinkActive('manage.item.sticker.view') ?>">
        <a class="nav-link" href="<?= route('manage.item.sticker.view') ?>">
            <i class="fas fa fa-sticky-note"></i>
            <span><?= __tr( 'Stickers' ) ?></span>
        </a>
    </li>
    <li class="nav-item <?= makeLinkActive('manage.user.photos_list') ?>">
        <a class="nav-link" href="<?= route('manage.user.photos_list') ?>">
            <i class="fas fa-users"></i>
            <span><?= __tr('Fotos carregadas pelos usuários') ?></span>
        </a>
    </li>
    @if(isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'integration']) ?>">
            <!-- <i class="fas fa-broom"></i> -->
            <span><?= __tr('Integrations') ?></span>
        </a>
    </li>
    @endif
    <li class="nav-item <?= makeLinkActive('manage.financial_transaction.read.view_list') ?>">
        <a class="nav-link" href="<?= route('manage.financial_transaction.read.view_list', ['transactionType' => 'live']) ?>">
            <i class="fas fa-university"></i>
            <span><?= __tr('Financial Transactions') ?></span>
        </a>
    </li>
    @if(isAdmin())
    <li class="nav-item <?= makeLinkActive('manage.page.view') ?>">
        <a class="nav-link" href="<?= route('manage.page.view') ?>">
            <i class="fas fa-file"></i>
            <span><?= __tr( 'Pages' ) ?></span>
        </a>
    </li>
    @endif


	<li class="nav-item <?= makeLinkActive('manage.credit_package.read.list') ?>">
		<a class="nav-link" href="<?= route('manage.credit_package.read.list') ?>">
            <i class="fas fa-box"></i>
            <span><?= __tr( 'Credit Packages' ) ?></span>
		</a>
	</li>
    @if(isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'premium-plans']) ?>">
            <i class="fa fa-gem"></i>
            <span><?= __tr('Premium Plans') ?></span>
        </a>
    </li>
    @endif
    <li class="nav-item <?= makeLinkActive('manage.item.gift.view') ?>">
        <a class="nav-link" href="<?= route('manage.item.gift.view') ?>">
            <i class="fas fa fa-gift"></i>
            <span><?= __tr( 'Gifts' ) ?></span>
        </a>
    </li>
    @if(isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'advertisement']) ?>">
            <i class="fa fa-bullhorn"></i>
            <span><?= __tr('Advertisement') ?></span>
        </a>
    </li>
    @endif

	<li class="nav-item <?= makeLinkActive('manage.abuse_report.read.list') ?>">
		<a class="nav-link" href="<?= route('manage.abuse_report.read.list', ['status' => 1]) ?>">
            <i class="fas fa-flag"></i>
            <span><?= __tr( 'Abuse Reports' ) ?></span>
        </a>
    </li>
    @if(isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'premium-feature']) ?>">
            <!-- <i class="fas fa-broom"></i> -->
            <span><?= __tr('Features') ?></span>
        </a>
    </li>
    @endif
	<li class="nav-item <?= makeLinkActive('manage.user.view_list') ?>">
        <a class="nav-link" href="<?= route('manage.user.view_list', ['status' => 1]) ?>">
            <i class="fas fa-users"></i>
            <span><?= __tr('Users') ?></span>
        </a>
    </li>


    @if(isAdmin())
    <li class="nav-item <?= makeLinkActive('manage.translations.languages') ?>">
        <a class="nav-link" href="<?= route('manage.translations.languages') ?>">
            <i class="fas fa-language"></i>
            <span><?= __tr('Languages') ?></span>
        </a>
    </li>
    @endif

    @if(isAdmin())
	<li class="nav-item <?= makeLinkActive('manage.fake_users.read.generator_options') ?> hide">
        <a class="nav-link" href="<?= route('manage.fake_users.read.generator_options') ?>">
            <i class="fas fa-user-plus"></i>
            <span><?= __tr('Generate Fake Users') ?></span>
        </a>
    </li>
    @endif

    @if(isAdmin() && request()->get('master'))
    <li class="nav-item">
        <a class="nav-link" title="<?= __tr("If you have made changes which doesn't reflecting this link may help to clear all the cache.") ?>" href="<?= route('manage.configuration.clear_cache', []).'?redirectTo='.base64_encode(Request::fullUrl()); ?>">
            <i class="fas fa-broom"></i>
            <span><?= __tr('Clear System Cache') ?></span>
        </a>
    </li>
    @endif

    @if(isAdmin() && request()->get('master'))
    <li class="nav-item <?= makeLinkActive('manage.configuration.read') ?>">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'general']) ?>">
            <i class="fas fa-cogs"></i>
            <span><?= __tr('Settings') ?></span>
        </a>
    </li>
    @endif

    @if(isAdmin() && request()->get('master'))
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'user']) ?>">
            <!-- <i class="fas fa-broom"></i> -->
            <span><?= __tr('Usuários') ?></span>
        </a>
    </li>
    @endif
    @if(isAdmin() && request()->get('master'))
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'currency']) ?>">
            <!-- <i class="fas fa-broom"></i> -->
            <span><?= __tr('Currency') ?></span>
        </a>
    </li>
    @endif
    @if(isAdmin() && request()->get('master') )
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'payment']) ?>">
            <!-- <i class="fas fa-broom"></i> -->
            <span><?= __tr('Gateway de Pagamento') ?></span>
        </a>
    </li>
    @endif
    @if(isAdmin() && request()->get('master'))
    <li class="nav-item">
        <a class="nav-link" href="<?= route('manage.configuration.read', ['pageType' => 'social-login']) ?>">
            <!-- <i class="fas fa-broom"></i> -->
            <span><?= __tr('Login com Redes Sociais') ?></span>
        </a>
    </li>
    @endif


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->