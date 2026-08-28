<?php

namespace Azuriom\Plugin\CreatorCodes\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Models\User;
use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Azuriom\Plugin\CreatorCodes\Listeners\RewardCreatorOnPaymentPaid;
use Azuriom\Plugin\CreatorCodes\Models\Creator;
use Azuriom\Plugin\CreatorCodes\Observers\PaymentObserver;
use Azuriom\Plugin\CreatorCodes\Observers\UserObserver;
use Azuriom\Plugin\CreatorCodes\View\Composers\ShopViewComposer;
use Azuriom\Plugin\Shop\Events\PaymentPaid;
use Azuriom\Plugin\Shop\Models\Payment;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;

class CreatorCodesServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        $this->app->singleton(CreatorCodeManager::class);
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        Permission::registerPermissions([
            'creatorcodes.manage' => 'creatorcodes::admin.permissions.manage',
        ]);

        ActionLog::registerLogModels([
            Creator::class,
        ], 'creatorcodes::admin.logs');

        Event::listen(PaymentPaid::class, RewardCreatorOnPaymentPaid::class);

        Payment::observe(PaymentObserver::class);
        User::observe(UserObserver::class);

        View::composer([
            'shop::offers.*',
            'shop::cart.index',
            'paysafecardmanual::pay',
            'plugins.shop.*',
        ], ShopViewComposer::class);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'creatorcodes' => [
                'name' => trans('creatorcodes::admin.nav'),
                'icon' => 'bi bi-star',
                'route' => 'creatorcodes.admin.index',
                'permission' => 'creatorcodes.manage',
            ],
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        return [];
    }
}
