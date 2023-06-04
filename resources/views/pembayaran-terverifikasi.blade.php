@extends('template3')
@section('title', 'Transaksi Sukses')

@section('navbar')
@endsection

@section('konten')
@php
    $url = Request::url();
    $idTransaksi = intval(substr($url, strrpos($url, '/') + 1));
    $idFormatted = "AP" . str_pad($idTransaksi, 7, "0", STR_PAD_LEFT);
@endphp

<div class="kotak-hitam">
    <div class="transfer-virtual-account">Transaksi {{ $idFormatted }} Sukses</div>
    <img src="{{ asset('images/sukses.png') }}" alt="sukses" class="sukses-img" width="918" height="362">
    <div class="text">Pembayaran Anda Telah Berhasil. Silahkan Cek PRT Anda Di Daftar Pekerja. Berikut Ini Adalah Total Poin Yang Anda Dapatkan:

    </div>
    <div class="TempatCoin">
        <img src="{{ asset('images/coin.png') }}" alt="coin" class="coin">
        <div id="hasilpoin" class="hasilpoin">{{ number_format(session('poin'), 0, ',', '.') }} AP Poin</div>
    </div>



    <div class="button-group">
        <button id="kembali-button" class="lanjutkan-pembayaran">Kembali ke Dashboard</button>
    </div>
</div>
@endsection


@section('footer')
@endsection

@push('scripts')
<script>
    document.getElementById('kembali-button').addEventListener('click', function() {
        window.location.href = "{{ route('dashboard') }}";
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pembayaran-terverifikasi.css') }}">
@endpush
