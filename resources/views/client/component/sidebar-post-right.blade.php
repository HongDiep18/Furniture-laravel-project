<div class="card products-category accordion">
    <div class="card-header bg-primary text-white">
        Danh mục blog
    </div>
    <ul class="list-group list-group-flush">

        @foreach ($post_categories as $item)
            <li class="list-group-item">
                <a href="{{ route('client.post.category', ['post_category_alias' => $item->alias])}}"
                    class="text-dark text-decoration-none">{{$item->name}}</a>
            </li>
        @endforeach
    </ul>
</div>