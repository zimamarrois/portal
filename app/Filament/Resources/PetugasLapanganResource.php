<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\RelationManagers\DataPmiRelationManager;
use App\Filament\Resources\PetugasLapanganResource\Pages;
use App\Filament\Resources\PetugasLapanganResource\RelationManagers;
use App\Models\PetugasLapangan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetugasLapanganResource extends Resource
{
    protected static ?string $model = PetugasLapangan::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?string $navigationGroup = 'Module';
    protected static ?string $navigationLabel = 'SPONSOR PL';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('petugas_lapangan')
                    ->required()
                    ->rules('required')
                    ->unique()
                    ->placeholder('Input Petugas Lapangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('petugas_lapangan')->sortable()->searchable()->label('SPONSOR PL'),
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
            'index' => Pages\ListPetugasLapangans::route('/'),
            // 'create' => Pages\CreatePetugasLapangan::route('/create'),
            // 'edit' => Pages\EditPetugasLapangan::route('/{record}/edit'),
        ];
    }    
}
