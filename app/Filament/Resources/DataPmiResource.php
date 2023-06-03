<?php



namespace App\Filament\Resources;



use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

use App\Filament\Resources\DataPmiResource\Pages;
use App\Filament\Resources\DataPmiResource\RelationManagers\AgencyRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\KantorRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\MarketingRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\PendaftaranRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\PengalamanRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\PetugasLapanganRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\StatusUpdateRelationManager;
use App\Filament\Resources\DataPmiResource\RelationManagers\TujuanRelationManager;
use App\Filament\Resources\DataPmiResource\Widgets\BatangOverview;
use App\Filament\Resources\DataPmiResource\Widgets\BrebesOverview;
use App\Filament\Resources\DataPmiResource\Widgets\DataPmiOverview;
use App\Filament\Resources\DataPmiResource\Widgets\KendalOverview;
use App\Filament\Resources\DataPmiResource\Widgets\PmiStatus;
use App\Filament\Resources\DataPmiResource\Widgets\SiapKerjaOverview;
use App\Filament\Resources\DataPmiResource\Widgets\WeleriOverview;
use App\Models\DataPmi;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\Layout;
use Webbingbrasil\FilamentAdvancedFilter\Filters\BooleanFilter;


class DataPmiResource extends Resource

{

    protected static ?string $model = DataPmi::class;
    protected static ?string $navigationLabel = 'DATA PMI';
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'CPMI';
    protected static ?int $navigationSort = -3;

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('AKUN SIAP KERJA')
                    ->description('Silahkan Input Akun SiapKerja')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('tglsiapkerja')
                                    ->label('Tanggal SiapKerja')
                                    ->placeholder('Pilih Tanggal'),

                                TextInput::make('telp_siapkerja')
                                    ->label('Nomor Telp Akun SiapKerja')
                                    ->placeholder('Contoh. 081xxxx')
                                    ->numeric()
                                    ->minLength(6)
                                    ->maxLength(12),
                                TextInput::make('email_siapkerja')
                                    ->label('Email  Akun SiapKerja')
                                    ->placeholder('Contoh. mario@gmail.com')
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('password_siapkerja')
                                    ->label('Password Akun SiapKerja')
                                    ->placeholder('Password Akun SiapKerja')
                                    ->maxLength(255),
                                FileUpload::make('file_pp')->disk('public')->label('Perjanjian Penempatan')
                                    ->directory('datapmi/file_pp')
                                    ->preserveFilenames()
                                    ->enableDownload()
                                    ->enableOpen()
                                    ->enableReordering()
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left'),
                                TextInput::make('no_id_pmi')->placeholder('Masukan NO ID CPMI')->label('ID CPMI'),
                                Toggle::make('siapkerja')
                                    ->label('Terdaftar SiapKerja')
                                    ->inline(true),
                                Toggle::make('verdata')->label('Verifikasi SiapKerja')
                                    ->inline(true),
                                Toggle::make('verpp')->label('Verifikasi PP')
                                    ->inline(true),
                            ]),
                    ])->columns(2)->collapsed(),

                // ----------------------------------------------------------------BATAS

                Section::make('INPUT DATA')
                    ->description('Input Proses Data PMI')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Select::make('status_update_id',)
                            ->relationship('StatusUpdate', 'status_update')
                            ->required()
                            ->placeholder('Pilih Status CPMI')
                            ->label('Status CPMI'),
                        Select::make('pendaftaran_id',)
                            ->relationship('Pendaftaran', 'nama')
                            ->getOptionLabelFromRecordUsing(fn (Pendaftaran $record) => "{$record->nama} No.eKTP {$record->nomor_ktp}")
                            ->searchable()
                            ->required()
                            ->optionsLimit(25)
                            ->placeholder('Ketik Nama TKW/CPMI')
                            ->label('Cari TKW/CPMI'),
                        Select::make('kantor_id',)
                            ->relationship('Kantor', 'kantor')
                            ->required()
                            ->placeholder('Pilih Kantor Cabang')
                            ->label('Kantor Cabang'),
                        Select::make('tujuan_id',)
                            ->relationship('Tujuan', 'negara_tujuan')
                            ->required()
                            ->placeholder('Pilih Negara Tujuan')
                            ->label('Negara Tujuan'),
                        Select::make('pengalaman_id',)
                            ->relationship('Pengalaman', 'pengalaman')
                            ->required()
                            ->placeholder('Pilih Pengalaman')
                            ->label('Pengalaman CPMI'),
                        Select::make('petugas_lapangan_id',)
                            ->relationship('PetugasLapangan', 'petugas_lapangan')
                            ->placeholder('Pilih SPONSOR PL')
                            ->label('SPONSOR PL')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('petugas_lapangan')->unique()
                            ])
                            ->required(),
                        Select::make('marketing_id',)
                            ->relationship('Marketing', 'marketing')
                            ->required()
                            ->placeholder('Pilih Marketing')
                            ->label('Markerting'),
                        Select::make('agency_id',)
                            ->relationship('Agency', 'agency')
                            ->required()
                            ->placeholder('Pilih Agency')
                            ->label('Agency'),

                        // Toggle::make('getjob')
                        //     ->label('GET JOB')
                        //     ->inline(true),
                    ])->columns(2)->collapsed(),

                // ----------------------------------------------------------------BATAS

                Section::make('INPUT STATUS')
                    ->description('Input StatusProses Data PMI')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Tabs::make('INPUT DATA')
                            ->tabs([
                                Tabs\Tab::make('PRA - PASPORT')
                                    ->icon('heroicon-o-check-circle')
                                    // ->description('PRA MEDICAL - PASPORT')
                                    ->schema([
                                        // Grid::make(2)
                                        //     ->schema([
                                        //         Card::make()
                                        //             ->schema([
                                        //                 Toggle::make('medical_check')
                                        //                     ->label('Medical Check (Wajib di Centang)')
                                        //                     ->inline(false),
                                        //                 Toggle::make('unfit')
                                        //                     ->label('UNFIT')
                                        //                     ->inline(false),
                                        //             ])
                                        //     ]),
                                        Grid::make(4)
                                            ->schema([
                                                Card::make()
                                                    ->schema([
                                                        Toggle::make('medical_check')
                                                            ->label('Medical Check (Wajib di Centang)')
                                                            ->inline(false),
                                                        Toggle::make('fit')
                                                            ->label('FIT')
                                                            ->inline(false),
                                                        TextInput::make('pra_medical')->placeholder('Keterangan')->label('Pra Medical'),
                                                        DatePicker::make('tanggal_pra_medical')->label('Tanggal Pra Medical')->placeholder('Pilih Tanggal'),
                                                        // FileUpload::make('file_pra_medical')->label('Upload File')
                                                        //     ->disk('public')
                                                        //     ->directory('datapmi/file_pra_medical')
                                                        //     ->preserveFilenames()
                                                        //     ->enableDownload()
                                                        //     ->enableOpen()
                                                        //     ->enableReordering()
                                                        //     ->loadingIndicatorPosition('right')
                                                        //     ->removeUploadedFileButtonPosition('right')
                                                        //     ->uploadButtonPosition('left')
                                                        //     ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(4),
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('ujk')->placeholder('Keterangan')->label('UJK CPMI'),
                                                        DatePicker::make('tanggal_ujk')->placeholder('Pilih Tanggal')->label('Tanggal UJK CPMI'),
                                                        FileUpload::make('file_ujk')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_ujk')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),

                                                // Card::make()
                                                //     ->schema([
                                                //     TextInput::make('no_id_pmi')->placeholder('Masukan NO ID CPMI')->label('NO ID CPMI'),
                                                //     DatePicker::make('tanggal_no_id_pmi')->label('Tanggl ID PMI')->placeholder('Pilih Tanggal'),
                                                //     FileUpload::make('file_no_id_pmi')->label('Upload File')->disk('public')
                                                //         ->directory('datapmi/file_no_id_pmi')
                                                //         ->preserveFilenames()
                                                //         ->enableDownload()
                                                //         ->enableOpen()
                                                //         ->enableReordering()
                                                //         ->loadingIndicatorPosition('right')
                                                //         ->removeUploadedFileButtonPosition('right')
                                                //         ->uploadButtonPosition('left')
                                                //         ->uploadProgressIndicatorPosition('left'),
                                                //         ])->columns(3),

                                                Card::make()
                                                    ->schema([
                                                        Toggle::make('job')
                                                            ->label('GET JOB')
                                                            ->inline(false),
                                                        DatePicker::make('tanggal_job')->placeholder('Pilih Tanggal')->label('Tanggal JOB'),
                                                        Select::make('agency_id',)
                                                            ->relationship('Agency', 'agency')
                                                            ->required()
                                                            ->placeholder('Pilih Agency')
                                                            ->label('Agency'),
                                                        // FileUpload::make('file_job')->disk('public')->label('Upload File')
                                                        //         ->directory('datapmi/file_job')
                                                        //         ->preserveFilenames()
                                                        //         ->enableDownload()
                                                        //         ->enableOpen()
                                                        //         ->enableReordering()
                                                        //         ->loadingIndicatorPosition('right')
                                                        //         ->removeUploadedFileButtonPosition('right')
                                                        //         ->uploadButtonPosition('left')
                                                        //         ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('validasi_paspor')->placeholder('Keterangan')->label('Validasi Paspor'),
                                                        DatePicker::make('tanggal_validasi_paspor')->placeholder('Pilih Tanggal')->label('Tanggal Validasi Paspor'),
                                                        FileUpload::make('file_validasi_paspor')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_validasi_paspor')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                            ])
                                    ]),

                                // ----------------------------------------------------------------BATAS

                                Tabs\Tab::make('PRA BPJS - EC')
                                    ->icon('heroicon-o-check-circle')
                                    // ->description('BLK - EC')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                // TextInput::make('blk')->placeholder('Keterangan')->label('BLK'),
                                                // DatePicker::make('tanggal_blk')->label('Tanggal BLK')->placeholder('Pilih Tanggal'),
                                                // FileUpload::make('file_blk')->disk('public')->label('Upload File')
                                                //         ->directory('datapmi/file_blk')
                                                //         ->preserveFilenames()
                                                //         ->enableDownload()
                                                //         ->enableOpen()
                                                //         ->enableReordering()
                                                //         ->loadingIndicatorPosition('right')
                                                //         ->removeUploadedFileButtonPosition('right')
                                                //         ->uploadButtonPosition('left')
                                                //         ->uploadProgressIndicatorPosition('left'),

                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('pra_bpjs')->placeholder('Keterangan')->label('PRA BPJS'),
                                                        DatePicker::make('tanggal_pra_bpjs')->label('Tanggal PRA BPJS')->placeholder('Pilih Tanggal'),
                                                        FileUpload::make('file_pra_bpjs')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_pra_bpjs')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),

                                                // Card::make()
                                                //     ->schema([
                                                //     TextInput::make('rekom_perpen')->placeholder('Keterangan')->label('Rekom & Perpen'),
                                                //     DatePicker::make('tanggal_rekom_perpen')->label('Tanggal Rekom Perpen')->placeholder('Pilih Tanggal'),
                                                //     FileUpload::make('file_rekom_perpen')->disk('public')->label('Upload File')
                                                //         ->directory('datapmi/file_rekom_perpen')
                                                //         ->preserveFilenames()
                                                //         ->enableDownload()
                                                //         ->enableOpen()
                                                //         ->enableReordering()
                                                //         ->loadingIndicatorPosition('right')
                                                //         ->removeUploadedFileButtonPosition('right')
                                                //         ->uploadButtonPosition('left')
                                                //         ->uploadProgressIndicatorPosition('left'),
                                                //         ])->columns(3),

                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('medical_full')->placeholder('Keterangan')->label('Medical Full'),
                                                        DatePicker::make('tanggal_medical_full')->label('Tanggal Medical Full')->placeholder('Pilih Tanggal'),
                                                        FileUpload::make('file_medical_full')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_medical_full')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('ec')->placeholder('Keterangan')->label('EC'),
                                                        DatePicker::make('tanggal_ec')->placeholder('Pilih Tanggal')->label('Tanggal EC'),
                                                        FileUpload::make('file_ec')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_ec')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                            ])
                                    ]),

                                // ----------------------------------------------------------------BATAS

                                Tabs\Tab::make('VISA - KTKLN')
                                    ->icon('heroicon-o-check-circle')
                                    // ->description('VISA - KTKLN')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('visa')->placeholder('Keterangan')->label('VISA'),
                                                        DatePicker::make('tanggal_visa')->placeholder('Pilih Tanggal')->label('Tanggal VISA'),
                                                        FileUpload::make('file_visa')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_visa')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),



                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('bpjs_purna')->placeholder('Keterangan')->label('BPJS Purna'),
                                                        DatePicker::make('tanggal_bpjs_purna')->placeholder('Pilih Tanggal')->label('Tanggal BPJS Purna'),
                                                        FileUpload::make('file_bpjs_purna')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_bpjs_purna')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('ktkln')->placeholder('Keterangan')->label('KTKLN'),
                                                        DatePicker::make('tanggal_ktkln')->placeholder('Pilih Tanggal')->label('Tanggal KTKLN'),
                                                        FileUpload::make('file_ktkln')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_ktkln')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                            ])
                                    ]),

                                // ----------------------------------------------------------------BATAS

                                Tabs\Tab::make('TERBANG - INVOICE')
                                    ->icon('heroicon-o-check-circle')
                                    // ->description('TERBANG - INVOICE')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('terbang')->placeholder('Keterangan')->label('Tebang/FLY'),
                                                        DatePicker::make('tanggal_terbang')->placeholder('Pilih Tanggal')->label('Tanggal Tebang/FLY'),
                                                        FileUpload::make('file_terbang')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_terbang')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('invoice_toyo')->placeholder('Keterangan')->label('Invoice Toyo'),
                                                        DatePicker::make('tanggal_invoice_toyo')->placeholder('Pilih Tanggal')->label('Tanggal Invoice Toyo'),
                                                        FileUpload::make('file_invoice_toyo')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_invoice_toyo')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                                Card::make()
                                                    ->schema([
                                                        TextInput::make('invoice_agency')->placeholder('Keterangan')->label('Invoice Agency'),
                                                        DatePicker::make('tanggal_invoice_agency')->placeholder('Pilih Tanggal')->label('Tanggl Invoice Agency'),
                                                        FileUpload::make('file_invoice_agency')->disk('public')->label('Upload File')
                                                            ->directory('datapmi/file_invoice_agency')
                                                            ->preserveFilenames()
                                                            ->enableDownload()
                                                            ->enableOpen()
                                                            ->enableReordering()
                                                            ->loadingIndicatorPosition('right')
                                                            ->removeUploadedFileButtonPosition('right')
                                                            ->uploadButtonPosition('left')
                                                            ->uploadProgressIndicatorPosition('left'),
                                                    ])->columns(3),
                                            ])
                                    ])
                            ])
                    ])->columns(1)->collapsed(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('Pendaftaran.nama')->sortable()->searchable()->alignment('left')->label('Nama CPMI'),
                // TextColumn::make('kantor.kantor')->sortable()->searchable()->alignment('left')->label('Kantor Cabang')->color('warning'),
                // TextColumn::make('Tujuan.negara_tujuan')->sortable()->searchable()->alignment('left')->label('Negara Tujuan'),
                // TextColumn::make('StatusUpdate.status_update')->sortable()->searchable()->alignment('left')->label('Status Update')->limit(15),
                // IconColumn::make('medical_check')->sortable()->boolean('medical_check')->trueIcon('heroicon-o-heart')->falseIcon('heroicon-o-x-circle')->label('Status Medical'),
                // TextColumn::make('pra_medical')->label('Hasil Pra Medical')->sortable()->limit(15),
                // TextColumn::make('tanggal_pra_medical')->sortable()->date()->alignment('left')->label('Tanggal Pramedical')->icon('heroicon-o-shield-check'),
                // TextColumn::make('Agency.agency')->searchable()->alignment('left')->label('Agency')->icon('heroicon-s-status-online'),
                // TextColumn::make('PetugasLapangan.petugas_lapangan')->searchable()->alignment('left')->label('SPONSOR PL')->icon('heroicon-s-user-group')->limit(10),
                // TextColumn::make('Marketing.marketing')->searchable()->alignment('left')->label('Marketing')->icon('heroicon-o-shopping-cart'),
                // TextColumn::make('tanggal_terbang')->sortable()->date()->alignment('left')->label('Tanggal Penerbangan')->icon('heroicon-o-paper-airplane'),
                // TextColumn::make('created_at')->date()
                //         ->sortable(query: function (Builder $query, string $direction): Builder {
                //         return $query->orderBy('created_at', $direction);})->alignment('left')->label('Tanggal Proses')->icon('heroicon-o-arrow-circle-right'),
                // TextColumn::make('updated_at')->date()->alignment('left')->label('Tanggal Update')->icon('heroicon-o-refresh'),

                // ------------------------------------------
                TextColumn::make('Pendaftaran.nama')->sortable()->searchable()->alignment('left')->label('CPMI'),
                TextColumn::make('Pendaftaran.regency.name')->sortable()->searchable()->alignment('left')->label('KOTA ASAL'),
                TextColumn::make('Tujuan.negara_tujuan')->sortable()->searchable()->alignment('left')->label('NEGARA')->color('primary'),
                TextColumn::make('StatusUpdate.status_update')->sortable()->searchable()->alignment('left')->label('STATUS')->limit(15)->color('success'),
                TextColumn::make('kantor.kantor')->sortable()->searchable()->alignment('left')->label('KANTOR')->color('warning'),
                TextColumn::make('tanggal_pra_medical')->sortable()->searchable()->alignment('left')->label('PRA MEDICAL'),
                IconColumn::make('fit')
                    ->sortable()
                    ->boolean('fit')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')->alignment('right')
                    ->label('FIT'),
                TextColumn::make('pra_medical')->label('HASIL')->sortable()->limit(7)->searchable(),
                TextColumn::make('tanggal_ujk')->sortable()->searchable()->alignment('left')->label('UJK'),
                IconColumn::make('job')
                    ->sortable()
                    ->boolean('job')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')->alignment('right')
                    ->label('JOB'),
                TextColumn::make('tanggal_job')->sortable()->searchable()->alignment('left')->label('TGL JOB'),
                IconColumn::make('siapkerja')
                    ->sortable()
                    ->boolean('siapkerja')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')->alignment('right')
                    ->label('SIAP KERJA'),
                IconColumn::make('verdata')
                    ->sortable()
                    ->boolean('verdata')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')->alignment('right')
                    ->label('VER DATA SIAPKERJA'),
                IconColumn::make('verpp')
                    ->sortable()
                    ->boolean('verpp')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')->alignment('right')
                    ->label('VER PP SIAP KERJA'),
                TextColumn::make('no_id_pmi')->sortable()->searchable()->alignment('left')->label('ID PMI'),
                TextColumn::make('tanggal_validasi_paspor')->sortable()->searchable()->alignment('left')->label('PASPOR'),
                TextColumn::make('tanggal_pra_bpjs')->sortable()->searchable()->alignment('left')->label('PRA BPJS'),
                TextColumn::make('tanggal_medical_full')->sortable()->searchable()->alignment('left')->label('MEDICAL FULL'),
                TextColumn::make('tanggal_ec')->sortable()->searchable()->alignment('left')->label('EC'),
                TextColumn::make('tanggal_visa')->sortable()->searchable()->alignment('left')->label('VISA'),
                // TextColumn::make('tanggal_blk')->sortable()->searchable()->alignment('left')->label('BLK'),
                TextColumn::make('tanggal_bpjs_purna')->sortable()->searchable()->alignment('left')->label('BPJS PURNA'),
                TextColumn::make('tanggal_ktkln')->sortable()->searchable()->alignment('left')->label('KTKLN'),
                TextColumn::make('tanggal_terbang')->sortable()->searchable()->alignment('left')->label('TERBANG'),
                TextColumn::make('tanggal_invoice_toyo')->sortable()->searchable()->alignment('left')->label('INV TOYO'),
                TextColumn::make('tanggal_invoice_agency')->sortable()->searchable()->alignment('left')->label('INV AGENCY'),
                // TextColumn::make('tglsiapkerja')->sortable()->searchable()->alignment('left')->label('SIAP KERJA'),


            ])

            ->filters([

                // SelectFilter::make('StatusUpdate')->relationship('StatusUpdate', 'status_update')->label('STATUS'),
                // SelectFilter::make('Agency')->relationship('Agency', 'agency')->label('AGENCY'),
                // SelectFilter::make('Kantor')->relationship('Kantor', 'kantor')->label('KANTOR'),
                // SelectFilter::make('Tujuan')->relationship('Tujuan', 'negara_tujuan')->label('NEGARA'),
                // SelectFilter::make('PetugasLapangan')->relationship('PetugasLapangan', 'petugas_lapangan')->label('SPONSOR PL'),
                // SelectFilter::make('Marketing')->relationship('Marketing', 'marketing')->label('MARKETING'),
                // // TernaryFilter::make('medical_check')->label('Status Medical'),
                // TernaryFilter::make('fit')->label('FIT'),
                // TernaryFilter::make('job')->label('GET JOB'),
                // TernaryFilter::make('siapkerja')->label('TERDAFTAR SIAPKERJA'),
                // TernaryFilter::make('verdata')->label('VER DATA SIAPKERJA'),
                // TernaryFilter::make('verpp')->label('VER PP SIAPKERJA'),

                // -------------------------------------BATAS


                // Filter::make('created_at')
                //     ->form([
                //         Forms\Components\DatePicker::make('created_from')->label('Di Buat'),
                //         Forms\Components\DatePicker::make('created_until')->label('Sampai'),
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query
                //             ->when(
                //                 $data['created_from'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                //             )
                //             ->when(
                //                 $data['created_until'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                //             );
                //     }),

                //--------------------------------------------------------------------BATAS

                // Filter::make('tanggal_pra_medical')->label('TANGGAL PRA MEDICAL')
                //     ->form([
                //         Forms\Components\DatePicker::make('created_from')->label('TANGGAL PRA MEDICAL'),
                //         Forms\Components\DatePicker::make('created_until')->label('Sampai')
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query
                //             ->when(
                //                 $data['created_from'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pra_medical', '>=', $date),
                //             )
                //             ->when(
                //                 $data['created_until'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pra_medical', '<=', $date),
                //             );
                //     }),

                // Filter::make('tanggal_job')->label('TANGGAL JOB')
                //     ->form([
                //         Forms\Components\DatePicker::make('created_from')->label('TANGGAL JOB'),
                //         Forms\Components\DatePicker::make('created_until')->label('Sampai'),
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query
                //             ->when(
                //                 $data['created_from'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('tanggal_job', '>=', $date),
                //             )
                //             ->when(
                //                 $data['created_until'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('tanggal_job', '<=', $date),
                //             );
                //     }),
                // Filter::make('tanggal_terbang')->label('TANGGAL PENERBANGAN')
                //     ->form([
                //         Forms\Components\DatePicker::make('created_from')->label('ANGGAL PENERBANGAN'),
                //         Forms\Components\DatePicker::make('created_until')->label('Sampai'),
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query
                //             ->when(
                //                 $data['created_from'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('tanggal_terbang', '>=', $date),
                //             )
                //             ->when(
                //                 $data['created_until'],
                //                 fn (Builder $query, $date): Builder => $query->whereDate('tanggal_terbang', '<=', $date),
                //             );
                //     }),



                // -----------------------------------------------------------BATAS

                BooleanFilter::make('fit')->label('FIT')


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
            PendaftaranRelationManager::class,
            TujuanRelationManager::class,
            AgencyRelationManager::class,
            KantorRelationManager::class,
            MarketingRelationManager::class,
            PengalamanRelationManager::class,
            PetugasLapanganRelationManager::class,
            StatusUpdateRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            DataPmiOverview::class,
            SiapKerjaOverview::class,
            PmiStatus::class,
            KendalOverview::class,
            BatangOverview::class,
            WeleriOverview::class,
            BrebesOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPmis::route('/'),
            // 'create' => Pages\CreateDataPmi::route('/create'),
            'edit' => Pages\EditDataPmi::route('/{record}/edit'),
        ];
    }

    public function DataPmi()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function Pendaftaran()

    {
        return $this->HasMany(DataPmi::class);
    }
}
