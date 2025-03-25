<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Comment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CommentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CommentResource\RelationManagers;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $modelLabel = 'Yorum';

    protected static ?string $pluralModelLabel = 'Yorumlar';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Show the gif field if not null
                Forms\Components\ViewField::make('gif_url')
                    ->visible(fn($record) => $record->gif_url !== null)
                    ->label('GIF')
                    ->view('filament.forms.components.gif-viewer')
                    ->columnSpan(2),
                Forms\Components\Textarea::make('content')
                    ->hiddenLabel()
                    ->required()
                    ->rows(10)
                    ->cols(30)
                    ->visible(fn($record) => $record->gif_url === null)
                    ->maxWidth('full')
                    ->maxLength(1000)
                    ->columnSpan(2),
                Forms\Components\Section::make()
                    ->description('Raporu gerekirse kaldırabilirsiniz.')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Yazar')
                            ->relationship('user', 'name')
                            ->required()
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_reported')
                            ->label('Rapor Edildi')
                            ->columnSpanFull(),
                    ])->columnSpan(1)->columns(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.username')
                    ->searchable()
                    ->label('Yazar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->limit(30)
                    ->label('Konu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->limit(30)
                    ->label('İçerik')
                    ->placeholder('GIF')
                    ->searchable(),
                IconColumn::make('is_reported')
                    ->label('Rapor Durumu')
                    ->icon(fn(string $state): string => $state ? 'heroicon-o-flag' : 'heroicon-o-minus')
                    ->color(fn(string $state): string => $state ? 'red' : 'green')
                    ->toggleable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->sortable()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('d M h:i, Y'))
                    ->alignCenter(),
            ])
            ->filters([
                Filter::make('Rapor Edilenler')->query(
                    function ($query) {
                        return $query->where('is_reported', true);
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->url(fn(Comment $comment) => $comment->showRoute())
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->extraModalFooterActions([
                        Tables\Actions\DeleteAction::make(),
                    ]),
            ])->modifyQueryUsing(fn(Builder $query) => $query->with('user'));
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
            'index' => Pages\ListComments::route('/'),
        ];
    }
}
