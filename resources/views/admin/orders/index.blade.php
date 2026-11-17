@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="card">
    <h1>Daftar Pesanan Masuk</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Kode Order</th>
                <th>Pemesan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->recipient_name }}</td>
                    <td>Rp {{ number_format($order->grand_total, 2, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $order->status === 'pending' ? 'bg-warning' : 'bg-success' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a>

                        {{-- Tombol Konfirmasi (Muncul jika status pending) --}}
                        @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                            </form>
                        @endif

                        {{-- Tombol Batalkan (Muncul jika status pending atau confirmed) --}}
                        @if(in_array($order->status, ['pending', 'confirmed']))
                            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-danger">Batalkan</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada pesanan masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection