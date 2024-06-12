<?php

namespace App\Filament\Resources\BillingInfoClientEnterpriseResource\Pages;

use App\Filament\Resources\BillingInfoClientEnterpriseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBillingInfoClientEnterprises extends ListRecords
{
    protected static string $resource = BillingInfoClientEnterpriseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
