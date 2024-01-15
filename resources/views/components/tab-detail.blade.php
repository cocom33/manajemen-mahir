@props(['page', 'slug', 'active' => 'bg-theme-40 text-white shadow-md font-bold'])

<div class="flex w-full justify-between rounded-md border-2">
    <a href="{{ route('project.detail', $slug) }}"
        class="flex justify-center w-full rounded-md py-3 @if ($page == 'detail') {{ $active }} @endif ">
        <div class="flex items-center m-auto">
            <i data-feather="eye" class="w-5 h-5 mr-2"></i>
            <span>Detail</span>
        </div>
    </a>
    <a href="{{ route('project.team', $slug) }}"
        class="flex justify-center w-full rounded-md py-3  @if ($page == 'team') {{ $active }} @endif">
        <div class="flex items-center m-auto">
            <i data-feather="users" class="w-5 h-5 mr-2"></i>
            <span>Team</span>
        </div>
    </a>
    <a href="{{ route('project.pemasukan', $slug) }}"
        class="flex justify-center w-full rounded-md py-3  @if ($page == 'fee') {{ $active }} @endif">
        <div class="flex items-center m-auto">
            <i data-feather="dollar-sign" class="w-5 h-5 mr-2"></i>
            <span>Pemasukan</span>
        </div>
    </a>
    {{-- <a href="{{ route('project.tagihan', $slug) }}"
        class="flex justify-center w-full rounded-md py-3  @if ($page == 'tagihan') {{ $active }} @endif">
        <div class="flex items-center m-auto">
            <i data-feather="alert-triangle" class="w-5 h-5 mr-2"></i>
            <span>Tagihan</span>
        </div>
    </a> --}}
    <a href="{{ route('project.pengeluaran', $slug) }}"
        class="flex justify-center w-full rounded-md py-3  @if ($page == 'pengeluaran') {{ $active }} @endif">
        <div class="flex items-center m-auto">
            <i data-feather="activity" class="w-5 h-5 mr-2"></i>
            <span>Pengeluaran</span>
        </div>
    </a>
    <a href="{{ route('project.lampiran', $slug) }}"
        class="flex justify-center w-full rounded-md py-3  @if ($page == 'lampiran') {{ $active }} @endif">
        <div class="flex items-center m-auto">
            <i data-feather="paperclip" class="w-5 h-5 mr-2"></i>
            <span>Lampiran</span>
        </div>
    </a>
    <a href="{{ route('project.laporan', $slug) }}"
        class="flex justify-center w-full rounded-md py-3  @if ($page == 'laporan') {{ $active }} @endif">
        <div class="flex items-center m-auto">
            <i data-feather="activity" class="w-5 h-5 mr-2"></i>
            <span>Laporan</span>
        </div>
    </a>
</div>
