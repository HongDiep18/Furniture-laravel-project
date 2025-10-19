<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('admin.partials.sidebar', function ($view) {
            $menus = [
                [
                    'name' => 'Bảng điều khiển',
                    'icon' => '<i class="bi bi-speedometer2"></i>',
                    'route' => 'admin.dashboard',
                    'active' => ['admin.dashboard'],
                ],
                [
                    'section' => 'Quản lý dữ liệu',
                ],
                [
                    'name' => 'Cấu hình',
                    'icon' => '<i class="bi bi-gear-wide-connected"></i>',
                    'route' => 'admin.config',
                    'active' => ['admin.config'],
                ],
                [
                    'name' => 'Danh mục sản phẩm',
                    'icon' => '<i class="bi bi-menu-button-wide"></i>',
                    'submenu' => [
                        [
                            'name' => 'Danh sách danh mục',
                            'route' => 'admin.category.product',
                            'active' => ['admin.category.product'],
                        ],
                        [
                            'name' => 'Thêm danh mục',
                            'route' => 'admin.category.product.add',
                            'active' => ['admin.category.product.add'],
                        ],
                    ],
                    'active' => ['admin.category.product*'],
                ],
                [
                    'name' => 'Sản phẩm',
                    'icon' => '<i class="bi bi-bag"></i>',
                    'submenu' => [
                        [
                            'name' => 'Danh sách sản phẩm',
                            'route' => 'admin.product',
                            'active' => ['admin.product'],
                        ],
                        [
                            'name' => 'Thêm sản phẩm',
                            'route' => 'admin.product.add',
                            'active' => ['admin.product.add'],
                        ],
                        [
                            'name' => 'Đánh giá',
                            'route' => 'admin.comment',
                            'active' => ['admin.comment'],
                        ],
                        [
                            'name' => 'Doanh thu',
                            'route' => 'admin.product.revenue',
                            'active' => ['admin.product.revenue'],
                        ],
                    ],
                    'active' => ['admin.product*', 'admin.comment*'],
                ],
                [
                    'name' => 'Đơn hàng',
                    'icon' => '<i class="bi bi-bag-check"></i>',
                    'route' => 'admin.order',
                    'active' => ['admin.order*'],
                ],
                [
                    'name' => 'Menu',
                    'icon' => '<i class="bi bi-list"></i>',
                    'submenu' => [
                        [
                            'name' => 'Danh sách menu',
                            'route' => 'admin.menu',
                            'active' => ['admin.menu'],
                        ],
                        [
                            'name' => 'Thêm menu',
                            'route' => 'admin.menu.add',
                            'active' => ['admin.menu.add'],
                        ],
                    ],
                    'active' => ['admin.menu*'],
                ],
                [
                    'name' => 'Bài viết',
                    'icon' => '<i class="bi bi-pencil-square"></i>',
                    'submenu' => [
                        [
                            'name' => 'Danh mục bài viết',
                            'route' => 'admin.category.post',
                            'active' => ['admin.category.post'],
                        ],
                        [
                            'name' => 'Bài viết',
                            'route' => 'admin.post',
                            'active' => ['admin.post'],
                        ],
                        [
                            'name' => 'Thêm bài viết',
                            'route' => 'admin.post.add',
                            'active' => ['admin.post.add'],
                        ],
                    ],
                    'active' => ['admin.category.post*', 'admin.post*'],
                ],
                [
                    'name' => 'Khách hàng',
                    'icon' => '<i class="bi bi-people-fill"></i>',
                    'submenu' => [
                        [
                            'name' => 'Danh sách khách hàng',
                            'route' => 'admin.user',
                            'active' => ['admin.user'],
                        ],
                    ],
                    'active' => ['admin.user*'],
                ],
                [
                    'name' => 'Email',
                    'icon' => '<i class="bi bi-envelope-fill"></i>',
                    'submenu' => [
                        [
                            'name' => 'Email đăng ký',
                            'route' => 'admin.email.subscribers',
                            'active' => ['admin.email.subscribers'],
                        ],
                        [
                            'name' => 'Email',
                            'route' => 'admin.email.templates',
                            'active' => ['admin.email.templates'],
                        ],
                        [
                            'name' => 'Nhật ký',
                            'route' => 'admin.email.logs',
                            'active' => ['admin.email.logs'],
                        ],
                    ],
                    'active' => ['admin.email*'],
                ],
                [
                    'name' => 'Hình ảnh',
                    'icon' => '<i class="bi bi-images"></i>',
                    'route' => 'admin.image',
                    'active' => ['admin.image'],
                ],
                [
                    'name' => 'Tỉnh thành phố',
                    'icon' => '<i class="bi bi-geo-alt-fill"></i>',
                    'submenu' => [
                        [
                            'name' => 'Tỉnh/thành phố',
                            'route' => 'admin.address.province',
                            'active' => ['admin.address.province'],
                        ],
                        [
                            'name' => 'Quận/huyện',
                            'route' => 'admin.address.district',
                            'active' => ['admin.address.district'],
                        ]
                    ],
                    'active' => ['admin.address*'],
                ],
            ];

            $view->with('menus', $menus);
        });
    }
}
