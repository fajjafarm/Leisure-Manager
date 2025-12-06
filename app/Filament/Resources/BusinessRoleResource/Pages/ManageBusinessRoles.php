<?php

namespace App\Filament\Resources\BusinessRoleResource\Pages;

use App\Filament\Resources\BusinessRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBusinessRoles extends ManageRecords
{
    protected static string $resource = BusinessRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
