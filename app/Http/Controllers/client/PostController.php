<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($alias)
    {

        $post_category = PostCategory::where([
            ['alias', '=', $alias],
            ['status', true]
        ])->orderBy('order', 'asc')
        ->firstOrFail();

        $title_seo = $post_category->name;
        $breadcrumbs = [
            'Trang chủ' => route('home'),
            $post_category->name => null
        ];

        $breadcrumbs_title = $post_category->name;

        $posts = Post::where([
            ['post_category_id', $post_category->id],
            ['status', true]
        ])
        ->orderBy('order', 'asc')
        ->paginate(5);

        $posts_featured = Post::where([
            ['post_category_id', $post_category->id],
            ['status', true],
            ['is_featured', true]
        ])->orderBy('order', 'asc')
        ->get();

        return view(
            'client.pages.post',
            compact(
                'title_seo',
                'breadcrumbs',
                'breadcrumbs_title',
                'post_category',
                'posts',
                'posts_featured'
            )
        );
    }

    public function singlePost($post_cat_alias, $post_alias)
    {

        $post_category = PostCategory::where([
            ['alias', '=', $post_cat_alias],
            ['status', true]
        ])->firstOrFail();

        $post = Post::where([
            ['alias', $post_alias],
            ['status', true]
        ])->firstOrFail();

        // tăng lên 1 đơn vị
        $post->increment('histotal', 1);

        $breadcrumbs = [
            'Trang chủ' => route('home'),
            $post_category->name => route('client.post.category', ['post_category_alias' => $post_category->alias]),
            $post->title => null
        ];
        $breadcrumbs_title = $post_category->name;

        $posts_featured = Post::where([
            ['post_category_id', $post_category->id],
            ['status', true],
            ['is_featured', true]
        ])->orderBy('order', 'asc')
        ->get();

        return view(
            'client.pages.single-post',
            compact(
                'breadcrumbs',
                'breadcrumbs_title',
                'post',
                'posts_featured'
            )
        );
    }
}
