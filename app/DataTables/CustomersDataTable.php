<?php

namespace App\DataTables;

use App\Models\Customer;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query): DataTableAbstract
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($customer) {
                return '<a href="' . route('customer.show', $customer->customer_id) . '">
                            <button type="submit" class="btn btn-secondary ">Detail</button>
                        </a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
    {
        return $model->newQuery()->with('relatedUser')->withCount('relatedOrders');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        return $this->builder()
                    ->setTableId('customers-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('customer_id')->hidden(),
            Column::make('customer_name')->title('Nama'),
            Column::make('customer_phone')->title('Phone'),
            Column::make('related_user.email')->title('Email')->orderable(false),
            Column::make('customer_kecamatan')->title('Lokasi'),
            Column::make('related_orders_count')->title('Jml Pesanan'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Customers_' . date('YmdHis');
    }
}
