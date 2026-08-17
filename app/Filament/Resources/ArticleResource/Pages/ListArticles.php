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
                    Forms\Components\Textarea::make('prompt')
                        ->label('Prompt')
                        ->required()
                        ->rows(6)
                        ->default(fn () => AiArticleSetting::current()->promptOrDefault())
                        ->helperText('Instruksi untuk AI tentang artikel yang diinginkan. Kategori dipilih secara acak dari seluruh kategori artikel yang ada dan menggantikan penanda "{kategori}".'),
                ])
                ->action(function (array $data, AiArticleGenerator $generator) {
                    $category = Category::query()->where('type', 'article')->inRandomOrder()->first();
                    $prompt = $category
                        ? str_replace('{kategori}', $category->name, $data['prompt'])
                        : $data['prompt'];

                    try {
                        $article = $generator->generate(
                            prompt: $prompt,
                            type: 'article',
                            locale: app()->getLocale(),
                            categoryId: $category?->id,
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
                        ->title('Artikel berhasil dipublikasikan')
                        ->body($article->title)
                        ->success()
                        ->send();

                    $this->redirect(ArticleResource::getUrl('edit', ['record' => $article]));
                }),
            Actions\CreateAction::make(),
        ];
    }
}
