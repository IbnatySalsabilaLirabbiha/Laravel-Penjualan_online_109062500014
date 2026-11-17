@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="card">
    <div class="checkout-layout">
        <div>
            @if($product->image)
                <img class="thumb" style="height:340px" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <div class="thumb" style="height:340px"></div>
            @endif
        </div>
        <div>
            <div class="muted">{{ $product->category->name }} | {{ $product->sku }}</div>
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <p class="price">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
            <p>Stok tersedia: {{ $product->stock }}</p>

            @auth
                @if(auth()->user()->role === 'customer' && $product->stock > 0)
                    <form method="POST" action="{{ route('cart.store', $product) }}">
                        @csrf
                        <label style="display: block; margin-bottom: 10px;">
                            Jumlah
                            <input class="input" style="max-width:120px; display: block; margin-top: 5px;" type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1">
                        </label>
                        <button class="btn" type="submit">Tambah ke Keranjang</button>
                    </form>
                @elseif($product->stock === 0)
                    <p class="badge cancelled">Stok habis. Cek kembali nanti.</p>
                @endif
            @else
                <p>
                    <a href="{{ route('login') }}">Login</a> untuk berbelanja.
                </p>
            @endauth
        </div>
    </div>
</div>
@endsection