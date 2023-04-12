<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('orders')
                    ->required(),
                Forms\Components\TextInput::make('price_min')
                    ->required(),
                Forms\Components\TextInput::make('price_max')
                    ->required(),
                Forms\Components\Select::make('provider_id')
                    ->relationship('provider', 'name')
                    ->required(),
                Forms\Components\Textarea::make('advantages')
                    ->required(),
                Forms\Components\Textarea::make('warning')
                    ->required(),
                Forms\Components\Textarea::make('work_time')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\TextInput::make('prices')
                    ->required(),
                Forms\Components\TextInput::make('gifts')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('orders'),
                Tables\Columns\TextColumn::make('price_min'),
                Tables\Columns\TextColumn::make('price_max'),
                Tables\Columns\TextColumn::make('provider.name'),
                Tables\Columns\TextColumn::make('advantages'),
                Tables\Columns\TextColumn::make('warning'),
                Tables\Columns\TextColumn::make('work_time'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('prices')->getStateUsing(static function (\stdClass $rowLoop): string {
                    return (string) $rowLoop;
                }),
                Tables\Columns\TextColumn::make('gifts'),
                Tables\Columns\TextColumn::make('category.name'),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }    
}
