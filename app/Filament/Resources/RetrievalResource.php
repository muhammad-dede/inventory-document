<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RetrievalResource\Pages;
use App\Filament\Resources\RetrievalResource\RelationManagers;
use App\Models\Pic;
use App\Models\Product;
use App\Models\Retrieval;
use App\Models\Section;
use App\Models\Vendor;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class RetrievalResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Retrieval::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';
    protected static ?string $navigationGroup = 'Data';
    protected static ?string $label = 'Pengambilan Barang';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('retrieval_date')
                    ->label('Tanggal Pengambilan')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->required(),
                Forms\Components\Select::make('section_code')
                    ->relationship(name: 'section', titleAttribute: 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data) {
                        $created = Section::create($data);
                        return $created->code;
                    })
                    ->label('Seksi')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(),
                Forms\Components\Select::make('pic_id')
                    ->options(fn(Get $get): Collection => Pic::query()
                        ->where('section_code', $get('section_code'))
                        ->pluck('name', 'id'))
                    ->label('PIC')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Section::make('Detail Pengambilan')
                    ->schema([
                        Forms\Components\Repeater::make('retrievalItems')
                            ->relationship('retrievalItems')
                            ->label('')
                            ->schema([
                                Forms\Components\Select::make('product_code')
                                    ->relationship(name: 'product')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('code')
                                            ->label('Kode')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nama')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('vendor_code')
                                            ->relationship(name: 'vendor', titleAttribute: 'name')
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('code')
                                                    ->label('Kode')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(ignoreRecord: true),
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Nama')
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->createOptionUsing(function (array $data) {
                                                $created = Vendor::create($data);
                                                return $created->code;
                                            })
                                            ->label('Vendor')
                                            ->required()
                                            ->searchable()
                                            ->preload(),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $created = Product::create($data);
                                        return $created->code;
                                    })
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->code} ({$record->name})")
                                    ->label('Kode Barang')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\TextInput::make('qty')
                                    ->label('Qty')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\DatePicker::make('in_date')
                                    ->label('Tanggal Masuk Barang')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->required(),
                                Forms\Components\TextInput::make('no_primary')
                                    ->label('No Primary')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->addActionLabel('Tambah Barang')
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pic.name')
                    ->label('PIC')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->label('Seksi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('retrieval_date')
                    ->label('Tanggal Pengambilan')
                    ->date('d-m-Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('generate')
                    ->label('Generate PDF')
                    ->color('info')
                    ->url(fn(Retrieval $record): string => route('pdf.retrieval', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListRetrievals::route('/'),
            'create' => Pages\CreateRetrieval::route('/create'),
            'edit' => Pages\EditRetrieval::route('/{record}/edit'),
        ];
    }
}
