<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $label = 'Data Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->minLength(5)
                    ->label('Kode Barang'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->minLength(3)
                    ->label('Nama Barang'),
                Forms\Components\TextInput::make('harga')
                    ->required()
                    ->label('Harga Barang'),
                Forms\Components\TextInput::make('stok')
                    ->label('Stok Awal')
                    ->disabledOn('edit'),
                Forms\Components\Select::make('satuan')
                    ->options(['pcs'=>'Pcs', 'lusin'=> 'Lusin']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga Barang')
                    ->money('IDR')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stok')
                    ->searchable(),
                Tables\Columns\TextColumn::make('satuan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
