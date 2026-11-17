@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->code)

@section('content')
<div class="card">
    <h1>Detail Pesanan: {{ $order->code }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div style="margin-bottom: 20px;">
        <p><strong>Nama Pemesan:</strong> {{ $order->recipient_name }}</p>
        <p><strong>No. Telepon:</strong> {{ $order->phone }}</p>
        <p><strong>Alamat:</strong> {{ $order->address }}</p>
        <p><strong>Kurir & Layanan:</strong> {{ $order->shipping_courier }} - {{ $order->shipping_service }}</p>
        <p><strong>Status:</strong> <span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></p>
    </div>

    <h3>Item Pesanan</h3>
    <table class="table" style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Subtotal:</strong> Rp {{ number_format($order->subtotal, 2, ',', '.') }}</p>
    <p><strong>Ongkos Kirim:</strong> Rp {{ number_format($order->shipping_cost, 2, ',', '.') }}</p>
    <p><strong>Grand Total:</strong> Rp {{ number_format($order->grand_total, 2, ',', '.') }}</p>

    <div style="margin-top: 20px;">
        <a href="{{ route('admin.orders.index') }}" class="btn">Kembali</a>

        {{-- Tombol Konfirmasi (Jika status masih pending) --}}
        @if($order->status === 'pending')
            <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
            </form>
        @endif

        {{-- Tombol Transisi Status Bertahap (Skenario 12) --}}
        @if($order->status === 'confirmed')
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="processed">
                <button type="submit" class="btn btn-primary">Proses Pesanan (Processed)</button>
            </form>
        @elseif($order->status === 'processed')
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="shipped">
                <button type="submit" class="btn btn-info">Kirim Pesanan (Shipped)</button>
            </form>
        @elseif($order->status === 'shipped')
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="completed">
                <button type="submit" class="btn btn-success">Selesaikan Pesanan (Completed)</button>
            </form>
        @endif

        {{-- Tombol Batalkan Pesanan (Hanya jika status pending atau confirmed) --}}
        @if(in_array($order->status, ['pending', 'confirmed']))
            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
            </form>
        @endif
    </div>
</div>
@endsection