<?php

namespace App\Providers;

use App\Helper\Cart;
use App\Models\Image;
use App\Models\Menu;
use App\Models\PostCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('client.*', function ($view) {
            $menus = Menu::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

            $image_breadcrumb = Image::where([
                ['type', '=', 'breadcrumb'],
                ['status', '=', true]
            ])->value('image');

            
            $carts = session('cart', []);
            $cartCount = count($carts);
            
            
            
            $view->with([
                'menus' => $menus,
                'image_breadcrumb' => $image_breadcrumb,
                'cartCount' => $cartCount
            ]);
        });

        View::composer('client.component.sidebar-post-right', function ($view) {
            $post_categories = PostCategory::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

            $view->with([
                'post_categories' => $post_categories,
            ]);
        });

        View::composer('*', function ($view) {
            $configs = get_all_configs();

            $view->with([
                'configs' => $configs
            ]);
        });
    }
}
