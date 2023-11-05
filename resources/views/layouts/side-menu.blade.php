<!-- BEGIN: Side Menu -->
<nav class="side-nav" id="side-menu">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Midone Tailwind HTML Admin Template" class="w-36" src="dist/images/mahir-logo.png">
        {{-- <span class="hidden xl:block text-white text-lg ml-3"> Mid<span class="font-medium">one</span> </span> --}}
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        @foreach ($side_menu as $menu)
            @if ($menu == 'devider')
                <li class="side-nav__devider my-6"></li>
            @else
                <li>
                    <a href="{{ isset($menu['layout']) ? route($menu['page_name']) : 'javascript:;' }}" class="{{ Request::is($menu['page_name']) ? 'side-menu side-menu--active' : 'side-menu' }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="{{ $menu['icon'] }}"></i> </div>
                        <div class="side-menu__title">
                            {{ $menu['title'] }}
                            @if (isset($menu['sub_menu']))
                                <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                            @endif
                        </div>
                    </a>
                    @if (isset($menu['sub_menu']))
                    <ul class="{{ $first_page_name == $menu['page_name'] ? 'side-menu__sub-open' : '' }}">
                        @foreach ($menu['sub_menu'] as $subMenu)
                        <li>
                            <a href="{{ isset($menu['layout']) ? route('dashboard', ['layout' => $menu['layout'], 'pageName' => $menu['page_name']]) : 'javascript:;' }}" class="{{ $first_page_name == $menu['page_name'] ? 'side-menu side-menu--active' : 'side-menu' }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="side-menu__title">
                                    {{ $subMenu['title'] }}
                                    @if (isset($subMenu['sub_menu']))
                                        <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                                    @endif
                                </div>
                            </a>
                            @if (isset($subMenu['sub_menu']))
                            <ul class="{{ $second_page_name == $subMenu['page_name'] ? 'side-menu__sub-open' : '' }}">
                                @foreach ($subMenu['sub_menu'] as $lastSubMenu)
                                <li>
                                    <a href="" class="side-menu">
                                        <div class="side-menu__icon"> <i data-feather="zap"></i> </div>
                                        <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</nav>
<!-- END: Side Menu -->
