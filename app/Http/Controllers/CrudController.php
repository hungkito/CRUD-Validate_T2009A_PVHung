<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CrudController extends Controller
{
    public function create()
    {
        return view('admin.crud.form');
    }

    public function store(StoreProductRequest $request)
    {
        $request->validate();
        return 'Hello';
    }
}
