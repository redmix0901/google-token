<?php
namespace Redmix0901\GoogleToken;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Redmix0901\GoogleToken\Contracts\GoogleClientInterface;
use Redmix0901\GoogleToken\GoogleClientService;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the service provider.
     * @author Tu Tran
     */
    public function boot()
    {
        $this->commands([
            \Redmix0901\GoogleToken\Command\FetchTokenGoogle::class
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleClientInterface::class, GoogleClientService::class);

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/google-token.php', 'google-token');
        }
    }
}
