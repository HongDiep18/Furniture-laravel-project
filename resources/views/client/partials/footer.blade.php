<footer class="py-3 mt-3 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6 mb-4 text-center text-md-start">
                <h5 class="footer-title">{{ $configs['name'] ?? '' }}</h5>
                <div class="footer-list">
                    <p class="footer-item">
                        {{ $configs['address'] ?? '' }}
                    </p>
                    <p class="footer-item">Hotline: {{ $configs['hotline'] ?? '' }}</p>
                    <p class="footer-item">Email: {{ $configs['email'] ?? '' }}</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4 text-center text-md-start">
                <h5 class="footer-title">Liên kết</h5>
                <div class="footer-list">
                    @foreach ($menus as $menu)
                        @if ($menu->position == 'footer')
                            <a href="{{$menu->alias}}" class="footer-item"><i class="bi bi-caret-right-fill me-1"></i>{{$menu->name}}</a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4 text-center text-lg-start">
                <h5 class="footer-title">đăng ký nhận tin</h5>
                <div class="footer-list">
                    <p class="footer-item">
                        Mỗi tháng chúng tối đều có đợt giảm giá dịch vụ và sản phẩm nhầm
                        chi ân khách hàng. Để có thể cập nhật kịp thời những đợt giảm
                        giá này, vui lòng nhập địa chỉ email bạn vào ô dưới đây.
                    </p>
                </div>
                <form action="{{ route('client.subscriber')}}" method="post" class="send-mail">
                    @csrf
                    <input type="email" class="w-100" placeholder="Nhập email..." name="email_subscriber"/>
                    <button type="submit"><i class="bi bi-send"></i></button>
                </form>
            </div>
        </div>
    </div>
</footer>