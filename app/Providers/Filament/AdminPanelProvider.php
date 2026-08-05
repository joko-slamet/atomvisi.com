<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName('Atom Visi Indonesia')
            ->brandLogo(fn () => asset('images/logo-light.png'))
            ->brandLogoHeight('2.25rem')
            ->colors([
                'primary' => [
                    50 => '224, 245, 241',
                    100 => '198, 237, 231',
                    200 => '154, 222, 211',
                    300 => '104, 202, 186',
                    400 => '54, 165, 147',
                    500 => '22, 116, 101',
                    600 => '12, 88, 76',
                    700 => '11, 67, 58',
                    800 => '9, 51, 45',
                    900 => '6, 38, 33',
                    950 => '3, 17, 15',
                ],
                'gold' => [
                    50 => '254, 252, 246',
                    100 => '251, 244, 221',
                    200 => '245, 229, 177',
                    300 => '238, 211, 125',
                    400 => '229, 196, 90',
                    500 => '216, 180, 65',
                    600 => '188, 153, 43',
                    700 => '151, 124, 37',
                    800 => '124, 103, 36',
                    900 => '105, 88, 33',
                ],
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => new HtmlString(<<<'HTML'
                    <style>
                        .fi-sidebar,
                        .fi-sidebar-header,
                        .fi-sidebar-nav {
                            background-color: #0b433a !important;
                        }
                        .fi-sidebar-header {
                            box-shadow: none !important;
                            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                        }
                        .fi-sidebar-item-label,
                        .fi-sidebar-group-label {
                            color: #e0f5f1 !important;
                        }
                        .fi-sidebar-item-icon,
                        .fi-sidebar-group-icon {
                            color: #68caba !important;
                        }
                        .fi-sidebar-item-button:hover,
                        .fi-sidebar-group-button:hover {
                            background-color: rgba(255, 255, 255, 0.08) !important;
                        }
                        .fi-sidebar-item-active .fi-sidebar-item-button {
                            background-color: rgba(216, 180, 65, 0.15) !important;
                        }
                        .fi-sidebar-item-active .fi-sidebar-item-label,
                        .fi-sidebar-item-active .fi-sidebar-item-icon {
                            color: #d8b441 !important;
                        }
                    </style>
                    HTML
                ),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
