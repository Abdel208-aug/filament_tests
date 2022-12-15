<?php

namespace App\Filament\Resources;

use Squire\Models\Country;
use Filament\Tables;
use App\Models\Organization;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers\ContactsRelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required()->unique(
                    ignorable: fn(null|Model $record) : null|Model => $record,
                ),
                TextInput::make('phone')->tel()->required(),
                TextInput::make('address')->required(),
                TextInput::make('city')->required(),
                TextInput::make('region')->required(),
                Select::make('country')
                        ->options(Country::query()->pluck('name','code_2'))
                        ->searchable()
                        ->required(),
                TextInput::make('postal_code')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('address')->searchable(),
                TextColumn::make('city')->searchable()->sortable(),
                TextColumn::make('region')->searchable()->sortable(),
                TextColumn::make('country')->searchable(),
                TextColumn::make('postal_code')->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('deleted_at')
                            ->label('Organization supprimé')
                            ->options([
                                'with-trashed' => 'With Trashed',
                                'only-trashed' => 'Only Trashed',
                            ])
                            ->query(function (Builder $query, array $data){
                                $query->when($data['value']==='with-trashed',function (Builder $query)
                                {
                                    $query->withTrashed();
                                })->when($data['value']==='only-trashed',function(Builder $query)
                                {
                                    $query->onlyTrashed();
                                });
                            })
            ])
            ->headerActions([
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
            ContactsRelationManager::class
        ];
    }
    public static function getEloquentQuery():Builder
    {
        return parent::getEloquentQuery()->account();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }    
}