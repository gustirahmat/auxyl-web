<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Entities\Order;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
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
            ->addColumn('action', function ($order) {
                $btn = '<div class="btn-group" role="group" aria-label="Group Button ' . $order->order_id .'">
                            <a href="' . route('order.show', $order->order_id) . '">
                                <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                            </a>';
                if ($order->order_latest_status == 1) {
                    $btn .= '<a href="' . route('order.edit', $order->order_id) . '">
                                <button type="button" class="btn btn-secondary mx-1">Verifikasi</button>
                            </a>';
                }
                $btn .= '</div>';
                return $btn;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Order $model
     * @return Builder
     */
    public function query(Order $model): Builder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
                    ->setTableId('orders-table')
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
            Column::make('order_no'),
            Column::make('order_total'),
            Column::make('created_at'),
            Column::make('order_status')->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}
