<?php

namespace App\Filament\Resources\MarketingResource\Pages;

use App\Filament\Resources\MarketingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketing extends EditRecord
{
    protected static string $resource = MarketingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
