<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\AiArticleSetting;
use App\Models\Category;
use App\Services\AiArticleGenerator;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Throwable;

class ListArticles extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\Action::make('generateWithAi')
                ->label('Generate dengan AI')
                ->icon('heroicon-o-sparkles')
                ->color('gray')
                ->form([
                    Forms\Components\Textarea::make('topic')
                        ->label('Topik / Judul yang diinginkan')
                        ->required()
                        ->rows(2)
                        ->helperText('Jelaskan topik artikel, semakin spesifik semakin baik hasilnya.'),
                    Forms\Components\Select::make('type')
                        ->label('Jenis')
                        ->options([
                            'article' => 'Artikel / Blog',
                            'op-ed' => 'Op-Ed',
                            'newsletter' => 'Newsletter',
                        ])
                        ->default(fn () => AiArticleSetting::current()->type ?? 'article')
                        ->required()
                        ->native(false),
                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->options(fn () => Category::query()->get()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->default(fn () => AiArticleSetting::current()->category_id),
                ])
                ->action(function (array $data, AiArticleGenerator $generator) {
                    try {
                        $article = $generator->generate(
                            topic: $data['topic'],
                            type: $data['type'],
                            locale: app()->getLocale(),
                            categoryId: $data['category_id'] ?? null,
                        );
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Gagal generate artikel')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->title('Draft artikel berhasil dibuat')
                        ->body($article->title)
                        ->success()
                        ->send();

                    $this->redirect(ArticleResource::getUrl('edit', ['record' => $article]));
                }),
            Actions\CreateAction::make(),
        ];
    }
}
