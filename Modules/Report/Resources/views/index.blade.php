@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Laporan Laba Rugi</h5>
                        <p class="card-subtitle">Periode {{ $month }} {{ $year }}</p>
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
                            <th colspan="2">Periode {{ $month }} {{ $year }}</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th colspan="2" style="text-align: left">Pendapatan</th>
                        </tr>
                        <tr>
                            <td class="text-muted">Penjualan Bersih</td>
                            <td class="text-muted text-right" style="text-align: right">{{ number_format(($orders->sum('order_total') ?? 0) - ($orders->sum('order_ongkir') ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left">Total Pendapatan</th>
                            <th class="text-right" style="text-align: right">{{ number_format(($orders->sum('order_total') ?? 0) - ($orders->sum('order_ongkir') ?? 0), 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align: left">Pengeluaran</th>
                        </tr>
                        <tr>
                            <td class="text-muted">Harga Pokok Penjualan (HPP)</td>
                            <td class="text-muted text-right" style="text-align: right">{{ number_format($hpp_finished ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Beban Ongkir</td>
                            <td class="text-muted text-right" style="text-align: right">{{ number_format($orders->sum('order_ongkir') ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <!-- <tr>
                            <td class="text-muted">Retur Penjualan</td>
                            <td class="text-muted text-right" style="text-align: right">{{ number_format($hpp_returned ?? 0, 0, ',', '.') }}</td>
                        </tr> -->
                        <tr>
                            <th style="text-align: left">Total Pengeluaran</th>
                            <th class="text-right" style="text-align: right">{{ number_format(($hpp_finished ?? 0) + ($orders->sum('order_ongkir') ?? 0) + ($hpp_returned ?? 0), 0, ',', '.') }}</th>
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
                                    $gross_profit = ($orders->sum('order_total') ?? 0) - ($orders->sum('order_ongkir') ?? 0);
                                    $loss = ($hpp_finished ?? 0) + ($orders->sum('order_ongkir') ?? 0) + ($hpp_returned ?? 0);
                                    $nett_profit = $gross_profit - $loss
                                @endphp
                                {{ number_format($nett_profit ?? 0, 0, ',', '.') }}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end align-items-center">
                @if($month == today()->format('F'))
                    <a href="{{ route('report.index', ['year' => today()->subMonth()->year, 'month' => today()->subMonth()->month]) }}">
                        <button type="button" class="btn btn-secondary mx-1">
                            <i class="bi bi-arrow-left"></i>
                            Bulan Sebelumnya
                        </button>
                    </a>
                @endif
                @if($month !== today()->format('F'))
                    <a href="{{ route('report.index', ['year' => today()->year, 'month' => today()->month]) }}">
                        <button type="button" class="btn btn-secondary mx-1">
                            Bulan Sekarang
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
@endpush
