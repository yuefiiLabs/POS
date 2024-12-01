<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Data Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('avatar_url')->image()->label('Avatar')->Avatar(),
                Forms\Components\TextInput::make('name')->required()->minLength(3),
                Forms\Components\TextInput::make('email')->required()->email()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->minLength(6),
                Forms\Components\Select::make('role')->options([
                    'admin' => 'Admin',
                    'kasir' => 'Kasir',
                ])->required()->default('kasir'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')->circular()->label('Avatar'),
                Tables\Columns\TextColumn::make('name')->searchable()->searchable()->label('Nama'),
                Tables\Columns\TextColumn::make('email')->searchable()->searchable(),
                Tables\Columns\TextColumn::make('role')->searchable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d-m-Y H:i')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
