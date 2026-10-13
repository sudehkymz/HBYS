<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $modulesPath = app_path('Modules');
        if (!is_dir($modulesPath)) {
            return;
        }

        // Dinamik modül keşfi: app/Modules altındaki tüm modül dizinlerini tarar
        $moduleDirectories = glob($modulesPath . '/*', GLOB_ONLYDIR);

        foreach ($moduleDirectories as $moduleDir) {
            $module = basename($moduleDir);

            // Modül Rotalarını Otomatik Yükle
            $routesPath = "{$moduleDir}/Routes/web.php";
            if (file_exists($routesPath)) {
                Route::middleware('web')->group($routesPath);
            }

            // Modül Veritabanı Migration'larını sadece CLI ortamında yükle (Web isteklerinde I/O yükünü önler)
            if ($this->app->runningInConsole()) {
                $migrationsPath = "{$moduleDir}/Database/Migrations";
                if (is_dir($migrationsPath)) {
                    $this->loadMigrationsFrom($migrationsPath);
                }
            }
        }

        // Pagination Bootstrap 5 Entegrasyonu
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Navbar Bildirim Rozeti ve Aktif Uyarılar İçin View Composer Entegrasyonu
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (auth()->check()) {
                $notificationService = app(\App\Modules\Notification\Services\NotificationService::class);
                $unreadCount = $notificationService->getUnreadCount(0, auth()->user());
                $allAlerts = $notificationService->getActiveClinicalAlerts(0, auth()->user());
                $unreadAlerts = array_values(array_filter($allAlerts, fn($a) => empty($a['is_read'])));

                $view->with('unreadNotificationCount', $unreadCount);
                $view->with('navAlerts', array_slice($unreadAlerts, 0, 5));
            } else {
                $view->with('unreadNotificationCount', 0);
                $view->with('navAlerts', []);
            }
        });
    }
}