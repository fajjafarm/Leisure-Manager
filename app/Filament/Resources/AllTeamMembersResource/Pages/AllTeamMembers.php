<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\TeamMember;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class AllTeamMembers extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'All Team Members';
    protected static ?string $navigationGroup = 'Global Overview';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.all-team-members';

    public function table(Table $table): Table
    {
        return $table
            ->query(TeamMember::query())
            ->columns([
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Facility')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('first_name')
                    ->label('Name')
                    ->formatStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('employment_start_date')
                    ->label('Date Joined')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'active',
                        'heroicon-o-x-circle' => 'inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view_tenant')
                    ->label('View Facility')
                    ->icon('heroicon-o-arrow-right')
                    ->url(fn ($record) => TenantResource::getUrl('edit', ['record' => $record->tenant]))
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}