<?php

namespace App\Filament\Resources;

use Psy\Util\Str;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                FileUpload::make('photo_path')
                ->avatar()
                ->columnSpanFull(),
                Select::make('account_id')
                    ->relationship('account', 'name')
                    ->required()
                    ->searchable(),
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(25),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(25),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(50),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(static fn (null|string $state) : null|string =>
                        filled($state) ? Hash::make($state) : null,
                    )
                    ->required(static fn (Page $livewire) : bool=>
                        $livewire instanceof CreateUser,
                    )
                    ->dehydrated(static fn (null|string $state) : bool =>
                        filled($state),
                    )
                    ->label(static fn (Page $livewire) : string=>
                        ($livewire instanceof EditUser) ? 'New Password' : 'Password',
                    )
                    ->maxLength(190),
                Toggle::make('owner')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')->label('Photo')->rounded(),
                TextColumn::make('account.name'),
                TextColumn::make('first_name'),
                TextColumn::make('last_name'),
                TextColumn::make('email'),
                TextColumn::make('email_verified_at')
                    ->dateTime(),
                IconColumn::make('owner')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
