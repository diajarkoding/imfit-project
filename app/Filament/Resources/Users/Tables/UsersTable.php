<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Lengkap'),

                TextColumn::make('username')
                    ->searchable()
                    ->label('Username'),

                TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),

                ToggleColumn::make('is_admin')
                    ->label('Admin')
                    ->onColor('success')
                    ->offColor('danger'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Terdaftar'),

                TextColumn::make('date_of_birth')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Tanggal Lahir'),

                TextColumn::make('updated_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diperbarui'),
            ])
            ->filters([
                TernaryFilter::make('is_admin')
                    ->label('Status Admin')
                    ->trueLabel('Admin Only')
                    ->falseLabel('User Only'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
