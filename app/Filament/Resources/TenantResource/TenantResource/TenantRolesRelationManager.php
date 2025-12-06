<?php

namespace App\Filament\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TenantRolesRelationManager extends RelationManager
{
    protected static string $relationship = 'tenantRoles';

    protected static ?string $recordTitleAttribute = 'name';

    // THIS LINE IS THE FINAL FIX — makes ULID work in URLs
    protected static ?string $recordRouteKeyName = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('rank')
                    ->numeric()
                    ->default(100)
                    ->required(),

                Forms\Components\Section::make('Permissions')
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions.team')
                            ->label('Team Management')
                            ->options([
                                'team.view' => 'View Team',
                                'team.create' => 'Create Member',
                                'team.edit' => 'Edit Member',
                                'team.delete' => 'Delete Member',
                            ])
                            ->columns(2),

                        Forms\Components\CheckboxList::make('permissions.equipment')
                            ->label('Equipment & LOLER')
                            ->options([
                                'equipment.view' => 'View Equipment',
                                'equipment.create' => 'Add Equipment',
                                'equipment.edit' => 'Edit Equipment',
                                'equipment.delete' => 'Delete Equipment',
                                'equipment.loler' => 'Manage LOLER Records',
                            ])
                            ->columns(2),

                        Forms\Components\CheckboxList::make('permissions.pools')
                            ->label('Pools & PWTAG')
                            ->options([
                                'pools.view' => 'View Pool Logs',
                                'pools.log' => 'Add Daily Test',
                                'pools.edit' => 'Edit Test Results',
                                'pools.alerts' => 'Manage Alerts',
                            ])
                            ->columns(2),

                        Forms\Components\CheckboxList::make('permissions.billing')
                            ->label('Billing')
                            ->options([
                                'billing.view' => 'View Invoices',
                                'billing.pay' => 'Make Payment',
                            ]),

                        Forms\Components\CheckboxList::make('permissions.reports')
                            ->label('Reports')
                            ->options([
                                'reports.training' => 'Training Reports',
                                'reports.compliance' => 'Compliance Reports',
                                'reports.equipment' => 'Equipment Reports',
                            ]),

                        Forms\Components\CheckboxList::make('permissions.settings')
                            ->label('Settings')
                            ->options([
                                'settings.edit' => 'Edit Settings',
                                'settings.users' => 'Manage Users',
                                'settings.roles' => 'Manage Roles',
                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('rank')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}