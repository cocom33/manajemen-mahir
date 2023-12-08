@php
    $menus = [
        'dashboard' =>  [
            'title'  => 'Dashboard',
            'url'    => route('dashboard'),
            'icon'   => 'home',
            'name'   => 'dashboard',
        ],
        'project' =>  [
            'title'  => 'Projects',
            'url'    => route('projects'),
            'icon'   => 'briefcase',
            'name'   => 'project',
        ],
        'tagihan' =>  [
            'title'  => 'Tagihan',
            'url'    => route('tagihan'),
            'icon'   => 'alert-triangle',
            'name'   => 'tagihan',
        ],
        'keuangan-perusahaan' =>  [
            'title'  => 'Keuangan Perusahaan',
            'url'    => route('keuangan-perusahaan.index'),
            'icon'   => 'home',
            'name'   => 'keuangan-perusahaan',
        ],
        'keuangan-umum' =>  [
            'title'  => 'Keuangan Umum',
            'url'    => route('keuangan-umum.index'),
            'icon'   => 'dollar-sign',
            'name'   => 'keuangan-umum',
        ],
        'devider',
        'teams' =>  [
            'title'  => 'Teams',
            'url'    => route('teams.index'),
            'icon'   => 'users',
            'name'   => 'teams',
        ],
        'category-project' =>  [
            'title'  => 'Project Category',
            'url'    => route('category-project.index'),
            'icon'   => 'layout',
            'name'   => 'category-project'
        ],
        'skill' =>  [
            'title'  => 'Skills',
            'url'    => route('skill.index'),
            'icon'   => 'hexagon',
            'name'   => 'skill'
        ],
        'client' =>  [
            'title'  => 'Client',
            'url'    => route('client.index'),
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
        // 'user' =>  [
        //     'title'  => 'User',
        //     'url'    => route('profile.edit'),
        //     'icon'   => 'user',
        //     'name'   => 'profile',
        // ],
        // 'team' =>  [
        //     'title'  => 'asd',
        //     'icon'   => 'user',
        //     'name'   => 'team.index',
        //     'children' => [
        //         [
        //             'title'  => 'tes 11',
        //             'url'    => route('client.index'),
        //             'icon'   => 'activity',
        //             'name'   => 'client',
        //         ],
        //         [
        //             'title'  => 'tes 2',
        //             'url'    => route('client.index'),
        //             'icon'   => 'activity',
        //             'name'   => 'client',
        //         ],
        //     ]
        // ],
    ];
@endphp

<!-- BEGIN: Side Menu -->
<nav class="side-nav" id="side-menu">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="logo" class="w-24" src="{{ asset('dist/images/mahir-logo.png') }}">
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        @foreach ($menus as $index => $menu)
            @if ($menu == 'devider')
                <div class="side-nav__devider my-6"></div>
            @else
                @if (empty($menu['children']))
                    <li>
                        <a href="{{ $menu['url'] }}" class="side-menu {{ Request::is($menu['name']."*") ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="{{ $menu['icon'] }}"></i> </div>
                            <div class="side-menu__title"> {{ $menu['title'] }} </div>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="javascript:;" class="side-menu {{ Request::is($menu['name'] ) ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                            <div class="side-menu__title"> {{ $menu['title'] }} <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="{{ Request::is($menu['name'] ) ? 'side-menu__sub-open' : '' }}">
                            @foreach ($menu['children'] as $item)
                                <li>
                                    <a href="{{ $item['url'] }}" class="{{ Request::is( $item['name'] ) ? 'side-menu side-menu--active' : 'side-menu' }}">
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
        <li class="side-nav__devider my-6"></li>
    </ul>
</nav>
<!-- END: Side Menu -->
