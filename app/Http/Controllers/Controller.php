<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function gaji($project)
    {
        $data['fee'] = 0;
        $data['piutang'] = 0;
        $data['termin'] = [];
        $data['type_piutang'] = '';
        $data['belanja'] = $project->pengeluaran->sum('price');
        if ($project->keuangan_project && $project->keuangan_project->type == 'termin') {
            foreach ($project->keuangan_project->termin as $value) {
                $data['fee'] = $data['fee'] + $value->termin_fee->sum('fee');
            }
            $data['termin'] = $project->keuangan_project->termin;
            $data['piutang'] = $data['termin']->sum('price') - $data['termin']->where('status', 1)->sum('price');
            $data['type_piutang'] = 'termin';
        }
        if ($project->keuangan_project && $project->keuangan_project->type == 'langsung') {
            $data['piutang'] = $project->keuangan_project->langsung->sum('fee');
            $data['fee'] = $project->keuangan_project->langsung->sum('fee');
            $data['type_piutang'] = 'langsung';
        }

        $data['deal'] = $project->harga_deal;
        if ($project->type_pajak == 1) {
            $data['deal'] = $project->harga_deal + $project->pajak;
        }

        $data['type_pajak'] = $project->type_pajak;

        return $data;
    }

    /**
     * Determine active menu & submenu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activeMenu($layout, $pageName)
    {
        $firstPageName = '';
        $secondPageName = '';
        $thirdPageName = '';

        if ($layout == 'top-menu') {
            foreach ($this->topMenu() as $menu) {
                if ($menu['page_name'] == $pageName && empty($firstPageName)) {
                    $firstPageName = $menu['page_name'];
                }

                if (isset($menu['sub_menu'])) {
                    foreach ($menu['sub_menu'] as $subMenu) {
                        if ($subMenu['page_name'] == $pageName && empty($secondPageName) && $subMenu['page_name'] != 'dashboard') {
                            $firstPageName = $menu['page_name'];
                            $secondPageName = $subMenu['page_name'];
                        }

                        if (isset($subMenu['sub_menu'])) {
                            foreach ($subMenu['sub_menu'] as $lastSubmenu) {
                                if ($lastSubmenu['page_name'] == $pageName) {
                                    $firstPageName = $menu['page_name'];
                                    $secondPageName = $subMenu['page_name'];
                                    $thirdPageName = $lastSubmenu['page_name'];
                                }
                            }
                        }
                    }
                }
            }
        } else if ($layout == 'simple-menu') {
            foreach ($this->simpleMenu() as $menu) {
                if ($menu !== 'devider' && $menu['page_name'] == $pageName && empty($firstPageName)) {
                    $firstPageName = $menu['page_name'];
                }

                if (isset($menu['sub_menu'])) {
                    foreach ($menu['sub_menu'] as $subMenu) {
                        if ($subMenu['page_name'] == $pageName && empty($secondPageName) && $subMenu['page_name'] != 'dashboard') {
                            $firstPageName = $menu['page_name'];
                            $secondPageName = $subMenu['page_name'];
                        }

                        if (isset($subMenu['sub_menu'])) {
                            foreach ($subMenu['sub_menu'] as $lastSubmenu) {
                                if ($lastSubmenu['page_name'] == $pageName) {
                                    $firstPageName = $menu['page_name'];
                                    $secondPageName = $subMenu['page_name'];
                                    $thirdPageName = $lastSubmenu['page_name'];
                                }
                            }
                        }
                    }
                }
            }
        } else {
            foreach ($this->sideMenu() as $menu) {
                if ($menu !== 'devider' && $menu['page_name'] == $pageName && empty($firstPageName)) {
                    $firstPageName = $menu['page_name'];
                }

                if (isset($menu['sub_menu'])) {
                    foreach ($menu['sub_menu'] as $subMenu) {
                        if ($subMenu['page_name'] == $pageName && empty($secondPageName) && $subMenu['page_name'] != 'dashboard') {
                            $firstPageName = $menu['page_name'];
                            $secondPageName = $subMenu['page_name'];
                        }

                        if (isset($subMenu['sub_menu'])) {
                            foreach ($subMenu['sub_menu'] as $lastSubmenu) {
                                if ($lastSubmenu['page_name'] == $pageName) {
                                    $firstPageName = $menu['page_name'];
                                    $secondPageName = $subMenu['page_name'];
                                    $thirdPageName = $lastSubmenu['page_name'];
                                }
                            }
                        }
                    }
                }
            }
        }

        return [
            'first_page_name' => $firstPageName,
            'second_page_name' => $secondPageName,
            'third_page_name' => $thirdPageName
        ];
    }

    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sideMenu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'layout' => 'side-menu',
                'page_name' => 'dashboard',
                'title' => 'Dashboard'
            ],
            'contoh' => [
                'icon' => 'box',
                'layout' => 'side-menu',
                'page_name' => 'contoh',
                'title' => 'Contoh'
            ],
            'project' => [
                'icon' => 'box',
                'layout' => 'side-menu',
                'page_name' => 'project',
                'title' => 'List Project'
            ],
            'keuangan perusahaan' => [
                'icon' => 'box',
                'layout' => 'side-menu',
                'page_name' => 'keuangan-perusahaan',
                'title' => 'Keuangan Perusahaan'
            ],
            'keuangan umum' => [
                'icon' => 'box',
                'layout' => 'side-menu',
                'page_name' => 'keuangan-umum',
                'title' => 'Keuangan Umum'
            ],
            'client' => [
                'icon' => 'box',
                'layout' => 'side-menu',
                'page_name' => 'client.index',
                'title' => 'Client'
            ],
            'project type' => [
                'icon' => 'box',
                'layout' => 'side-menu',
                'page_name' => 'category-project',
                'title' => 'Project Type'
            ],
            // 'menu-layout' => [
            //     'icon' => 'box',
            //     'page_name' => 'menu-layout',
            //     'title' => 'Menu Layout',
            //     'sub_menu' => [
            //         'side-menu' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'dashboard',
            //             'title' => 'Side Menu'
            //         ],
            //         'simple-menu' => [
            //             'icon' => '',
            //             'layout' => 'simple-menu',
            //             'page_name' => 'dashboard',
            //             'title' => 'Simple Menu'
            //         ],
            //         'top-menu' => [
            //             'icon' => '',
            //             'layout' => 'top-menu',
            //             'page_name' => 'dashboard',
            //             'title' => 'Top Menu'
            //         ]
            //     ]
            // ],
            // 'inbox' => [
            //     'icon' => 'inbox',
            //     'layout' => 'side-menu',
            //     'page_name' => 'inbox',
            //     'title' => 'Inbox'
            // ],
            // 'file-manager' => [
            //     'icon' => 'hard-drive',
            //     'layout' => 'side-menu',
            //     'page_name' => 'file-manager',
            //     'title' => 'File Manager'
            // ],
            // 'point-of-sale' => [
            //     'icon' => 'credit-card',
            //     'layout' => 'side-menu',
            //     'page_name' => 'point-of-sale',
            //     'title' => 'Point of Sale'
            // ],
            // 'chat' => [
            //     'icon' => 'message-square',
            //     'layout' => 'side-menu',
            //     'page_name' => 'chat',
            //     'title' => 'Chat'
            // ],
            // 'post' => [
            //     'icon' => 'file-text',
            //     'layout' => 'side-menu',
            //     'page_name' => 'post',
            //     'title' => 'Post'
            // ],
            // 'devider',
            // 'crud' => [
            //     'icon' => 'edit',
            //     'page_name' => 'crud',
            //     'title' => 'Crud',
            //     'sub_menu' => [
            //         'crud-data-list' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'crud-data-list',
            //             'title' => 'Data List'
            //         ],
            //         'crud-form' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'crud-form',
            //             'title' => 'Form'
            //         ]
            //     ]
            // ],
            // 'users' => [
            //     'icon' => 'users',
            //     'page_name' => 'users',
            //     'title' => 'Users',
            //     'sub_menu' => [
            //         'users-layout-1' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'users-layout-1',
            //             'title' => 'Layout 1'
            //         ],
            //         'users-layout-2' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'users-layout-2',
            //             'title' => 'Layout 2'
            //         ],
            //         'users-layout-3' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'users-layout-3',
            //             'title' => 'Layout 3'
            //         ]
            //     ]
            // ],
            // 'profile' => [
            //     'icon' => 'trello',
            //     'page_name' => 'profile',
            //     'title' => 'Profile',
            //     'sub_menu' => [
            //         'profile-overview-1' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'profile-overview-1',
            //             'title' => 'Overview 1'
            //         ],
            //         'profile-overview-2' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'profile-overview-2',
            //             'title' => 'Overview 2'
            //         ],
            //         'profile-overview-3' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'profile-overview-3',
            //             'title' => 'Overview 3'
            //         ]
            //     ]
            // ],
            // 'pages' => [
            //     'icon' => 'layout',
            //     'page_name' => 'layout',
            //     'title' => 'Pages',
            //     'sub_menu' => [
            //         'wizards' => [
            //             'icon' => '',
            //             'page_name' => 'wizards',
            //             'title' => 'Wizards',
            //             'sub_menu' => [
            //                 'wizard-layout-1' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'wizard-layout-1',
            //                     'title' => 'Layout 1'
            //                 ],
            //                 'wizard-layout-2' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'wizard-layout-2',
            //                     'title' => 'Layout 2'
            //                 ],
            //                 'wizard-layout-3' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'wizard-layout-3',
            //                     'title' => 'Layout 3'
            //                 ]
            //             ]
            //         ],
            //         'blog' => [
            //             'icon' => '',
            //             'page_name' => 'blog',
            //             'title' => 'Blog',
            //             'sub_menu' => [
            //                 'blog-layout-1' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'blog-layout-1',
            //                     'title' => 'Layout 1'
            //                 ],
            //                 'blog-layout-2' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'blog-layout-2',
            //                     'title' => 'Layout 2'
            //                 ],
            //                 'blog-layout-3' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'blog-layout-3',
            //                     'title' => 'Layout 3'
            //                 ]
            //             ]
            //         ],
            //         'pricing' => [
            //             'icon' => '',
            //             'page_name' => 'pricing',
            //             'title' => 'Pricing',
            //             'sub_menu' => [
            //                 'pricing-layout-1' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'pricing-layout-1',
            //                     'title' => 'Layout 1'
            //                 ],
            //                 'pricing-layout-2' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'pricing-layout-2',
            //                     'title' => 'Layout 2'
            //                 ]
            //             ]
            //         ],
            //         'invoice' => [
            //             'icon' => '',
            //             'page_name' => 'invoice',
            //             'title' => 'Invoice',
            //             'sub_menu' => [
            //                 'invoice-layout-1' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'invoice-layout-1',
            //                     'title' => 'Layout 1'
            //                 ],
            //                 'invoice-layout-2' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'invoice-layout-2',
            //                     'title' => 'Layout 2'
            //                 ]
            //             ]
            //         ],
            //         'faq' => [
            //             'icon' => '',
            //             'page_name' => 'faq',
            //             'title' => 'FAQ',
            //             'sub_menu' => [
            //                 'faq-layout-1' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'faq-layout-1',
            //                     'title' => 'Layout 1'
            //                 ],
            //                 'faq-layout-2' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'faq-layout-2',
            //                     'title' => 'Layout 2'
            //                 ],
            //                 'faq-layout-3' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'faq-layout-3',
            //                     'title' => 'Layout 3'
            //                 ]
            //             ]
            //         ],
            //         'login' => [
            //             'icon' => '',
            //             'layout' => 'login',
            //             'page_name' => 'login',
            //             'title' => 'Login'
            //         ],
            //         'register' => [
            //             'icon' => '',
            //             'layout' => 'login',
            //             'page_name' => 'register',
            //             'title' => 'Register'
            //         ],
            //         'error-page' => [
            //             'icon' => '',
            //             'layout' => 'main',
            //             'page_name' => 'error-page',
            //             'title' => 'Error Page'
            //         ],
            //         'update-profile' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'update-profile',
            //             'title' => 'Update profile'
            //         ],
            //         'change-password' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'change-password',
            //             'title' => 'Change Password'
            //         ]
            //     ]
            // ],
            // 'devider',
            // 'components' => [
            //     'icon' => 'inbox',
            //     'page_name' => 'components',
            //     'title' => 'Components',
            //     'sub_menu' => [
            //         'grid' => [
            //             'icon' => '',
            //             'page_name' => 'grid',
            //             'title' => 'Grid',
            //             'sub_menu' => [
            //                 'regular-table' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'regular-table',
            //                     'title' => 'Regular Table'
            //                 ],
            //                 'datatable' => [
            //                     'icon' => '',
            //                     'layout' => 'side-menu',
            //                     'page_name' => 'datatable',
            //                     'title' => 'Datatable'
            //                 ]
            //             ]
            //         ],
            //         'accordion' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'accordion',
            //             'title' => 'Accordion'
            //         ],
            //         'button' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'button',
            //             'title' => 'Button'
            //         ],
            //         'modal' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'modal',
            //             'title' => 'Modal'
            //         ],
            //         'alert' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'alert',
            //             'title' => 'Alert'
            //         ],
            //         'progress-bar' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'progress-bar',
            //             'title' => 'Progress Bar'
            //         ],
            //         'tooltip' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'tooltip',
            //             'title' => 'Tooltip'
            //         ],
            //         'dropdown' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'dropdown',
            //             'title' => 'Dropdown'
            //         ],
            //         'toast' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'toast',
            //             'title' => 'Toast'
            //         ],
            //         'typography' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'typography',
            //             'title' => 'Typography'
            //         ],
            //         'icon' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'icon',
            //             'title' => 'Icon'
            //         ],
            //         'loading-icon' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'loading-icon',
            //             'title' => 'Loading Icon'
            //         ]
            //     ]
            // ],
            // 'forms' => [
            //     'icon' => 'sidebar',
            //     'page_name' => 'forms',
            //     'title' => 'Forms',
            //     'sub_menu' => [
            //         'regular-form' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'regular-form',
            //             'title' => 'Regular Form'
            //         ],
            //         'datepicker' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'datepicker',
            //             'title' => 'Datepicker'
            //         ],
            //         'select2' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'select2',
            //             'title' => 'Select2'
            //         ],
            //         'file-upload' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'file-upload',
            //             'title' => 'File Upload'
            //         ],
            //         'wysiwyg-editor' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'wysiwyg-editor',
            //             'title' => 'Wysiwyg Editor'
            //         ],
            //         'validation' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'validation',
            //             'title' => 'Validation'
            //         ]
            //     ]
            // ],
            // 'widgets' => [
            //     'icon' => 'hard-drive',
            //     'page_name' => 'widgets',
            //     'title' => 'Widgets',
            //     'sub_menu' => [
            //         'chart' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'chart',
            //             'title' => 'Chart'
            //         ],
            //         'slider' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'slider',
            //             'title' => 'Slider'
            //         ],
            //         'image-zoom' => [
            //             'icon' => '',
            //             'layout' => 'side-menu',
            //             'page_name' => 'image-zoom',
            //             'title' => 'Image Zoom'
            //         ]
            //     ]
            // ]
        ];
    }

    /**
     * List of simple menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function simpleMenu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'layout' => 'simple-menu',
                'page_name' => 'dashboard',
                'title' => 'Dashboard'
            ],
            'menu-layout' => [
                'icon' => 'box',
                'page_name' => 'menu-layout',
                'title' => 'Menu Layout',
                'sub_menu' => [
                    'side-menu' => [
                        'icon' => '',
                        'layout' => 'side-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Side Menu'
                    ],
                    'simple-menu' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Simple Menu'
                    ],
                    'top-menu' => [
                        'icon' => '',
                        'layout' => 'top-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Top Menu'
                    ]
                ]
            ],
            'inbox' => [
                'icon' => 'inbox',
                'layout' => 'simple-menu',
                'page_name' => 'inbox',
                'title' => 'Inbox'
            ],
            'file-manager' => [
                'icon' => 'hard-drive',
                'layout' => 'simple-menu',
                'page_name' => 'file-manager',
                'title' => 'File Manager'
            ],
            'point-of-sale' => [
                'icon' => 'credit-card',
                'layout' => 'simple-menu',
                'page_name' => 'point-of-sale',
                'title' => 'Point of Sale'
            ],
            'chat' => [
                'icon' => 'message-square',
                'layout' => 'simple-menu',
                'page_name' => 'chat',
                'title' => 'Chat'
            ],
            'post' => [
                'icon' => 'file-text',
                'layout' => 'simple-menu',
                'page_name' => 'post',
                'title' => 'Post'
            ],
            'devider',
            'crud' => [
                'icon' => 'edit',
                'page_name' => 'crud',
                'title' => 'Crud',
                'sub_menu' => [
                    'crud-data-list' => [
                        'icon' => '',
                        'layout' => 'side-menu',
                        'page_name' => 'crud-data-list',
                        'title' => 'Data List'
                    ],
                    'crud-form' => [
                        'icon' => '',
                        'layout' => 'side-menu',
                        'page_name' => 'crud-form',
                        'title' => 'Form'
                    ]
                ]
            ],
            'users' => [
                'icon' => 'users',
                'page_name' => 'users',
                'title' => 'Users',
                'sub_menu' => [
                    'users-layout-1' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'users-layout-1',
                        'title' => 'Layout 1'
                    ],
                    'users-layout-2' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'users-layout-2',
                        'title' => 'Layout 2'
                    ],
                    'users-layout-3' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'users-layout-3',
                        'title' => 'Layout 3'
                    ]
                ]
            ],
            'profile' => [
                'icon' => 'trello',
                'page_name' => 'profile',
                'title' => 'Profile',
                'sub_menu' => [
                    'profile-overview-1' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'profile-overview-1',
                        'title' => 'Overview 1'
                    ],
                    'profile-overview-2' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'profile-overview-2',
                        'title' => 'Overview 2'
                    ],
                    'profile-overview-3' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'profile-overview-3',
                        'title' => 'Overview 3'
                    ]
                ]
            ],
            'pages' => [
                'icon' => 'layout',
                'page_name' => 'layout',
                'title' => 'Pages',
                'sub_menu' => [
                    'wizards' => [
                        'icon' => '',
                        'page_name' => 'wizards',
                        'title' => 'Wizards',
                        'sub_menu' => [
                            'wizard-layout-1' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'wizard-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'wizard-layout-2' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'wizard-layout-2',
                                'title' => 'Layout 2'
                            ],
                            'wizard-layout-3' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'wizard-layout-3',
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'blog' => [
                        'icon' => '',
                        'page_name' => 'blog',
                        'title' => 'Blog',
                        'sub_menu' => [
                            'blog-layout-1' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'blog-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'blog-layout-2' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'blog-layout-2',
                                'title' => 'Layout 2'
                            ],
                            'blog-layout-3' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'blog-layout-3',
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'pricing' => [
                        'icon' => '',
                        'page_name' => 'pricing',
                        'title' => 'Pricing',
                        'sub_menu' => [
                            'pricing-layout-1' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'pricing-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'pricing-layout-2' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'pricing-layout-2',
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'invoice' => [
                        'icon' => '',
                        'page_name' => 'invoice',
                        'title' => 'Invoice',
                        'sub_menu' => [
                            'invoice-layout-1' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'invoice-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'invoice-layout-2' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'invoice-layout-2',
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'faq' => [
                        'icon' => '',
                        'page_name' => 'faq',
                        'title' => 'FAQ',
                        'sub_menu' => [
                            'faq-layout-1' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'faq-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'faq-layout-2' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'faq-layout-2',
                                'title' => 'Layout 2'
                            ],
                            'faq-layout-3' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'faq-layout-3',
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'login' => [
                        'icon' => '',
                        'layout' => 'login',
                        'page_name' => 'login',
                        'title' => 'Login'
                    ],
                    'register' => [
                        'icon' => '',
                        'layout' => 'login',
                        'page_name' => 'register',
                        'title' => 'Register'
                    ],
                    'error-page' => [
                        'icon' => '',
                        'layout' => 'main',
                        'page_name' => 'error-page',
                        'title' => 'Error Page'
                    ],
                    'update-profile' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'update-profile',
                        'title' => 'Update profile'
                    ],
                    'change-password' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'change-password',
                        'title' => 'Change Password'
                    ]
                ]
            ],
            'devider',
            'components' => [
                'icon' => 'inbox',
                'page_name' => 'components',
                'title' => 'Components',
                'sub_menu' => [
                    'grid' => [
                        'icon' => '',
                        'page_name' => 'grid',
                        'title' => 'Grid',
                        'sub_menu' => [
                            'regular-table' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'regular-table',
                                'title' => 'Regular Table'
                            ],
                            'datatable' => [
                                'icon' => '',
                                'layout' => 'simple-menu',
                                'page_name' => 'datatable',
                                'title' => 'Datatable'
                            ]
                        ]
                    ],
                    'accordion' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'accordion',
                        'title' => 'Accordion'
                    ],
                    'button' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'button',
                        'title' => 'Button'
                    ],
                    'modal' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'modal',
                        'title' => 'Modal'
                    ],
                    'alert' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'alert',
                        'title' => 'Alert'
                    ],
                    'progress-bar' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'progress-bar',
                        'title' => 'Progress Bar'
                    ],
                    'tooltip' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'tooltip',
                        'title' => 'Tooltip'
                    ],
                    'dropdown' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'dropdown',
                        'title' => 'Dropdown'
                    ],
                    'toast' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'toast',
                        'title' => 'Toast'
                    ],
                    'typography' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'typography',
                        'title' => 'Typography'
                    ],
                    'icon' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'icon',
                        'title' => 'Icon'
                    ],
                    'loading-icon' => [
                        'icon' => '',
                        'layout' => 'side-menu',
                        'page_name' => 'loading-icon',
                        'title' => 'Loading Icon'
                    ]
                ]
            ],
            'forms' => [
                'icon' => 'sidebar',
                'page_name' => 'forms',
                'title' => 'Forms',
                'sub_menu' => [
                    'regular-form' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'regular-form',
                        'title' => 'Regular Form'
                    ],
                    'datepicker' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'datepicker',
                        'title' => 'Datepicker'
                    ],
                    'select2' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'select2',
                        'title' => 'Select2'
                    ],
                    'file-upload' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'file-upload',
                        'title' => 'File Upload'
                    ],
                    'wysiwyg-editor' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'wysiwyg-editor',
                        'title' => 'Wysiwyg Editor'
                    ],
                    'validation' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'validation',
                        'title' => 'Validation'
                    ]
                ]
            ],
            'widgets' => [
                'icon' => 'hard-drive',
                'page_name' => 'widgets',
                'title' => 'Widgets',
                'sub_menu' => [
                    'chart' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'chart',
                        'title' => 'Chart'
                    ],
                    'slider' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'slider',
                        'title' => 'Slider'
                    ],
                    'image-zoom' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'image-zoom',
                        'title' => 'Image Zoom'
                    ]
                ]
            ]
        ];
    }

    protected function getMenuData()
    {
        $userData = Auth::check() ? Auth::user() : null;
        $users = User::all();

        return [
            'side_menu' => $this->sideMenu(),
            'simple_menu' => $this->simpleMenu(),
            'user' => $userData,
            'users' => $users
        ];
    }
}