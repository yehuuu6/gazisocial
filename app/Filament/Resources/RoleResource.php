<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Role;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Log;
use App\Traits\ColorLabelTranslator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoleResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class RoleResource extends Resource
{
    use ColorLabelTranslator;

    protected static ?string $model = Role::class;

    protected static ?string $modelLabel = 'Rozet';

    protected static ?string $pluralModelLabel = 'Rozetler';

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

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
                Forms\Components\Section::make('Genel')
                    ->description('Rozetin forumda kullanıcılara nasıl görüneceğini belirleyin.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Rozet Adı')
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
                    ])->columnSpan(1),
                Forms\Components\Section::make('İzinler')
                    ->description('Dikkatli kullanın, yanlış izinler vermek sisteminizin güvenliğini tehlikeye atabilir.')
                    ->schema([
                        Forms\Components\Select::make('level')
                            ->placeholder('Yeni yetki seviyesi seçin')
                            ->label('Güç Seviyesi - Güç Zehirlenmesi Olasılığı')
                            ->options(function () {
                                // Get the authenticated user
                                /**
                                 * @var \App\Models\User $user
                                 */
                                $user = Auth::user();

                                // Get the user's highest role level
                                $maxLevel = $user->roles()->max('level') ?? 3;

                                if ($user->canBeAGod()) {
                                    $maxLevel = 4;
                                }

                                // Generate options from 0 to the user's maximum level
                                $options = [];
                                for ($i = 0; $i < $maxLevel; $i++) {
                                    $options[$i] = (string) $i . ' - ' . static::getLevelText($i);
                                }

                                return $options;
                            })
                            ->native(false)
                            ->required(),
                    ])->columnSpan(1),
            ])->columns(2);
    }

    public static function getLevelText(int $level): string
    {
        return match ($level) {
            0 => 'Güvenli',
            1 => 'Riskli',
            2 => 'Tehlikeli',
            3 => 'Kritik',
            default => 'Güvenli',
        };
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Rozet Adı')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                Tables\Columns\TextColumn::make('level')
                    ->label('Güç Zehirlenmesi Olasılığı')
                    ->sortable(query: function (Builder $query, $direction) {
                        $query->orderBy('level', $direction)
                            ->orderBy('id', $direction);
                    })
                    ->badge()
                    ->color(function (int $state): string {
                        return match ($state) {
                            0 => 'green',
                            1 => 'yellow',
                            2 => 'orange',
                            3 => 'red',
                        };
                    })
                    ->formatStateUsing(fn(int $state) => static::getLevelText($state))
                    ->toggleable()
                    ->alignCenter(),

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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('d M h:i, Y'))
                    ->alignCenter(),
            ])
            ->defaultSort(fn($query) => $query->orderBy('level', 'desc')->orderBy('id', 'desc'))
            ->filters([
                SelectFilter::make('level')
                    ->label('Güç Zehirlenmesi Olasılığı')
                    ->native(false)
                    ->options([
                        0 => 'Güvenli',
                        1 => 'Riskli',
                        2 => 'Tehlikeli',
                        3 => 'Kritik',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ]);
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
            'index' => Pages\ListRoles::route('/'),
        ];
    }
}
