<?php

namespace App\Filament\Resources\ClientEnterpriseResource\Pages;

use App\Filament\Resources\ClientEnterpriseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientEnterprises extends ListRecords
{
    protected static string $resource = ClientEnterpriseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
