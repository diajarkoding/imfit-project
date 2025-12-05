<?php

namespace App\Filament\Resources\Exercises\Pages;

use App\Filament\Resources\Exercises\ExerciseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExercise extends CreateRecord
{
    protected static string $resource = ExerciseResource::class;

    /**
     * Mutate form data before creating the record.
     * Ensures created_by_admin_id is set to the logged-in admin's ID.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by_admin_id'] = auth()->id();

        return $data;
    }
}
