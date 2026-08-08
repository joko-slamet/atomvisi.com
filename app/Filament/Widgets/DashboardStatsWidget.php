<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\ResearchProjectResource;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\TeamMemberResource;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\ResearchProject;
use App\Models\Service;
use App\Models\TeamMember;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $unreadMessages = ContactMessage::where('is_read', false)->count();

        return [
            Stat::make('Pesan Belum Dibaca', $unreadMessages)
                ->description($unreadMessages > 0 ? 'Perlu ditindaklanjuti' : 'Semua pesan sudah dibaca')
                ->descriptionIcon($unreadMessages > 0 ? 'heroicon-o-exclamation-circle' : 'heroicon-o-check-circle')
                ->color($unreadMessages > 0 ? 'warning' : 'success')
                ->url(ContactMessageResource::getUrl('index')),

            Stat::make('Artikel Dipublikasikan', Article::published()->count())
                ->description(Article::where('status', 'draft')->count().' draft menunggu')
                ->descriptionIcon('heroicon-o-newspaper')
                ->color('primary')
                ->url(ArticleResource::getUrl('index')),

            Stat::make('Riset Dipublikasikan', ResearchProject::published()->count())
                ->description(ResearchProject::count().' total proyek riset')
                ->descriptionIcon('heroicon-o-document-chart-bar')
                ->color('gold')
                ->url(ResearchProjectResource::getUrl('index')),

            Stat::make('Layanan Aktif', Service::active()->count())
                ->description(Service::count().' total layanan')
                ->descriptionIcon('heroicon-o-briefcase')
                ->color('primary')
                ->url(ServiceResource::getUrl('index')),

            Stat::make('Anggota Tim Aktif', TeamMember::active()->count())
                ->description(TeamMember::count().' total anggota')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('gold')
                ->url(TeamMemberResource::getUrl('index')),
        ];
    }
}
