<?php
namespace TM30\Notify;


use Illuminate\Support\ServiceProvider;

class NotifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Notify::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/notify.php' => config_path('notify.php'),
        ], 'config');
        $this->mergeConfigFrom(__DIR__.'/../config/notify.php', 'notify');
    }
}
