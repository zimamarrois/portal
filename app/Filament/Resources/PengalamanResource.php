<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\RelationManagers\DataPmiRelationManager;
use App\Filament\Resources\PengalamanResource\Pages;
use App\Filament\Resources\PengalamanResource\RelationManagers;
use App\Models\Pengalaman;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengalamanResource extends Resource
{
    protected static ?string $model = Pengalaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Module';
    protected static ?string $navigationLabel = 'PENGALAMAN';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pengalaman')
                    ->required()
                    ->rules('required')
                    ->placeholder('Input Pengalaman Pmi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('pengalaman')->sortable()->searchable()->label('PENGALAMAN'),
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
            'index' => Pages\ListPengalamen::route('/'),
            // 'create' => Pages\CreatePengalaman::route('/create'),
            // 'edit' => Pages\EditPengalaman::route('/{record}/edit'),
        ];
    }    
}
