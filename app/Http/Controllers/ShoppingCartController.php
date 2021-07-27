<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
{
    public static $menu_parent = 'shopping-cart';

    public function show()
    {
        $shoppingCart = null;
        if (Session::has('shoppingCart')){
            $shoppingCart = Session::get('shoppingCart');
        }else{
            $shoppingCart = [];
        }
        return view('cart', [
           'shoppingCart' => $shoppingCart
        ]);
    }

    public function add(Request $request){
        // lấy thông tin sản phẩm.
        $productId = $request->get('id');
        // lấy số lượng sản phẩm cần thêm vào giỏ hàng.
        $productQuantity = $request->get('quantity');
        if ($productQuantity <= 0){
            return view('admin.errors.404', [
                'msg' => 'Số lượng sản phẩm phải lớn hơn 0.',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }
        // 1. Kiểm tra sự tồn tại của sản phẩm.
        $obj = Product::find($productId);
        // nếu khôn tồn tại thì trả về 404.
        if ($obj == nul) {
            return view('admin.errors.404', [
                'msg' => 'Không tìm thấy sản phẩm.',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }
        // nếu có sản phẩm trong db.
        // 2. Check số lượng tồn kho. Nếu như số lượng mua lớn hơn số lượng trong kho thì báo lỗi.

        // Kiểm tra sư tồn tại của shopping cart trong session.
        $shoppingCart = null;
        // nếu có shopping cart rồi thì lấy ra
        if (Session::has('shoppingCart')) {
            $shoppingCart = Session::get('shoppingCart');
        }else {
            // nếu chưa thì toạ shopping cart mới.
            $shoppingCart = [];
        }
        // kiểm tra sản phẩm có tồn tại trong giỏ hàng không.
        if (array_key_exists($productId, $shoppingCart)) {
            // nếu có sản phẩm rồi thì update số lượng.
            $existingCartItem = $shoppingCart[$productId];
            // tăng số lượng theo số lượng cần mua thêm.
            $existingCartItem->quantity += $productQuantity;
            // và lưu lại vào đối tượng shopping cart.
            $shoppingCart[$productId] = $existingCartItem;
        } else {
            // nếu như có tạo ra một cartItem mới, có thông tin trùng với thông tin sản phẩm từ trong db.
            $cartItem = new stdClass();
            $cartItem->id = $obj->id;
            $cartItem->name = $obj->name;
            $cartItem->unitPrice = $obj->price;
            $cartItem->quantity = $obj->productQuantity;
            // đưa cartItem vào trong shoppingCart.
            $shoppingCart[$productId] = $cartItem;
        }
        // update thông tin shopping cart vào session.
        Session::put('shoppingCart', $shoppingCart);
        return redirect('/cart/show');
    }

    public function update(Request $request){
        $productId = $request->get('id');
        $productQuantity = $request->get('quantity');
        if ($productQuantity <= 0) {
            return view('admin.errors.404', [
                'msg' => 'Số lượng sản phẩm phải lớn hơn 0.',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }
        $obj = Product::find($productId);
        if ($obj == nul) {
            return view('admin.errors.404', [
                'msg' => 'Không tìm thấy sản phẩm.',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }
        $shoppingCart = null;
        if (Session::has('shoppingCart')) {
            $shoppingCart = Session::get('shoppingCart');
        }else {
            $shoppingCart = [];
        }
        if (array_key_exists($productId, $shoppingCart)) {
            $existingCartItem = $shoppingCart[$productId];
            $existingCartItem->quantity += $productQuantity;
            $shoppingCart[$productId] = $existingCartItem;
        }
        Session::put('shoppingCart', $shoppingCart);
        return redirect('/cart/show');
    }

    public function remove(Request $request){
        $productId = $request->get('id');
        $shoppingCart = null;
        // nếu có shopping cart rồi thì lấy ra.
        if (Session::has('shoppingCart')){
            $shoppingCart = Session::get('shoppingCart');
        }else{
            // nếu chưa có thì tạo shopping cart mới..
            $shoppingCart = [];
        }
        unset($shoppingCart[$productId]); //Xoá giá trị theo key ở trong map với php.
        Session::put('shoppingCart', $shoppingCart);
        return redirect('/cart/show');
    }
}
