<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('position', 'asc')->orderBy('order', 'asc')->get();
        return view('admin.pages.menu.list-menu', compact('menus'));
    }

    public function addMenu()
    {
        $menus = Menu::where('parent', 0)->get();
        return view('admin.pages.menu.add-menu', compact('menus'));
    }

    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'parent' => 'required',
            'name' => 'required|string',
            'alias' => 'required|string|unique:menu,alias',
            'position' => 'required',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên menu không được bỏ trống.',
            'alias.required' => 'Đường dẫn menu không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với menu khác.',
            'order.required' => 'Thứ tự hiển thị không được bỏ trống.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        if($validated['position'] == 'footer'){
            $validated['parent'] = 0;
        }

        try {
            Menu::create($validated);
            return redirect()->route('admin.menu')->with('success', 'Tạo menu thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo menu. Vui lòng thử lại!');
        }
    }

    public function editMenu($menuId) {
        $menu = Menu::findOrFail($menuId);
        $menus = Menu::where('parent', 0)->get();

        return view('admin.pages.menu.edit-menu', compact('menu', 'menus'));
    }

    public function updateMenu(Request $request, $menuId)
    {
        $validated = $request->validate([
            'parent' => 'required',
            'name' => 'required|string',
            'alias' => 'required|string|unique:menu,alias,' . $menuId . ',id',
            'position' => 'required',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên menu không được bỏ trống.',
            'alias.required' => 'Đường dẫn menu không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với menu khác.',
            'order.required' => 'Thứ tự hiển thị không được bỏ trống.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        if($validated['position'] == 'footer'){
            $validated['parent'] = 0;
        }

        try {
            $menu = Menu::findOrFail($menuId);
            $menu->update($validated);
            return redirect()->route('admin.menu')->with('success', 'sửa menu thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi sửa menu. Vui lòng thử lại!');
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $menu = Menu::findOrFail($request->id);
            $menu->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $menu->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function deleteMenu($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        
        try {
            Menu::where('parent', $menuId)->delete();
            $menu->delete();
            return redirect()->back()->with('success', 'Đã xóa menu!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa menu. Vui lòng thử lại!');
        }
    }
}
