<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianResource\Pages;
use App\Filament\Resources\PembelianResource\RelationManagers;
use App\Models\Pembelian;
use Filament\Forms;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembelianResource extends Resource
{
    protected static ?string $model = Pembelian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                ->options(
                    \App\Models\Supplier::pluck('nama', 'id')
                )
                ->required()
                ->label('Pilih Supplier')
                ->searchable()
                ->createOptionForm(\App\Filament\Resources\SupplierResource::getForm())
                ->createOptionUsing(function (array $data):int {
                    return \App\Models\Supplier::create($data)->id;
                })
                ->reactive()
                ->afterStateUpdated(function ($state, Set $set) {
                    $supplier = \App\Models\Supplier::find($state);
                    $set('email', $supplier->email ?? null);
                }),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->default(now())
                    ->columnSpanFull()
                    ->label('Tanggal Pembelian'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPembelians::route('/'),
            'create' => Pages\CreatePembelian::route('/create'),
            'edit' => Pages\EditPembelian::route('/{record}/edit'),
        ];
    }
}
