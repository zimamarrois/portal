<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgencyResource\Pages;
use App\Filament\Resources\AgencyResource\RelationManagers;
use App\Filament\Resources\PendaftaranResource\RelationManagers\DataPmiRelationManager;
use App\Models\Agency;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static ?string $navigationIcon = 'heroicon-s-presentation-chart-line';
    protected static ?string $navigationGroup = 'Module';
    protected static ?string $navigationLabel = 'AGENCY';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('agency')
                    ->required()
                    ->rules('required')
                    ->placeholder('Input Agency')
                    ->label('Nama Agency'),
                
                Select::make('tujuan_id',)
                    ->relationship('Tujuan','negara_tujuan')
                    ->required()
                    ->placeholder('Pilih Negara')
                    ->label('Pilih Negara'),
            ]);

                
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('agency')->sortable()->searchable()->label('AGENCY'),
                TextColumn::make('Tujuan.negara_tujuan')->sortable()->searchable()->label('NEGARA'),
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
            'index' => Pages\ListAgencies::route('/'),
            // 'create' => Pages\CreateAgency::route('/create'),
            'edit' => Pages\EditAgency::route('/{record}/edit'),
        ];
    }    
}
