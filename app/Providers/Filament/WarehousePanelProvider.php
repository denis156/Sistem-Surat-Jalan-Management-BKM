<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use App\Filament\Warehouse\Resources\DeliveryNoteResource;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class WarehousePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('warehouse')
            ->path('warehouse')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->sidebarCollapsibleOnDesktop()
            ->favicon(asset('images/logo.png'))
            ->brandName('Panel Gudang SJ-BKM')
            ->sidebarWidth('19rem')
            ->font('Comic Sans MS')
            ->colors([
                'primary' => '#057A55',
                'danger' => Color::Rose,
                'secondary' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Warehouse/Resources'), for: 'App\\Filament\\Warehouse\\Resources')
            ->discoverPages(in: app_path('Filament/Warehouse/Pages'), for: 'App\\Filament\\Warehouse\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Warehouse/Widgets'), for: 'App\\Filament\\Warehouse\\Widgets')
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
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('Menu Utama')
                        ->items([
                            NavigationItem::make('dashboard')
                                ->label(fn(): string => __('filament-panels::pages/dashboard.title'))
                                ->url(fn(): string => Dashboard::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.warehouse.pages.dashboard'))
                                ->icon('heroicon-o-home'),
                        ])
                        ->collapsible(false),
                    NavigationGroup::make('Management Surat Jalan')
                        ->items([
                            ...DeliveryNoteResource::getNavigationItems(),
                        ]),
                ]);
            });
    }
}
