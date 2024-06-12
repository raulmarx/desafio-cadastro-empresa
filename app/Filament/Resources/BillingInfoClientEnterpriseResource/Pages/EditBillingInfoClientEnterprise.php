<?php

namespace App\Filament\Resources\BillingInfoClientEnterpriseResource\Pages;

use App\Filament\Resources\BillingInfoClientEnterpriseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBillingInfoClientEnterprise extends EditRecord
{
    protected static string $resource = BillingInfoClientEnterpriseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
