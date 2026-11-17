@extends('layouts.admin')

@section('title', 'Stok & Barang Masuk')

@section('content')
<div class="row" style="justify-content:space-between">
    <h1>Stok & Barang Masuk</h1>
    <a class="btn" href="{{ route('admin.stock.create') }}">Barang Masuk</a>
</div>

<div class="card">
    <div class="table-scroll">
        <table>
            <tr>
                <th>Waktu</th>
                <th>Produk</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Referensi</th>
            </tr>
            @foreach($movements as $m)
            <tr>
                <td>{{ $m->created_at }}</td>
                <td>{{ $m->product->name ?? '-' }}</td>
                <td>{{ $m->type }}</td>
                <td>{{ $m->quantity }}</td>
                <td>{{ $m->reference ?? '-' }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div style="margin-top:16px">{{ $movements->links() }}</div>
</div>
@endsection