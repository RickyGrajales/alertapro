<?php

namespace Modules\Eventos\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Console\Scheduling\Schedule;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

// Comandos
use Modules\Eventos\Console\Commands\NotificarEventosCommand;

// Policies
use Illuminate\Support\Facades\Gate;
use Modules\Eventos\Models\DocumentoEvento;
use Modules\Eventos\Policies\DocumentoEventoPolicy;

class EventosServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Eventos';
    protected string $nameLower = 'eventos';

    /**
     * Register services.
     */
    public function register(): void
    {
        // Providers internos del módulo
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        // Comandos Artisan
        $this->commands([
            NotificarEventosCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerTranslations();
        $this->registerViews();
        $this->registerPolicies();
        $this->registerMigrations();
        $this->registerRoutes();
        $this->registerSchedules();
    }

    /**
     * Registrar rutas del módulo
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(module_path($this->name, 'routes/web.php'));
    }

    /**
     * Registrar migraciones del módulo
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(
            module_path($this->name, 'Database/migrations')
        );
    }

    /**
     * Registrar policies del módulo
     */
    protected function registerPolicies(): void
    {
        Gate::policy(DocumentoEvento::class, DocumentoEventoPolicy::class);
    }

    /**
     * Programación de tareas (cron)
     */
    protected function registerSchedules(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule
                ->command('alertapro:notificar')
                ->hourly();
        });
    }

    /**
     * Traducciones
     */
    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(
                module_path($this->name, 'lang'),
                $this->nameLower
            );
            $this->loadJsonTranslationsFrom(
                module_path($this->name, 'lang')
            );
        }
    }

    /**
     * Configuración del módulo
     */
    protected function registerConfig(): void
    {
        $configPath = module_path(
            $this->name,
            config('modules.paths.generator.config.path')
        );

        if (!is_dir($configPath)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($configPath)
        );

        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $relativePath = str_replace(
                $configPath . DIRECTORY_SEPARATOR,
                '',
                $file->getPathname()
            );

            $configKey = str_replace(
                [DIRECTORY_SEPARATOR, '.php'],
                ['.', ''],
                $relativePath
            );

            $key = $configKey === 'config'
                ? $this->nameLower
                : $this->nameLower . '.' . $configKey;

            $this->publishes([
                $file->getPathname() => config_path($relativePath)
            ], 'config');

            $this->mergeConfigFrom(
                $file->getPathname(),
                $key
            );
        }
    }

    /**
     * Vistas del módulo
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->nameLower);
        $sourcePath = module_path($this->name, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->nameLower . '-module-views']);

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths(), [$sourcePath]),
            $this->nameLower
        );

        Blade::componentNamespace(
            config('modules.namespace') . '\\' . $this->name . '\\View\\Components',
            $this->nameLower
        );
    }

    /**
     * Rutas publicables de vistas
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];

        foreach (config('view.paths') as $path) {
            $modulePath = $path . '/modules/' . $this->nameLower;

            if (is_dir($modulePath)) {
                $paths[] = $modulePath;
            }
        }

        return $paths;
    }
}
