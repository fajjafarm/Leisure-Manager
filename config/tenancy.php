<?php

return [

    'tenant_model' => \App\Models\Tenant::class,

    'id_generator' => \Stancl\Tenancy\UUIDGenerator::class,

    'domain_model' => \Stancl\Tenancy\Database\Models\Domain::class,

    'central_domains' => [
        'lm.glensloss.co.uk',
        '127.0.0.1',
        'localhost',
    ],

    'database' => [
        'central_connection' => 'central',
        'prefix' => 'tenant_',
        'suffix' => '',
    ],

    'features' => [
        \Stancl\Tenancy\Features\UserImpersonation::class,
        \Stancl\Tenancy\Features\TenantConfig::class,
    ],

    'exempt_routes' => [
        'livewire.*',
        'filament.*',
    ],

];