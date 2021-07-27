<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public static $menu_parent = 'article';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category_id = $request->get('category_id');
        $list = Article::where('status', '!=', -1);
        if($category_id != 0){
            $list = $list->where('category_id', '=', $category_id);
        }
        $list = $list->paginate(10);
        $categories = ArticleCategory::all();
        return view('admin.articles.list',
        [
            'menu_parent' => self::$menu_parent,
            'menu_action' => 'list',
            'list'=>$list,
            'categories'=>$categories,
            'current_category_id'=>$category_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ArticleCategory::all();
        return view('admin.articles.form', [
        'categories'=>$categories,
            'menu_parent' => self::$menu_parent,
            'menu_action' => 'create',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj = new Article();
        $obj->title = $request->get('title');
        $obj->category_id = $request->get('category_id');
        $obj->content = $request->get('content');
        $obj->thumbnail = $request->get('thumbnail');
        $obj->status = $request->get('status');
        $obj->save();
        return redirect('/admin/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = Article::find($id);
        if($obj == null){
            return view('admin.errors.404', ['msg'=>'Không tìm thấy bài viết']);
        }
        return view('admin.articles.detail', [
            'obj'=>$obj,
            'menu_parent' => self::$menu_parent,
            'menu_action' => 'show',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj = Article::find($id);
        if($obj == null){
            return view('admin.errors.404', ['msg'=>'Không tìm thấy tin tức']);
        }
        $categories = ArticleCategory::all();
        return view('admin.articles.edit', [
            'obj'=>$obj,
            'categories'=>$categories,
            'menu_parent' => self::$menu_parent,
            'menu_action' => 'edit',
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obj = Article::find($id);
        if($obj == null){
            return view('admin.errors.404', [
                'msg'=>'Không tìm thấy bài viết',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'edit',
                ]);
        }
        $obj->title = $request->get('title');
        $obj->category_id = $request->get('category_id');
        $obj->content = $request->get('content');
        $obj->thumbnail = $request->get('thumbnail');
        $obj->status = $request->get('status');
        $obj->save();
        return redirect('/admin/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = Article::find($id);
        if($obj == null){
            return view('admin.errors.404', [
                'msg'=>'Không tìm thấy danh mục tin tức',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'list',
                ]);
        }
        $obj->updated_at = Carbon::now();
        $obj->status = -1;
        $obj->save();
        return redirect('/admin/articles');
    }
}
