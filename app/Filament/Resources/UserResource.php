<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Role;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\UserResource\Pages;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Notification as LaravelNotification;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Kullanıcı';

    protected static ?string $pluralModelLabel = 'Kullanıcılar';

    protected static ?string $navigationGroup = 'Site Yönetimi';

    public static function canCreate(): bool
    {
        return false;
    }

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
                Forms\Components\Section::make('Hesap Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Ad Soyad')
                            ->required()
                            ->maxLength(30),

                        Forms\Components\TextInput::make('username')
                            ->label('Kullanıcı Adı')
                            ->required()
                            ->maxLength(16)
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true),

                        Forms\Components\TextInput::make('email')
                            ->label('E-Posta')
                            ->required()
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true),
                    ])->columnSpan(1),
                Forms\Components\Section::make('Yetkiler')
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->multiple()
                            ->label('Rozetler')
                            ->placeholder('Eklenecek rozetleri seçin')
                            ->relationship('roles', 'name')
                            ->options(function ($record) {
                                /**
                                 * @var User $user
                                 */
                                $user = Auth::user();

                                // Check if user has god-level permissions using the canBeAGod method
                                if ($user->canBeAGod()) {
                                    // If user has god level, return all roles
                                    return Role::orderBy('level')->pluck('name', 'id')->toArray();
                                }

                                // Get user's highest role level
                                $userMaxLevel = $user->roles->max('level') ?? 0;

                                // Only show roles with level less than or equal to current user's max level
                                return Role::orderBy('level')->where('level', '<', $userMaxLevel)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->required(),
                    ])->columnSpan(1),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('username')
                    ->label('Kullanıcı Adı')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-Posta')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rozetler')
                    ->badge()
                    ->alignCenter()
                    ->color(
                        fn($state, $record) =>
                        $record->roles->firstWhere('name', $state)->color
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kayıt Tarihi')
                    ->sortable()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('d M h:i, Y'))
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_banned')
                    ->label('Yasaklı Hesap')
                    ->boolean()
                    ->color(fn($state) => $state ? 'danger' : 'success')
                    ->trueIcon('heroicon-o-shield-exclamation')
                    ->falseIcon('heroicon-o-shield-check')
                    ->alignCenter(),
            ])
            ->filters([
                Filter::make('Onaylı Hesaplar')->query(
                    function ($query) {
                        return $query->where('email_verified_at', '!=', null);
                    }
                ),
                Filter::make('Yasaklı Hesaplar')
                    ->query(fn(Builder $query): Builder => $query->where('is_banned', true))
                    ->label('Yasaklı Hesaplar'),
                SelectFilter::make('roles')
                    ->multiple()
                    ->options(Role::pluck('name', 'id')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['values'])) {
                            return $query;
                        }

                        foreach ($data['values'] as $roleId) {
                            $query->whereHas('roles', function (Builder $query) use ($roleId) {
                                $query->where('roles.id', $roleId);
                            });
                        }

                        return $query;
                    })
                    ->label('Rozetler')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->label('Düzenle'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->label('Sil'),
                Tables\Actions\Action::make('ban')
                    ->label('Yasakla')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('danger')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        /**
                         * @var User $user
                         */
                        $user = Auth::user();
                        if (! $user->can('ban', $record)) {
                            return;
                        }

                        $record->is_banned = true;
                        $record->save();

                        Notification::make()
                            ->title($record->name . ' kullanıcısı yasaklandı')
                            ->success()
                            ->send();
                    })
                    ->visible(function (User $record): bool {
                        /**
                         * @var User $user
                         */
                        $user = Auth::user();
                        return ! $record->is_banned && $user->can('ban', $record);
                    }),
                Tables\Actions\Action::make('unban')
                    ->label('Yasağı Kaldır')
                    ->icon('heroicon-o-shield-check')
                    ->color('success')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        /**
                         * @var User $user
                         */
                        $user = Auth::user();
                        if (! $user->can('ban', $record)) {
                            return;
                        }

                        $record->is_banned = false;
                        $record->save();

                        Notification::make()
                            ->title($record->name . ' kullanıcısının yasağı kaldırıldı')
                            ->success()
                            ->send();
                    })
                    ->visible(function (User $record): bool {
                        /**
                         * @var User $user
                         */
                        $user = Auth::user();
                        return $record->is_banned && $user->can('ban', $record);
                    }),
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
