<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kjmtrue\VietnamZone\Models\District;
use Kjmtrue\VietnamZone\Models\Province;
use Kjmtrue\VietnamZone\Models\Ward;

class AdminAddressController extends Controller
{
    public function province(Request $request)
    {

        $query = Province::query(); 

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $provinces = $query->get();
        return view('admin.pages.address.province.province', compact('provinces'));
    }

    public function district(Request $request)
    {
        $query = District::query();

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $perPage = (int) $request->input('per_page', 10);

        $districts = $query->paginate($perPage)->appends($request->all());
        $provinces = Province::all();
        return view('admin.pages.address.district.district', compact('districts', 'provinces'));
    }

    public function editProvince($provinceId)
    {
        $data = Province::findOrFail($provinceId);
        return view('admin.pages.address.province.edit', compact('data'));
    }

    public function updateProvince(Request $request, $provinceId)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'shipping' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Tên không được bỏ trống.',
            'shipping.required' => 'Tiền vận chuyển không được bỏ trống.',
        ]);

        try {
            $province = Province::findOrFail($provinceId);
            $province->update($validated);
            return redirect()->route('admin.address.province')->with('success', 'Đã cập nhật tỉnh thành!');
        } catch (\Exception $e) {
            return redirect()->route('admin.address.province')->with('error', 'Có lỗi xảy ra khi sửa tỉnh thành. Vui lòng thử lại!');
        }
    }

    public function addProvince()
    {
        return view('admin.pages.address.province.add');
    }

    public function storeProvince(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'shipping' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Tên không được bỏ trống.',
            'shipping.required' => 'Tiền vận chuyển không được bỏ trống.',
        ]);

        $provinces = Province::get();
        $validated['id'] = (int) count($provinces) + 1;
        $validated['gso_id'] = (int) count($provinces) + 1;

        try {
            Province::create($validated);
            return redirect()->route('admin.address.province')->with('success', 'Đã cập nhật tỉnh thành!');
        } catch (\Exception $e) {
            return redirect()->route('admin.address.province')->with('error', 'Có lỗi xảy ra khi sửa tỉnh thành. Vui lòng thử lại!');
        }
    }

    public function addDistrict()
    {
        $provinces = Province::get();
        return view('admin.pages.address.district.add', compact('provinces'));
    }

    public function storeDistrict(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'province_id' => 'required'
        ], [
            'name.required' => 'Tên không được bỏ trống.',
        ]);

        $districts = District::get();
        $validated['id'] = (int) count($districts) + 1;
        $validated['gso_id'] = (int) count($districts) + 1;

        try {
            District::create($validated);
            return redirect()->route('admin.address.district')->with('success', 'Đã cập nhật quận/huyện!');
        } catch (\Exception $e) {
            return redirect()->route('admin.address.district')->with('error', 'Có lỗi xảy ra khi sửa quận/huyện. Vui lòng thử lại!');
        }
    }

    public function editDistrict($districtId)
    {
        $district = District::findOrFail($districtId);
        $provinces = Province::get();
        return view('admin.pages.address.district.edit', compact('district', 'provinces'));
    }

    public function updateDistrict(Request $request, $districtId)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'province_id' => 'required'
        ], [
            'name.required' => 'Tên không được bỏ trống.',
        ]);

        try {
            $district = District::findOrFail($districtId);
            $district->update($validated);
            return redirect()->route('admin.address.district')->with('success', 'Đã cập nhật quận huyện!');
        } catch (\Exception $e) {
            return redirect()->route('admin.address.district')->with('error', 'Có lỗi xảy ra khi sửa quận huyện. Vui lòng thử lại!');
        }
    }

    public function deleteAddress($address, $addressId)
    {
        $data = null;
        if ($address == 'province') {
            $data = Province::findOrFail($addressId);
        } elseif ($address = 'district') {
            $data = District::findOrFail($addressId);
        }
        try {
            $data->delete();
            return redirect()->back()->with('success', 'Đã xóa địa chỉ!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa địa chỉ. Vui lòng thử lại!');
        }
    }
}
