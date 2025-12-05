<?php

namespace App\Filament\Resources\Exercises\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExerciseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Latihan'),

                Select::make('target_muscle')
                    ->required()
                    ->options([
                        'Chest' => 'Chest (Dada)',
                        'Back' => 'Back (Punggung)',
                        'Legs' => 'Legs (Kaki)',
                        'Shoulders' => 'Shoulders (Bahu)',
                        'Arms' => 'Arms (Lengan)',
                        'Abs' => 'Abs (Perut)',
                        'Cardio' => 'Cardio',
                    ])
                    ->label('Otot Target'),

                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->label('Deskripsi'),

                // Hidden field - auto-filled with current logged-in admin ID
                Hidden::make('created_by_admin_id')
                    ->default(fn () => auth()->id()),
            ]);
    }
}
