@extends('client.index')

@section('title-seo', $title_seo . ' - ')

@section('content')

    @include('client.partials.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'breadcrumbs_title' => $breadcrumbs_title])

    <section class="posts py-4">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-8 list-post">
                    @if(isset($posts) && $posts->isNotEmpty())
                        @foreach ($posts as $post)
                            <div class="post-item mb-4">
                                <a href="{{ route('client.post', [
                                    'post_category_alias' => $post_category->alias,
                                    'post_alias' => $post->alias
                                ])}}" class="text-dark text-decoration-none">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="post-item-picture">
                                                <img src="{{ $post->image_url ?? '/images/empty-product.png' }}" width="100%" alt="">
                                            </div>
                                        </div>
                                        <div class="col-8 post-item-content">
                                            <p class="title fw-bold">{{$post->title}}</p>
                                            <div class="information my-2">
                                                <span><i class="bi bi-calendar-date"></i> {{$post->created_at ? $post->created_at->format('H:i d/m/Y') : '' }}</span>
                                                <span class="ms-4"><i class="bi bi-eye-fill"></i> {{ $post->histotal}}</span>
                                            </div>
                                            <p class="desciption">{{$post->description}}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        {{ $posts->links('pagination::custom') }}  
                    @else
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-4">
                                <div class="empty-product text-center">
                                    <img src="/images/empty-product.png" width="100%" alt="">
                                    <p style="font-size: 13px; font-weight: 600; color: rgb(162, 162, 162);">Chưa có {{$breadcrumbs_title}}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 right py-3">

                    @include('client.component.sidebar-post-right')

                    <div class="products-category accordion mt-5" id="categoryAccordion">
                        <h2 class="title text-center mb-4">{{$breadcrumbs_title}}</h2>
                        <div class="product-category-item">
                            <div class="category-item-header d-flex justify-content-between">
                                <p class="category-name">{{$breadcrumbs_title}} nổi bật</p>
                                <button class="btn-category" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2"><i
                                        class="bi bi-plus icon-rotate"></i></button>
                            </div>
                            <ul class="collapse" id="collapse2" data-bs-parent="#categoryAccordion">
                                @foreach ($posts_featured as $post)
                                <li class="mb-2">
                                    <a class="text-dark text-decoration-none" href="{{route('client.post', ['post_category_alias' => $post->category->alias, 'post_alias' => $post->alias])}}">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="post-featured-picture">
                                                    <img src="{{ $post->image_url ?? asset('images/empty-product.png') }}"
                                                        width="100%" alt="">
                                                </div>
                                            </div>
                                            <div class="col-9 post-featured-content px-0">
                                                <p class="title fw-bold">{{$post->title}}</p>
                                                <div class="information my-2">
                                                    <span><i class="bi bi-calendar-date"></i> {{$post->created_at ? $post->created_at->format('H:i d/m/Y') : '' }}</span>
                                                    <span class="ms-4"><i class="bi bi-eye-fill"></i>
                                                        {{$post->histotal}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection