@extends('template3')
@section('title', 'Daftar Pekerja')

@section('navbar')
@endsection

@section('konten')
    <div class="pekerja-container">
        <div class="pekerja-text">
            <a href="javascript:void(0);" onclick="window.history.back();">
                <img src="{{ asset('images/arrow.png') }}" alt="Arrow" class="arrow">
            </a>
            <h1 class="pekerja-anda">Pekerja Anda</h1>
        </div>
    </div>
    @php
    $user = auth()->user();
    @endphp

    <a href="{{ route('profil') }}" class="profile-link">
        <div class="kotak-hitam">
            <img src="{{ $user->profile_image ? asset('Images/Profile Image/' . $user->profile_image) : asset('images/profil.png') }}" alt="Profile Image" class="profile-image" style="border-radius: 100px;">
            <p class="halo-username">Halo, {{ Auth::user()->name }}</p>
        </div>
    </a>


    <div class="List-Pekerja">
        @php
            $userId = auth()->id();
            $pekerja = App\Models\Prt::where('user_id', $userId)
                ->whereBetween('id', [1, 269])
                ->paginate(20);
        @endphp

        @if ($pekerja->count() > 0)
            <!-- User memiliki pekerja -->
            @foreach ($pekerja as $prt)
                <div class="list-pekerja">
                    <div class="kotak-abu">
                        <?php
                        $imagePath = 'images/prt/prt' . $prt->id . '.jpg';

                        if (file_exists(public_path($imagePath))) {
                            $imageURL = asset($imagePath);
                        } else {
                            $imageURL = asset('images/person.png');
                        }
                        ?>
                        <img src="{{ $imageURL }}" alt="Profile Image" class="profile-img" style="position: absolute; width: 46px; height: 45px; left: 30px; top: 50%; transform: translateY(-50%); border-radius: 50%;">
                        @php
                        $startDate = \Carbon\Carbon::parse($prt->updated_at);
                        $elapsedDays = $startDate->diffInDays(\Carbon\Carbon::now());
                        $totalDuration = $prt->durasi * 30; // Assuming each month has 30 days
                        $remainingDays = $totalDuration - $elapsedDays;
                        $remainingText = $remainingDays > 0 ? "Tersisa {$remainingDays} hari lagi" : "0 hari lagi";
                        @endphp

                        <p class="nama-pekerja"><strong>{{ $prt->nama }}</strong> (Masa kontrak tersisa: {{ $remainingText }})</p>


                    </div>
                </div>
                <div class="tombol-detail">
                    <a href="{{ route('detailpekerja', ['id' => $prt->id]) }}">Detail</a>
                </div>
            @endforeach
        @else
            <!-- User tidak memiliki pekerja, tampilkan div class: no-prt -->
            <div class="no-prt">
                <img src="{{ asset('images/shopping.png') }}" alt="shopping" class="shopping">
                <p class="noprt-text">Anda belum memiliki PRT nih, yuk mulai cari PRT! <a href="{{ url('/pencarian') }}" style="color: #135589; font-weight: bold;">Klik Disini</a></p>
            </div>
        @endif

        <nav aria-label="...">
            <ul class="pagination pagination-sm">
                @if ($pekerja->count() > 0)
                    <!-- User memiliki pekerja, tampilkan pagination -->
                    @if ($pekerja->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $pekerja->previousPageUrl() }}" tabindex="-1"><<</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" tabindex="-1"><<</span>
                        </li>
                    @endif

                    @for ($page = 1; $page <= $pekerja->lastPage(); $page++)
                        <li class="page-item {{ $page === $pekerja->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $pekerja->url($page) }}">{{ $page }}</a>
                        </li>
                    @endfor

                    @if ($pekerja->currentPage() < $pekerja->lastPage())
                        <li class="page-item">
                            <a class="page-link" href="{{ $pekerja->nextPageUrl() }}">>></a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">>></span>
                        </li>
                    @endif
                @endif
            </ul>
        </nav>
    </div>
<div class="footer">
</div>
@endsection

@section('footer')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/daftarpekerja.css') }}">
@endpush
