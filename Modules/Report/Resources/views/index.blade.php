@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Laporan Laba Rugi</h5>
                        <p class="card-subtitle">Periode {{ today()->translatedFormat('F Y') }}</p>
                    </div>
                    <button type="button"
                            class="btn btn-outline-primary"
                            onclick="printJS('tblReport', 'html')"
                    >
                        <i class="bi bi-printer"></i>
                        Print Form
                    </button>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="table-responsive" id="tblReport">
                    <table class="table table-striped table-hover table-bordered" style="width: 100%">
                        <thead class="sr-only d-print-block">
                        <tr>
                            <th colspan="2">Laporan Laba Rugi</th>
                        </tr>
                        <tr>
                            <th colspan="2">Periode {{ today()->translatedFormat('F Y') }}</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th colspan="2" style="text-align: left">Penjualan</th>
                        </tr>
                        <tr>
                            <td>Penjualan Bersih</td>
                            <th class="text-right" style="text-align: right">{{ number_format($orders->sum('order_total') ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Dikurangi : Retur Penjualan</td>
                            <th class="text-right" style="text-align: right">{{ number_format($orders->where('order_latest_status', '=', 6)->sum('order_total') ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Penjualan Bersih</td>
                            <th class="text-right" style="text-align: right">{{ number_format($orders->where('order_latest_status', '=', 5)->sum('order_total') - $orders->where('order_latest_status', '=', 6)->sum('order_total') ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Harga Pokok Penjualan (HPP)</td>
                            <th class="text-right" style="text-align: right">{{ number_format($hpp ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Laba Kotor</td>
                            <th class="text-right" style="text-align: right">{{ number_format(($orders->where('order_latest_status', '=', 5)->sum('order_total') - $orders->where('order_latest_status', '=', 6)->sum('order_total')) - $hpp ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align: left">Beban Operasional</th>
                        </tr>
                        <tr>
                            <td>Beban Upah dan Gaji</td>
                            <th class="text-right" style="text-align: right">{{ number_format(3000000, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Beban Iklan</td>
                            <th class="text-right" style="text-align: right">{{ number_format(0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Total Biaya Operasional</td>
                            <th class="text-right" style="text-align: right">{{ number_format(3000000, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align: left">Pengeluaran dan Kerugian Lainnya</th>
                        </tr>
                        <tr>
                            <td>Kerugian Karena Retur Penjualan</td>
                            <th class="text-right" style="text-align: right">{{ number_format($orders->where('order_latest_status', '=', 6)->count() * 20000 ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left">Pendapatan Bersih</th>
                            <th class="text-right" style="text-align: right">
                                @php
                                    $gross_profit = ($orders->where('order_latest_status', '=', 5)->sum('order_total') - $orders->where('order_latest_status', '=', 6)->sum('order_total')) - $hpp;
                                    $operational_cost = 3000000;
                                    $loss = $orders->where('order_latest_status', '=', 6)->count() * 20000;
                                    $nett_profit = $gross_profit - ($operational_cost + $loss)
                                @endphp
                                {{ number_format($nett_profit ?? 0, 0, ',', '.') }}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
@endpush
