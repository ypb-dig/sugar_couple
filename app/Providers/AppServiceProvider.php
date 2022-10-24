<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {	
    	//for collection method
        Collection::macro('paginate', function(int $perPage = 15, $page = null, $options = []) {
		    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		    return new LengthAwarePaginator(
		        $this->forPage($page, $perPage)->values(),
		        $this->count(),
		        $perPage,
		        $page,
		        $options
		    );
		});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {


        if (env('APP_ENV') !== 'local') {
            $url->forceScheme('http');
        }

        require app_path('Yantrana/Support/extended-blade-directive.php');
    }
}
