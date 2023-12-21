@php
    $menus = [
        'dashboard' => [
            'title' => 'Dashboard',
            'url' => route('dashboard'),
            'icon' => 'home',
            'name' => 'dashboard',
        ],
        'project' => [
            'title' => 'Projects',
            'url' => route('projects'),
            'icon' => 'briefcase',
            'name' => 'project',
        ],
        'tagihan' => [
            'title' => 'Tagihan',
            'url' => route('tagihan'),
            'icon' => 'alert-triangle',
            'name' => 'tagihan',
        ],
        // 'keuangan-perusahaan' =>  [
        //     'title'  => 'Keuangan Perusahaan',
        //     'url'    => route('keuangan-perusahaan.index'),
        //     'icon'   => 'home',
        //     'name'   => 'keuangan-perusahaan',
        // ],
        'keuangan-umum' => [
            'title' => 'Keuangan Umum',
            'url' => route('keuangan-umum.index'),
            'icon' => 'dollar-sign',
            'name' => 'keuangan-umum',
        ],
        // 'keuangan-umum' =>  [
        //     'title'  => 'Keuangan Umum',
        //     'url'    => route('keuangan-umum.index'),
        //     'icon'   => 'home',
        //     'name'   => 'keuangan-umum',
        // ],
        'devider',
        'teams' => [
            'title' => 'Teams',
            'url' => route('teams.index'),
            'icon' => 'users',
            'name' => 'teams',
        ],
        'category-project' => [
            'title' => 'Project Category',
            'url' => route('category-project.index'),
            'icon' => 'layout',
            'name' => 'category-project',
        ],
        'skill' => [
            'title' => 'Skills',
            'url' => route('skill.index'),
            'icon' => 'hexagon',
            'name' => 'skill',
        ],
        'client' => [
            'title' => 'Client',
            'url' => route('client.index'),
            'icon' => 'user',
            'name' => 'client',
        ],
        'devider',
        'profile' => [
            'title' => 'Profile',
            'url' => route('profile.edit'),
            'icon' => 'user',
            'name' => 'profile',
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

<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="logo" class="w-14" src="{{ asset('dist/images/mahir-logo.png') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class=" py-5 hidden">
        @foreach ($menus as $index => $menu)
            @if ($menu == 'devider')
                <div class="side-nav__devider my-6"></div>
            @else
                @if (empty($menu['children']))
                    <li class="hover:bg-theme-20">
                        <a href="{{ $menu['url'] }}" class="menu menu--active hover:bg-theme-20">
                            <div class="menu__icon"> <i data-feather="{{ $menu['icon'] }}"></i> </div>
                            <div class="menu__title"> {{ $menu['title'] }} </div>
                        </a>
                    </li>
                @else
                    <li class="hover:bg-theme-20">
                        <a href="javascript:;" class="menu menu--active hover:bg-theme-20">
                            <div class="menu__icon"> <i data-feather="layout"></i> </div>
                            <div class="menu__title"> {{ $menu['title'] }} <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @foreach ($menu['children'] as $item)
                                <li>
                                    <a href="{{ $item['url'] }}" class="menu">
                                        <div class="menu__icon"> <i data-feather="{{ $item['icon'] }}"></i> </div>
                                        <div class="menu__title"> {{ $item['title'] }} </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</div>
<!-- END: Mobile Menu -->
