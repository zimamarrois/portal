<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\RelationManagers\DataPmiRelationManager;
use App\Filament\Resources\StatusUpdateResource\Pages;
use App\Filament\Resources\StatusUpdateResource\RelationManagers;
use App\Models\StatusUpdate;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusUpdateResource extends Resource
{
    protected static ?string $model = StatusUpdate::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up';
    protected static ?string $navigationGroup = 'Module';
    protected static ?string $navigationLabel = 'STATUS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('status_update')
                    ->required()
                    ->rules('required')
                    ->placeholder('Input Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('status_update')->sortable()->searchable()->label('STATUS'),
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
            DataPmiRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStatusUpdates::route('/'),
            // 'create' => Pages\CreateStatusUpdate::route('/create'),
            'edit' => Pages\EditStatusUpdate::route('/{record}/edit'),
        ];
    }    
}
