<?php

namespace App\Filament\Resources;


use App\Filament\Resources\PendaftaranResource\Pages;
use App\Filament\Resources\PendaftaranResource\RelationManagers;
use App\Filament\Resources\PendaftaranResource\RelationManagers\DataPmiRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\AgencyRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\KantorRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\MarketingRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\PengalamanRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\PetugasLapanganRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\StatusUpdateRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\TujuanRelationManager;
use App\Filament\Resources\PendaftaranResource\Widgets\PendaftaranStatsOverview;
use App\Models\DataPmi;
use App\Models\Pendaftaran;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\DataPmiResource\Widgets\DataPmiStatsOverview;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ToggleColumn;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Filters\Filter;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ImageColumn;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationLabel = 'PENDAFTARAN';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';
    // protected static ?string $activeNavigationIcon = 'heroicon-o-view-grid';
    protected static ?string $navigationGroup = 'CPMI';
    protected static ?int $navigationSort = -4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('VERIVIKASI DOKUMEN')
                ->description('Silahkan Centang Pilihan')
                ->icon('heroicon-o-check-circle') 
                ->schema([
                Grid::make(2)
                ->schema([
                    Toggle::make('data_lengkap')
                    ->inline(true),
                    // ->label('Data Lengkap (Centang Jika Data Sudah Lengkap)'),
    
                    Toggle::make('proses')->label('Proses Data PMI')
                    ->inline(true)
                        ])

                ])->columns(2)->collapsible(false),


                Section::make('DATA PENDAFTARAN')
                ->description('Silahkan Input Data Pendaftar')
                ->icon('heroicon-o-pencil-alt') 
                ->schema([
                    Grid::make(2)
                            ->schema([
                            Select::make('kantor_id',)
                            ->relationship('Kantor','kantor')
                            ->required()
                            ->placeholder('Pilih Kantor Cabang')
                            ->label('Kantor Cabang'),
    
                            Select::make('petugas_lapangan_id',)
                            ->relationship('PetugasLapangan','petugas_lapangan')
                            ->placeholder('Pilih SPONSOR PL')
                            ->label('SPONSOR PL')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nama')->unique()
                            ]),
                            ]),
    
                            
                            Grid::make(3)
                            ->schema([
                            TextInput::make('nama')
                            ->rules('required')
                            ->placeholder('Masukan Nama Lengkap')
                            ->label('Nama CPMI'),
    
                            TextInput::make('nomor_ktp')
                            ->label('Nomor E-KTP')
                            ->rules('required')
                            ->placeholder('Masukan 16 Digit No KTP')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->numeric()
                            ->minLength(5)
                            ->maxLength(17),
    
                            TextInput::make('nomor_kk')
                            ->label('Nomor KK')
                            ->placeholder('Masukan 16 Digit No KK')
                            ->numeric()
                            ->minLength(5)
                            ->maxLength(17),
                            ]),

                            
                            Grid::make(2)
                            ->schema([
                            TextInput::make('alamat')
                            ->placeholder('Masukan Alamat')
                            ->label('Alamat'),
    
                            TextInput::make('rtrw')->mask(fn (TextInput\Mask $mask) => $mask->pattern('000/000'))
                            ->placeholder('Masukan RT / RW')
                            ->label('RT / RW')
                            ->numeric()
                            ->minLength(1)
                            ->maxLength(7),
    
                            ]),
    
                            //----------------------------------------
    
                            Grid::make(3)
                            ->schema([
                            Select::make('province_id')
                                ->label('Provinsi')
                                ->options(Province::all()->pluck('name','id')->toArray())
                                ->reactive()
                                ->afterStateUpdated(fn(callable $set) => $set('regency_id', null))
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih Provinsi'),  
    
                            Select::make('regency_id')
                                ->label('Kabupaten / Kota')
                                ->options(function (callable $get) {
                                    $province = Province::find($get('province_id'));
                                    if (!$province) {
                                        return Regency::pluck('name','id');
                                    }
                                    return $province->regencies->pluck('name','id');
    
                                })
                                ->reactive()
                                ->afterStateUpdated(fn(callable $set) => $set('district_id', null))
                                ->searchable()
                                ->preload()
                                ->optionsLimit(3)
                                ->placeholder('Cari Kabupaten / Kota'),
    
                            Select::make('district_id')
                                ->label('Kecamatan')
                                ->options(function (callable $get) {
                                    $regencies = Regency::find($get('regency_id'));
                                    if (!$regencies) {
                                        return District::pluck('name','id');
                                    }
                                    return $regencies->districts->pluck('name','id');
    
                                })
                                ->reactive()
                                ->afterStateUpdated(fn(callable $set) => $set('village_id', null))
                                ->searchable()
                                ->preload()
                                ->optionsLimit(3)
                                ->placeholder('Cari Kecamatan'),
    
                            //------------------------

                            // Select::make('village_id')
                            //     ->label('Kelurahan')
                            //     ->options(function (callable $get) {
                            //         $districts = District::find($get('regencies_id'));
                            //         if (!$districts) {
                            //             return Village::pluck('name','id');
                                        
                            //         }
                            //         return $districts->villages->pluck('name','id');
    
                            //     })
                            //     ->reactive()
                            //     ->afterStateUpdated(fn(callable $set) => $set('villages_id', null))
                            //     ->searchable()
                            //     ->preload()
                            //     ->optionsLimit(3)
                            //     ->placeholder('Cari Kelurahan / Desa'),
    
                            ]),
    
                            //----------------------------------------
                
                            
                            Grid::make(3)
                            ->schema([
                            TextInput::make('nama_wali')
                            ->placeholder('Masukan Nama Wali / Keluarga')
                            ->label('Nama Wali'),
    
                            TextInput::make('nomor_telp')
                            ->label('Nomor Telp CPMI')
                            ->placeholder('Contoh. 081xxxx')
                            ->numeric()
                            ->minLength(6)
                            ->maxLength(12),
                            
                            TextInput::make('nomor_telp_wali')
                            ->label('Nomor Telp Wali')
                            ->placeholder('Contoh. 081xxxx')
                            ->numeric()
                            ->columnSpan([
                                '2xl'])
                            ->minLength(6)
                            ->maxLength(12),
                                ]),
                ])->columns(2)->collapsed(),

                Section::make('UPLOAD DOKUMEN')
                ->description('Silahkan Upload Data Pendaftar')
                ->icon('heroicon-o-upload') 
                ->schema([

                    // Grid::make(3)
                    //         ->schema([
                            FileUpload::make('file_ktp')->label('Upload KTP')
                            ->disk('public')
                            ->directory('pendaftaran/file_ktp')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                
                            FileUpload::make('file_ktp_wali')->label('Upload KTP Wali')
                            ->disk('public')
                            ->directory('pendaftaran/file_ktp_wali')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                
                            FileUpload::make('file_kk')->label('Upload KK')
                            ->disk('public')
                            ->directory('pendaftaran/file_kk')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                
                            FileUpload::make('file_akta_lahir')->label('Upload Akta Lahir')
                            ->disk('public')
                            ->directory('pendaftaran/file_akta_lahir')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                
                            FileUpload::make('file_surat_nikah')->label('Upload Surat Nikah')
                            ->disk('public')
                            ->directory('pendaftaran/file_surat_nikah')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                
                            FileUpload::make('file_surat_ijin')->label('Upload Surat Ijin')
                            ->disk('public')
                            ->directory('pendaftaran/file_surat_ijin')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                
                            FileUpload::make('file_ijazah')->label('Upload Ijazah')
                            ->disk('public')
                            ->directory('pendaftaran/file_ijazah')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                
                            FileUpload::make('file_tambahan')->label('Upload File Tambahan')
                            ->disk('public')
                            ->directory('pendaftaran/file_tambahan')
                            ->preserveFilenames()
                            ->enableDownload()
                            ->enableOpen()
                            ->enableReordering()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                        // ]),
                ])->columns(2)->collapsed(),

                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Stack::make([
                        TextColumn::make('nama')
                            // ->sortable()
                            ->searchable()
                            ->alignment('left')
                            ->label('Nama CPMI'),
                        TextColumn::make('nomor_ktp')
                            // ->sortable()
                            ->searchable()
                            ->alignment('left')
                            ->label('Nomor E-KTP')
                            ->icon('heroicon-o-clipboard-check')
                            ->color('success'),
                ]),
                
                        // TextColumn::make('pendaftaran_id.nama')
                        //     // ->sortable()
                        //     // ->searchable()
                        //     ->alignment('left')
                        //     ->label('Data PMI'),
                            
                        TextColumn::make('Kantor.kantor')
                            // ->sortable()
                            // ->searchable()
                            ->alignment('left')
                            ->label('Kantor Cabang'),

                        TextColumn::make('PetugasLapangan.petugas_lapangan')
                            // ->sortable()
                            // ->searchable()
                            ->alignment('left')
                            ->label('SPONSOR PL'),
                            
                        
                        
                        // ImageColumn::make('file_ktp')
                        //     ->grow(true)
                        //     ->sortable()
                        //     ->searchable()
                        //     ->alignment('left')
                        //     ->label('Foto'),
    
                        IconColumn::make('data_lengkap')
                            ->sortable()
                            ->boolean('data_lengkap')
                            ->trueIcon('heroicon-o-badge-check')
                            ->falseIcon('heroicon-o-x-circle')->alignment('right')
                            ->label('Data Lengkap'),
                            IconColumn::make('proses')
                            ->trueIcon('heroicon-o-refresh')
                            ->falseIcon('heroicon-o-x-circle')->alignment('right')
                            ->alignment('right')
                            ->sortable()
                ]),
                Split::make([
                    Stack::make([
                        
                            TextColumn::make('alamat')
                            ->alignment('right')
                            ->label('Alamat')
                            ->icon('heroicon-s-home'),
                            TextColumn::make('rtrw')
                            ->alignment('right')
                            ->label('RT/RW'),
                            TextColumn::make('District.name')
                            ->alignment('right')
                            ->label('Kecamatan'),
                            TextColumn::make('Regency.name')
                            ->alignment('right')
                            ->label('Kabupaten / Kota'),
                            TextColumn::make('Province.name')
                            ->alignment('right')
                            ->label('Provinsi'),
    
                            //----------------------------------------------------------------
                            
                            TextColumn::make('nomor_kk')
                            // ->sortable()
                            ->searchable()
                            ->alignment('right')
                            ->label('Nomor KK')
                            ->icon('heroicon-s-paper-clip'),
                            TextColumn::make('nama_wali')
                            // ->sortable()
                            ->searchable()
                            ->alignment('right')
                            ->label('Nama Wali')
                            ->icon('heroicon-s-users'),
                            TextColumn::make('nomor_telp')
                            // ->sortable()
                            ->searchable()
                            ->alignment('right')
                            ->label('Nomor Telp CPMI')
                            ->icon('heroicon-s-phone'),
                            TextColumn::make('nomor_telp_wali')
                            // ->sortable()
                            ->searchable()
                            ->alignment('right')
                            ->label('Nomor Telp Wali')
                            ->icon('heroicon-o-phone'),
                        TextColumn::make('created_at')->date()
                            ->sortable(query: function (Builder $query, string $direction): Builder {
                            return $query->orderBy('created_at', $direction);})
                            ->alignment('right')
                            ->label('Tanggal Daftar')
                            ->icon('heroicon-o-clipboard-check'),
                        
                    ])])->collapsible()
                
            ])
            

            ->filters([
                Filter::make('created_at')
                        ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Di Buat'),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai'),
                                ])
                        ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),)
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),);
                                }),
                SelectFilter::make('Kantor')->relationship('Kantor', 'kantor'),
                TernaryFilter::make('data_lengkap'),
                TernaryFilter::make('proses')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export')
                 ->fileName('My File') // Default file name
                 ->timeFormat('m y d') // Default time format for naming exports
                 ->defaultFormat('pdf') // xlsx, csv or pdf
                 ->defaultPageOrientation('landscape') // Page orientation for pdf files. portrait or landscape
                 ->disableAdditionalColumns() // Disable additional columns input
                //  ->disableFilterColumns() // Disable filter columns input
                 ->disableFileName() // Disable file name input
                 ->disableFileNamePrefix() // Disable file name prefix
                //  ->disablePreview() // Disable export preview
                 ->fileNameFieldLabel('File Name') // Label for file name input
                 ->formatFieldLabel('Format') // Label for format input
                 ->pageOrientationFieldLabel('Page Orientation') // Label for page orientation input
                 ->filterColumnsFieldLabel('filter columns') // Label for filter columns input
                 ->additionalColumnsFieldLabel('Additional Columns') // Label for additional columns input
                 ->additionalColumnsTitleFieldLabel('Title') // Label for additional columns' title input
                 ->additionalColumnsDefaultValueFieldLabel('Default Value') // Label for additional columns' default value input
                 ->additionalColumnsAddButtonLabel('Add Column'), // Label for additional columns' add button
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            DataPmiRelationManager::class,
            // TujuanRelationManager::class,
            // AgencyRelationManager::class,
            // KantorRelationManager::class,
            // MarketingRelationManager::class,
            // PengalamanRelationManager::class,
            // PetugasLapanganRelationManager::class,
            // StatusUpdateRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftarans::route('/'),
           'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    } 

    public static function getWidgets(): array
    {
        return [
            PendaftaranStatsOverview::class,
        ];
    }
    

    public function DataPmi()
    {
        return $this->belongsTo(DataPmi::class);    
    }
    public function Pendaftaran()
    {
        return $this->HasMany(DataPmi::class);
    }  
    public function Provencies()
    {
        return $this->HasMany(Provencies::class);
    }  
}   
