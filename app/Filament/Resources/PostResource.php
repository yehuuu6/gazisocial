<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Konu';

    protected static ?string $pluralModelLabel = 'Konular';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Yazar')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->limit(50)
                    ->sortable(),

                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Etiketler')
                    ->badge()
                    ->color(
                        fn($state, $record) =>
                        $record->tags->contains('name', $state)
                            ? $record->tags->firstWhere('name', $state)->color
                            : 'gray'
                    )
                    ->separator(','),

                IconColumn::make('is_anonim')
                    ->label('Anonim')
                    ->icon(fn(string $state): string => $state ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('polls_count')
                    ->label('Anket Sayısı')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->sortable()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('d M h:i, Y'))
                    ->alignCenter(),
            ])
            ->filters([
                Filter::make('Anonim')->query(
                    function ($query) {
                        return $query->where('is_anonim', true);
                    }
                ),
                SelectFilter::make('user_id')
                    ->label('Yazar')
                    ->native(false)
                    ->placeholder('Yazar seçin')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return \App\Models\User::where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%")
                            ->orWhere('username', 'like', "%$search%")
                            ->limit(10)
                            ->get()
                            ->mapWithKeys(fn($user) => [$user->id => $user->name . ' (' . $user->username . ')'])
                            ->toArray();
                    })
                    ->options(fn() => \App\Models\User::limit(30)->pluck('name', 'id')->toArray()),
                SelectFilter::make('tags')
                    ->label('Etiketler')
                    ->multiple()
                    ->options(Tag::pluck('name', 'id')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['values'])) {
                            return $query;
                        }

                        foreach ($data['values'] as $tagId) {
                            $query->whereHas('tags', function (Builder $query) use ($tagId) {
                                $query->where('tags.id', $tagId);
                            });
                        }

                        return $query;
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Görüntüle')
                    ->url(fn($record) => $record->showRoute())
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()
                    ->url(fn($record) => route('posts.edit', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make()
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->with('user')->withCount('polls'));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
        ];
    }
}
