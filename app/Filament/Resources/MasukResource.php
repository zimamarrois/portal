<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasukResource\Pages;
use App\Filament\Resources\MasukResource\RelationManagers;
use App\Models\Masuk;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasukResource extends Resource
{
    protected static ?string $model = Masuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationGroup = 'Akuntansi';
    protected static ?int $navigationSort = -2;
    protected static ?string $navigationLabel = 'MASUK';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Grid::make(2)
            ->schema([
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
                Select::make('buku_kas_id',)
                        ->relationship('BukuKas','nama')
                        ->required(),
                DatePicker::make('created_at'),
                FileUpload::make('nota')
                        ->disk('public')
                        ->directory('transaksi/nota_masuk')
                        ->preserveFilenames()
                        ->enableDownload()
                        ->enableOpen()
                        ->enableReordering()
                        ->loadingIndicatorPosition('right')
                        ->removeUploadedFileButtonPosition('right')
                        ->uploadButtonPosition('left')
                        ->uploadProgressIndicatorPosition('left'),
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('nama'),
                TextColumn::make('created_at')->date()->label('Di Buat Pada'),
                TextColumn::make('nominal')->money('idr',2),
                TextColumn::make('keterangan'),
                TextColumn::make('BukuKas.nama')
                                ->sortable()
                                ->searchable()
                                ->alignment('left'),
                ImageColumn::make('nota')->circular(),

                // TextColumn::make('created_at')->date(),
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
            'index' => Pages\ListMasuks::route('/'),
            // 'create' => Pages\CreateMasuk::route('/create'),
            // 'edit' => Pages\EditMasuk::route('/{record}/edit'),
        ];
    }    
}
