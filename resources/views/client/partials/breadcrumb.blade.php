<section class="container-lg py-2">
    {{-- <img src="{{ asset('storage/' . $image_breadcrumb)}}" alt="" width="100%" />
    <div class="breadcrumb-content">
        <div class="container-md">
            <h1 class="title">{{ $breadcrumbs_title }}</h1>
            <div class="d-flex">
                @foreach ($breadcrumbs as $title => $url)
                <a class="breadcrumb-item text-truncate active" href="{{ $url }}">{{ $title }}</a>
                @endforeach
            </div>
        </div>
    </div> --}}
    <h1 class="title fs-3 my-1">{{ $breadcrumbs_title }}</h1><br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $title => $url)
                <li class="breadcrumb-item"><a href="{{ $url }}">{{ $title }}</a></li>
            @endforeach
        </ol>
    </nav>
</section>