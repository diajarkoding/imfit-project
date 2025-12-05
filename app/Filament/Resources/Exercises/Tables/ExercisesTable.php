<?php

namespace App\Filament\Resources\Exercises\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExercisesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),

                TextColumn::make('target_muscle')
                    ->badge()
                    ->searchable()
                    ->label('Otot Target'),

                TextColumn::make('admin.fullname')
                    ->label('Dibuat Oleh')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Tanggal Dibuat'),

                TextColumn::make('updated_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diperbarui'),
            ])
            ->filters([
                SelectFilter::make('target_muscle')
                    ->options([
                        'Chest' => 'Chest',
                        'Back' => 'Back',
                        'Legs' => 'Legs',
                        'Shoulders' => 'Shoulders',
                        'Arms' => 'Arms',
                        'Abs' => 'Abs',
                        'Cardio' => 'Cardio',
                    ])
                    ->label('Filter Otot Target'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
