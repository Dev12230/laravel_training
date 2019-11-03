<?php

namespace App\DataTables;

use App\Folder;
use App\Staff;
use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;

class FoldersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('name', 'folders.folder-image')
            ->addColumn('action', 'folders.actions')
            ->rawColumns(['name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Folder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Folder $model)
    {
        auth()->user()->hasRole('Admin') ?
        $folders= $model->newQuery() : $folders=Auth::user()->staff->folders();
        return $folders;
    }
    

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('export')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [ 'data' => 'name', 'name' => 'name', 'title' => 'Name',],
            [ 'data' => 'description', 'name' => 'description', 'title' => 'Description'],
            [ 'data' => 'action', 'name' => 'action', 'title' => 'Action']
        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Folders_' . date('YmdHis');
    }
}
