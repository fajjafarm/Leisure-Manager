<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function handleRecordCreation(array $data): \App\Models\Tenant
    {
        $tenant = \App\Models\Tenant::create([
            'id'   => (string) Str::ulid(),
            'data' => [
                'name'              => $data['name'],
                'contact_name'      => $data['contact_name'],
                'email'             => $data['email'],
                'phone'             => $data['phone'] ?? null,
                'subscription_plan' => $data['subscription_plan'],
            ],
        ]);

        $tenant->domains()->create([
            'domain' => $data['domain'],
        ]);

        $tenant->run(function () use ($tenant) {
            \Illuminate\Support\Facades\Artisan::call('tenants:migrate', [
                '--tenants' => [$tenant->id],
                '--force' => true,
            ]);
        });

        return $tenant;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}