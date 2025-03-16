<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setSearchIcon('heroicon-m-magnifying-glass')
            ->setBulkActions([
                'deleteSelected' => 'Delete Selected',
            ])->setBulkActionsTdCheckboxAttributes([
                'class' => 'w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500',
            ]);
    }
    
    public function filters(): array
    {
        return [
            SelectFilter::make('E-mail Verified', 'email_verified_at')
                ->setFilterPillTitle('Verified')
                ->options([
                    ''    => 'Any',
                    'yes' => 'Yes',
                    'no'  => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === 'yes') {
                        $builder->whereNotNull('email_verified_at');
                    } elseif ($value === 'no') {
                        $builder->whereNull('email_verified_at');
                    }
                }),
        ];
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}