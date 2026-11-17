@extends('layouts.admin')

@section('title', 'Tambah Barang Masuk')

@section('content')
<h1>Tambah Barang Masuk</h1>
<div class="card">
    <form method="POST" action="{{ route('admin.stock.store') }}">
        @csrf
        <label>Produk
            <select name="product_id" required>
                <option value="">Pilih Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                @endforeach
            </select>
        </label>

        <label>Jumlah (Qty)
            <input class="input" type="number" name="qty" min="1" required>
        </label>

        <label>Referensi / Keterangan
            <input class="input" name="reference" placeholder="Contoh: Faktur Masuk #01">
        </label>

        <button class="btn">Simpan</button>
    </form>
</div>
@endsection