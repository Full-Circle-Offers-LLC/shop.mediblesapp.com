<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AppInstallation;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class WhmAppInstallationsTable extends DataTableComponent
{
    protected bool $offlineIndicatorStatus = false;
    protected $model = AppInstallation::class;

    protected $listeners = ['refreshInstallations' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // $this->setDebugEnabled();
        $this->setQueryStringDisabled();
        $this->setFiltersDisabled();
    }

    public function columns(): array
    {
        return [
         //   Column::make("Id", "id")->sortable(),
            Column::make("Domain", "domain"),
            Column::make("User", "user"),
            Column::make("Path", "path"),
            Column::make("Version", "version"),
           // Column::make("Symlink", "is_symlink"),
        //    Column::make("PHP", "php_version"),
        //    Column::make("Created at", "created_at")->sortable(),
         //   Column::make("Updated at", "updated_at")->sortable(),
        ];
    }

    public function builder() : Builder
    {
        $query = AppInstallation::query();

        if ($this->hasSearch()) {
            $search = $this->getSearch();
            $search = trim(strtolower($search));
            $query->whereRaw('LOWER(`domain`) LIKE ? ',['%'.$search.'%']);
            $query->orWhereRaw('LOWER(`user`) LIKE ? ',['%'.$search.'%']);
            $query->orWhereRaw('LOWER(`document_root`) LIKE ? ',['%'.$search.'%']);
            $query->orWhereRaw('LOWER(`home_dir`) LIKE ? ',['%'.$search.'%']);
        }

        $query->orderBy('created_at','asc');

        return $query;
    }
}
