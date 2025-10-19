@extends('client.index')

@section('title-seo', $post->title_seo . ' - ')

@section('content')

    @include('client.partials.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'breadcrumbs_title' => $breadcrumbs_title])

    <section class="posts py-4">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-post">
                        <div class="single-post-picture">
                            <img src="{{ $post->image_url ?? '/images/empty-product.png' }}" width="100%"
                                alt="{{ $post->name }}">
                        </div>
                        <div class="single-post-content">
                            <h1 class="title my-3">{{$post->title}}</h1>
                            <p class="desciption">{{$post->description}}</p>
                            <div class="information my-2">
                                <span><i class="bi bi-calendar-date"></i> {{$post->created_at ? $post->created_at->format('H:i d/m/Y') : '' }}</span>
                                <span class="ms-4"><i class="bi bi-eye-fill"></i> {{ $post->histotal}}</span>
                            </div>
                            <div class="separator"></div>
                            <div class="content">
                                {!! $post->content !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 right py-3">

                    @include('client.component.sidebar-post-right')

                    <div class="products-category accordion mt-5" id="categoryAccordion">
                        <h2 class="title text-center mb-4">{{$breadcrumbs_title}}</h2>     
                        <div class="product-category-item">
                            <div class="category-item-header">
                                <p class="category-name">{{$breadcrumbs_title}} nổi bật</p>
                                <button class="btn-category" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2"><i
                                        class="bi bi-plus icon-rotate"></i></button>
                            </div>
                            <ul class="collapse" id="collapse2" data-bs-parent="#categoryAccordion">
                                @foreach ($posts_featured as $post)
                                    <li>
                                        <a href="{{route('client.post', ['post_category_alias' => $post->category->alias, 'post_alias' => $post->alias])}}">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="post-featured-picture">
                                                        <img src="{{ $post->image_url ?? asset('images/empty-product.png') }}"
                                                            width="100%" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-9 post-featured-content px-0">
                                                    <p class="title">{{$post->title}}</p>
                                                    <div class="information my-2">
                                                        <span><i class="bi bi-calendar-date"></i> 24/4/2025</span>
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