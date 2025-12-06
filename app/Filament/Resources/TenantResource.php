<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use App\Filament\Resources\TenantResource\RelationManagers\TenantRolesRelationManager; // ? THIS LINE
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Clients / Facilities';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Company Name')
                    ->required(),

                Forms\Components\TextInput::make('contact_name')
                    ->label('Contact Name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Contact Email')
                    ->email()
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label('Phone Number'),

                Forms\Components\Select::make('subscription_plan')
                    ->label('Subscription Plan')
                    ->options([
                        'basic' => 'Basic – £99/mo',
                        'pro' => 'Pro – £199/mo',
                        'enterprise' => 'Enterprise – £499/mo',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('domain')
                    ->label('Subdomain')
                    ->placeholder('glenloss')
                    ->helperText('Will be accessible at {subdomain}.lm.glensloss.co.uk')
                    ->unique('domains', 'domain', ignorable: fn ($record) => $record?->domains->first())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contact_name')
                    ->label('Contact'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone'),

                Tables\Columns\TextColumn::make('domains.domain')
                    ->label('Live URL')
                    ->formatStateUsing(fn ($record) => $record->domains->first()?->domain
                        ? $record->domains->first()->domain . '.lm.glensloss.co.uk'
                        : '—'
                    )
                    ->url(fn ($record) => $record->domains->first()?->domain
                        ? 'https://' . $record->domains->first()->domain . '.lm.glensloss.co.uk'
                        : null
                    )
                    ->openUrlInNewTab()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('subscription_plan')
                    ->label('Plan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'enterprise' => 'danger',
                        'pro' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }


public static function getRelations(): array
{
    return [
        \App\Filament\Resources\TenantResource\RelationManagers\TeamRolesRelationManager::class,
    ];
}
  public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'view'   => Pages\ViewTenant::route('/{record}'),
            'edit'   => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}