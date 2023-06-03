<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\RelationManagers\DataPmiRelationManager;
use App\Filament\Resources\TujuanResource\Pages;
use App\Filament\Resources\TujuanResource\RelationManagers;
use App\Models\Tujuan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TujuanResource extends Resource
{
    protected static ?string $model = Tujuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe';
    protected static ?string $navigationGroup = 'Module';
    protected static ?string $navigationLabel = 'NEGARA TUJUAN';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('negara_tujuan')
                    ->required()
                    ->rules('required')
                    ->placeholder('Input Negara Tujuan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('negara_tujuan')->sortable()->searchable()->label('NEGARA TUJUAN'),
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
            'index' => Pages\ListTujuans::route('/'),
            // 'create' => Pages\CreateTujuan::route('/create'),
            'edit' => Pages\EditTujuan::route('/{record}/edit'),
        ];
    }    
}
