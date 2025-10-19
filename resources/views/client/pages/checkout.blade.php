@extends('client.index')

@section('title-seo', $title_seo . ' - ')

@section('content')
    <section class="checkout">
        <div class="container-lg">

            <div class="row">
                <div class="col-lg-6 mb-5">
                    <h2 class="title mb-5">Đơn hàng của bạn</h2>
                    <div class="my-order pe-lg-3 mb-3">
                        @if (!empty($cartItems) && count($cartItems) > 0)
                            @foreach ($cartItems as $key => $cartItem)
                                <p class="d-flex justify-content-between my-order-item">
                                    <span class="name">{{ $cartItem['productName']}}</span>
                                    <span class="quantity">x{{ $cartItem['quantity']}}</span>
                                    <span
                                        class="price">{{ number_format($cartItem['price'] * $cartItem['quantity'], 0, ',', '.') . '₫'}}</span>
                                </p>
                            @endforeach
                        @else
                            <div class="row empty-cart">
                                <div class="col-sm-5 col-lg-4">
                                    <img src="{{ asset('images/no-cart.png')}}" width="100%" alt="">
                                </div>
                                <div class="col-sm-7 col-lg-8 d-flex justify-content-center pt-4">
                                    <div class="text-center text-sm-end">
                                        <h2 class="title">Giỏ hàng của bạn trống</h2>
                                        <a href="{{ route('client.product')}}" class="btn rounded-0 mt-2 start-shopping">Bắt
                                            đầu mua sắm <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="separator"></div>

                        <p class="d-flex justify-content-between mb-3">
                            <span style="font-size: 16px; font-weight: 700; color: var(--main-color);">Tạm
                                tính</span>
                            <span
                                style="font-size: 14px; font-weight: 700;">{{ number_format($cartToTalPrice, 0, ',', '.') . ' ₫'}}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <span style="font-size: 16px; font-weight: 700; color: var(--main-color);">Phí vận
                                chuyển</span>
                            <span id="shipping" style="font-size: 14px; font-weight: 700; color: green;">0 đ</span>
                        </p>

                        <div class="separator"></div>

                        <p class="d-flex justify-content-between">
                            <span style="font-size: 17px; font-weight: 700; color: var(--main-color);">Tổng</span>
                            <span id="total-amount"
                                style="font-size: 15px; font-weight: 700; color: var(--main-color);">{{ number_format($cartToTalPrice, 0, ',', '.') . ' ₫'}}</span>
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 ps-lg-2">
                    <h2 class="title mb-5">Thông tin giao hàng</h2>
                    <form action="{{ route('client.order.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box-input">
                                    <input class="input-text" type="text" placeholder="Họ và tên *" name="name"
                                        value="{{ old('name', Auth::check() ? Auth::user()->username : '')}}">
                                    @error('name')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box-input">
                                    <input class="input-text" type="text" placeholder="Số điện thoại *" name="phone_number"
                                        value="{{ old('phone_number', Auth::check() ? Auth::user()->phone_number : '')}}">
                                    @error('phone_number')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-7">
                                <div class="box-input">
                                    <input class="input-text" type="text" placeholder="Email" name="email"
                                        value="{{ old('email', Auth::check() ? Auth::user()->email : '')}}">
                                    @error('email')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="box-input">
                                    <select class="input-text" id="province-select" name="province">
                                        <option value="" disabled class="text-danger" selected {{ old('province') ? '' : 'selected' }}>-- Chọn tỉnh/thành phố --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('province') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box-input">
                                    <select class="input-text" id="district-select" name="district" disabled>
                                        <option value="" selected class="text-danger" disabled>-- Chọn quận/huyện --
                                        </option>
                                    </select>
                                    @error('district')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box-input">
                                    <select class="input-text" id="ward-select" name="ward" disabled>
                                        <option value="" selected class="text-danger">-- Chọn xã/phường --</option>
                                    </select>
                                    @error('ward')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="box-input">
                                    <input class="input-text" type="text"
                                        placeholder="Địa chỉ cụ thể (tầng, số nhà, đường, ...) *" name="address_detail"
                                        value="{{ old('address_detail')}}">

                                    @error('address_detail')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="box-input">
                                    <textarea class="w-100" name="note" value="note"
                                        placeholder="Ghi chú đơn hàng"></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-submit-checkout mt-4 rounded-0">Đặt hàng</button>
                    </form>
                </div>

            </div>

        </div>

    </section>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Toast.fire({
                icon: "success",
                text: '{{ session('success') }}',
                timer: 3000
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: "error",
                text: '{{ session('error') }}',
                timer: 3000
            });
        </script>
    @endif


    <script>
        $('#province-select').on('click', function () {
            var provinceId = $(this).val()

            $('#district-select').html('<option value="">-- Chọn quận/huyện --</option>');
            $('#ward-select').html('<option value="">-- Chọn xã/phường --</option>');
            if (provinceId) {
                $.ajax({
                    url: '/get-districts/' + provinceId,
                    type: 'GET',
                    success: function (data) {
                        $('#district-select').prop('disabled', false);
                        let shipping = parseInt(data.province.shipping);
                        $('#shipping').html(formatVND(shipping))
                        let cartTotal = {{ (int) $cartToTalPrice}}
                        let total_amount = cartTotal + shipping
                        $('#total-amount').html(formatVND(total_amount))
                        $.each(data.districts, function (index, district) {
                            $('#district-select').append(`<option value="${district.id}">${district.name}</option>`);
                        });
                    },
                    error: function () {
                        alert("Không thể tải quận/huyện, vui lòng thử lại!");
                    }
                })
            } else {
                $('#district-select').prop('disabled', true);
                $('#ward-select').prop('disabled', true);
            }

        })

        $('#district-select').on('click', function () {
            var districtId = $(this).val();
            $('#ward-select').html('<option value="">-- Chọn xã/phường --</option>');

            if (districtId) {
                $.ajax({
                    url: '/get-wards/' + districtId,
                    type: 'GET',
                    success: function (data) {
                        $('#ward-select').prop('disabled', false);

                        $.each(data, function (index, ward) {
                            $('#ward-select').append(`<option value="${ward.id}">${ward.name}</option>`)
                        })
                    },
                    error: function () {
                        alert("Không thể tải xã/phường, vui lòng thử lại!");
                    }
                })
            } else {
                $('#ward-select').prop('disabled', true);
            }

        })
    </script>
@endsection