<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuKasResource\Pages;
use App\Filament\Resources\BukuKasResource\RelationManagers;
use App\Filament\Resources\BukuKasResource\RelationManagers\KeluarRelationManager;
use App\Filament\Resources\BukuKasResource\RelationManagers\MasukRelationManager;
use App\Models\BukuKas;
use App\Models\Keluar;
use App\Models\Masuk;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BukuKasResource extends Resource
{
    protected static ?string $model = BukuKas::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';
    protected static ?string $navigationGroup = 'Akuntansi';
    protected static ?int $navigationSort = -3;
    protected static ?string $navigationLabel = 'BUKU KAS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama'),
                TextInput::make('nominal')
                ->numeric()
                ->mask(fn (TextInput\Mask $mask) => $mask
                    ->numeric()
                    ->decimalPlaces(2) // Set the number of digits after the decimal point.
                    ->decimalSeparator(',') // Add a separator for decimal numbers.
                    ->integer() // Disallow decimal numbers.
                    ->mapToDecimalSeparator([';-']) // Map additional characters to the decimal separator.
                    //->minValue(1) // Set the minimum value that the number can be.
                    // ->maxValue(100) // Set the maximum value that the number can be.
                    ->normalizeZeros() // Append or remove zeros at the end of the number.
                    ->padFractionalZeros() // Pad zeros at the end of the number to always maintain the maximum number of decimal places.
                    ->thousandsSeparator('.'), // Add a separator for thousands.
                        ),
                TextInput::make('keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->date()->label('Di Buat Pada'),
                TextColumn::make('nama'),
                TextColumn::make('nominal')->money('idr',2),
                TextColumn::make('keterangan'),
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
            MasukRelationManager::class,
            KeluarRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBukuKas::route('/'),
            // 'create' => Pages\CreateBukuKas::route('/create'),
            'edit' => Pages\EditBukuKas::route('/{record}/edit'),
        ];
    }    
    public function Masuk()
    {
        return $this->HasMany(Masuk::class);
        return $this->belongsTo(Masuk::class);
        
    }
    public function Keluar()
    {
        return $this->HasMany(Keluar::class);
        return $this->belongsTo(Masuk::class);
    }
}
