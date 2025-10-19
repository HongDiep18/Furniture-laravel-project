<?php

use App\Models\Config;
use Illuminate\Support\Facades\Cache;


if (!function_exists('get_all_configs')) {
    /**
     * Lấy toàn bộ configs dưới dạng mảng key => value.
     * Dùng cache để tối ưu hiệu suất.
     *
     * @return array
     */
    function get_all_configs(): array
    {
        return Cache::rememberForever('site_configs', function () {
            return Config::all()
                ->pluck('value', 'key')
                ->toArray();
        });
    }
}