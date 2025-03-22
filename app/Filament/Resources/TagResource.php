<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use App\Traits\ColorLabelTranslator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TagResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagResource\RelationManagers;

class TagResource extends Resource
{
    use ColorLabelTranslator;

    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $modelLabel = 'Etiketi';

    protected static ?string $pluralModelLabel = 'Etiketler';

    protected static ?string $navigationGroup = 'Site Yönetimi';

    public static function canAccess(): bool
    {

        if (Auth::check()) {
            /**
             * @var User $user
             */
            $user = Auth::user();
            return $user->canDoCriticalAction();
        }

        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Etiket Adı')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, callable $set) {
                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->hidden()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('color')
                            ->label('Renk')
                            ->options(function () {
                                $colors = static::getColors();
                                $formattedColors = [];

                                foreach ($colors as $value => $label) {
                                    $formattedColors[$value] = '<div class="flex items-center gap-2">
                                        <span class="w-4 h-4 rounded-full" style="background:' . match ($value) {
                                        'amber' => '#f59e0b',
                                        'sky' => '#0ea5e9',
                                        'emerald' => '#10b981',
                                        'stone' => '#78716c',
                                        'zinc' => '#71717a',
                                        'rose' => '#f43f5e',
                                        'neutral' => '#737373',
                                        'slate' => '#64748b',
                                        default => $value,
                                    } . ';"></span>
                                        <span>' . $label . '</span>
                                    </div>';
                                }

                                return $formattedColors;
                            })
                            ->allowHtml()
                            ->native(false)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Etiket Adı')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('color')
                    ->label('Renk')
                    ->formatStateUsing(function ($state) {
                        $colorHex = match ($state) {
                            'amber' => '#f59e0b',
                            'sky' => '#0ea5e9',
                            'emerald' => '#10b981',
                            'stone' => '#78716c',
                            'zinc' => '#71717a',
                            'rose' => '#f43f5e',
                            'neutral' => '#737373',
                            'slate' => '#64748b',
                            default => $state,
                        };
                        return '<div class="flex">
                            <span class="w-6 h-6 rounded-full" style="background:' . $colorHex . ';"></span>
                        </div>';
                    })
                    ->html()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Konu Sayısı')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('d M h:i, Y'))
                    ->alignCenter(),
            ])
            ->filters([
                Filter::make('Konusu Olmayan')->query(
                    function ($query) {
                        return $query->whereDoesntHave('posts');
                    }
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Düzenle'),
                Tables\Actions\DeleteAction::make()
                    ->label('Sil'),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withCount('posts'));
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
