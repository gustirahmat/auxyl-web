<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Modules\Shipment\Entities\OrderDelivery;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDeliveriesDataTable extends DataTable
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
            ->addColumn('action', function ($delivery) {
                $btn = '<div class="btn-group" role="group" aria-label="Group Button ' . $delivery->order_id .'">
                            <a href="' . route('order.show', $delivery->order_id) . '">
                                <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                            </a>';
                if ($delivery->relatedOrder->order_latest_status == 2) {
                    $btn .= '<a href="' . route('shipment.edit', $delivery->delivery_id) . '">
                                <button type="button" class="btn btn-secondary mx-1">Update Resi</button>
                            </a>';
                }
                if ($delivery->relatedOrder->order_latest_status == 3) {
                    $btn .= '<a href="' . route('shipment.edit', $delivery->delivery_id) . '">
                                <button type="button" class="btn btn-secondary mx-1">Update Pengiriman</button>
                            </a>';
                }
                $btn .= '</div>';
                return $btn;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param OrderDelivery $model
     * @return Builder
     */
    public function query(OrderDelivery $model): Builder
    {
        return $model->newQuery()
            ->with('relatedOrder')
            ->whereHas('relatedOrder', function (Builder $query) {
                $query->where('order_latest_status', '>=', 2);
                $query->where('order_latest_status', '<=', 4);
            });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
                    ->setTableId('orderdeliveries-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1, 'ASC')
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
            Column::make('delivery_id')->hidden(),
            Column::make('related_order.order_no')->title('Order No'),
            Column::make('delivery_order_number')->title('Nomor Resi'),
            Column::make('delivery_act_date')->title('Tgl Kirim'),
            Column::make('delivery_contact_name')->title('Penerima'),
            Column::make('delivery_contact_phone')->title('Kontak'),
            Column::make('delivery_kecamatan')->title('Kecamatan Tujuan'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'OrderDeliveries_' . date('YmdHis');
    }
}
