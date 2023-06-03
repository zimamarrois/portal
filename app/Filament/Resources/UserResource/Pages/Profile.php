<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class Profile extends ListRecords
{
    protected static string $resource = UserResource::class;
    protected static ?string $navigationGroup = 'Admin Management';
}

