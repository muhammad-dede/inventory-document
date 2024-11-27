@extends('layouts.pdf')

@section('title', 'Form Pengambilan Barang')

@section('content')
    <h1 style="text-align: center; border: 1px solid black; padding: 10px;">
        FORM PENGAMBILAN BARANG
    </h1>
    <table style="border-spacing: 0 8px;">
        <tr>
            <td>TANGGAL</td>
            <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
            <td>{{ $date ?? '' }}</td>
        </tr>
        <tr>
            <td>SEKSI</td>
            <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
            <td>{{ $section ?? '' }}</td>
        </tr>
    </table>
    <br>
    <table style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr style="border: 1px solid black;">
                <th style="border: 1px solid black; padding: 8px;">ITEM KODE</th>
                <th style="border: 1px solid black; padding: 8px; width: 25%;">NAMA BARANG</th>
                <th style="border: 1px solid black; padding: 8px;">QTY</th>
                <th style="border: 1px solid black; padding: 8px;">SEKSI</th>
                <th style="border: 1px solid black; padding: 8px;">IN DATE</th>
                <th style="border: 1px solid black; padding: 8px;">NO PRIMARY</th>
                <th style="border: 1px solid black; padding: 8px;">PIC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ $item->product?->code ?? '-' }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px;">
                        {{ $item->product?->name ?? '-' }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ $item->qty ?? '-' }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ $item->section?->code ?? '-' }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ \Carbon\Carbon::parse($item->in_date)->format('d-m-Y') ?? '-' }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ $item->no_primary ?? '-' }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ $item->pic?->name ?? '-' }}
                    </td>
                </tr>
            @endforeach
            @if ($items->count() <= 5)
                @php
                    $total = $items->count();
                    if ($total <= 1) {
                        $padding_bottom = '35%';
                    } elseif ($total == 2) {
                        $padding_bottom = '30%';
                    } elseif ($total == 3) {
                        $padding_bottom = '25%';
                    } elseif ($total == 4) {
                        $padding_bottom = '20%';
                    } elseif ($total == 5) {
                        $padding_bottom = '15%';
                    } else {
                        $padding_bottom = '0%';
                    }
                @endphp
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; padding: 8px; padding-bottom: {{ $padding_bottom }};">
                    </td>
                    <td style="border: 1px solid black; padding: 8px; padding-bottom: {{ $padding_bottom }};">
                    </td>
                    <td style="border: 1px solid black; padding: 8px; padding-bottom: {{ $padding_bottom }};">
                    </td>
                    <td style="border: 1px solid black; padding: 8px; padding-bottom: {{ $padding_bottom }};">
                    </td>
                    <td style="border: 1px solid black; padding: 8px; padding-bottom: {{ $padding_bottom }};">
                    </td>
                    <td style="border: 1px solid black; padding: 8px; padding-bottom: {{ $padding_bottom }};">
                    </td>
                    <td style="border: 1px solid black; padding: 8px; padding-bottom: {{ $padding_bottom }};">
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>
    <table style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <td></td>
                <td style="border: 1px solid black; padding: 8px; width: 22%;">PIC</td>
                <td style="border: 1px solid black; padding: 8px; width: 22%;">SECTION HEAD</td>
                <td style="border: 1px solid black; padding: 8px; width: 22%;">PIC. Gudang</td>
                <td style="border: 1px solid black; padding: 8px; width: 22%;">Kep. Gudang</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 25%;"></td>
                <td style="border: 1px solid black; padding-bottom: 15%;"></td>
                <td style="border: 1px solid black; padding-bottom: 15%;"></td>
                <td style="border: 1px solid black; padding-bottom: 15%;"></td>
                <td style="border: 1px solid black; padding-bottom: 15%;"></td>
            </tr>
        </tbody>
    </table>
@endsection
