@php
    $menus = [
        'dashboard' =>  [
            'title'  => 'Dashboard',
            'url'    => route('dashboard'),
            'icon'   => 'home',
            'name'   => 'dashboard',
        ],
        'project' =>  [
            'title'  => 'Project',
            'url'    => route('project'),
            'icon'   => 'home',
            'name'   => 'project',
        ],
        'keuangan-perusahaan' =>  [
            'title'  => 'Keuangan Perusahaan',
            'url'    => route('keuangan-perusahaan'),
            'icon'   => 'home',
            'name'   => 'keuangan-perusahaan',
        ],
        'keuangan-umum' =>  [
            'title'  => 'Keuangan Umum',
            'url'    => route('keuangan-umum'),
            'icon'   => 'home',
            'name'   => 'keuangan-umum',
        ],
        'devider',
        'project-type' =>  [
            'title'  => 'Project Type',
            'url'    => route('project-type'),
            'icon'   => 'home',
            'name'   => 'project-type',
        ],
        'team' =>  [
            'title'  => 'Team',
            'url'    => route('team'),
            'icon'   => 'user',
            'name'   => 'team',
        ],
        'client' =>  [
            'title'  => 'Client',
            'url'    => route('client'),
            'icon'   => 'user',
            'name'   => 'client',
        ],
        'devider',
        'profile' =>  [
            'title'  => 'Profile',
            'url'    => route('profile.edit'),
            'icon'   => 'user',
            'name'   => 'profile',
        ],
        'tasdes' =>  [
            'title'  => 'asd',
            'icon'   => 'user',
            'name'   => 'client',
            'children' => [
                [
                    'title'  => 'tes 11',
                    'url'    => route('client'),
                    'icon'   => 'activity',
                ],
                [
                    'title'  => 'tes 2',
                    'url'    => route('client'),
                    'icon'   => 'activity',
                ],
            ]
        ],
    ];
@endphp

<!-- BEGIN: Side Menu -->
<nav class="side-nav" id="side-menu">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="logo" class="w-24" src="dist/images/mahir-logo.png">
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        @foreach ($menus as $index => $menu)
            @if ($menu == 'devider')
                <div class="side-nav__devider my-6"></div>
            @else
                @if (empty($menu['children']))
                    <li>
                        <a href="{{ $menu['url'] }}" class="side-menu {{ Request::is($menu['name']) ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="{{ $menu['icon'] }}"></i> </div>
                            <div class="side-menu__title"> {{ $menu['title'] }} </div>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                            <div class="side-menu__title"> {{ $menu['title'] }} <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @foreach ($menu['children'] as $item)
                                <li>
                                    <a href="{{ $item['url'] }}" class="side-menu">
                                        <div class="side-menu__icon"> <i data-feather="{{ $item['icon'] }}"></i> </div>
                                        <div class="side-menu__title"> {{ $item['title'] }} </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endif
        @endforeach
        {{-- <li>
            <a href="{{ route('dashboard') }}" class="side-menu {{ Request::is('dashboard') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                <div class="side-menu__title"> Contoh <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
            </a>
            <ul class="">
                <li>
                    <a href="javascript:;" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Click Agi <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="side-menu-wizard-layout-1.html" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="zap"></i> </div>
                                <div class="side-menu__title">Layout 1</div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-wizard-layout-2.html" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="zap"></i> </div>
                                <div class="side-menu__title">Layout 2</div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-wizard-layout-3.html" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="zap"></i> </div>
                                <div class="side-menu__title">Layout 3</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li> --}}
        <li class="side-nav__devider my-6"></li>
    </ul>
</nav>
<!-- END: Side Menu -->
