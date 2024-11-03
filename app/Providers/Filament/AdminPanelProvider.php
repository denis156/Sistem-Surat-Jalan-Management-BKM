<?php

namespace App\Providers\Filament;

use App\Filament\Pages\LaporanSuratJalan;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use App\Filament\Resources\ClientResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\OfficerResource;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Resources\DeliveryNoteResource;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->sidebarCollapsibleOnDesktop()
            ->favicon(asset('images/logo.png'))
            ->brandLogo(asset('images/sidebar.png'))
            ->brandLogoHeight('49px')
            ->font('Comic Sans MS')
            ->sidebarWidth('17rem')
            ->colors([
                'primary' => '#005028',
                'danger' => Color::Rose,
                'secondary' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
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
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('Menu Utama')
                        ->items([
                            NavigationItem::make('dashboard')
                                ->label('Dashboard')
                                ->url(fn(): string => Dashboard::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.pages.dashboard'))
                                ->icon('heroicon-o-home'),
                            NavigationItem::make('laporan')
                                ->label('Laporan Surat Jalan')
                                ->url(fn(): string => LaporanSuratJalan::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.pages.laporan-surat-jalan'))
                                ->icon('heroicon-o-clipboard-document-list'),
                        ])
                        ->collapsible(false),
                    NavigationGroup::make('Management Surat Jalan')
                        ->items([
                            ...DeliveryNoteResource::getNavigationItems(),
                            NavigationItem::make('Buat Surat Jalan')
                                ->label('Buat Surat Jalan')
                                ->url(fn() => route('filament.admin.resources.Surat-Jalan.create'))
                                ->icon('heroicon-o-document-plus')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.Surat-Jalan.create')),
                        ]),
                    NavigationGroup::make('Management Pengguna')
                        ->items([
                            ...UserResource::getNavigationItems(),
                            ...OfficerResource::getNavigationItems(),
                            ...ClientResource::getNavigationItems(),
                        ]),
                ]);
            });
    }
}
