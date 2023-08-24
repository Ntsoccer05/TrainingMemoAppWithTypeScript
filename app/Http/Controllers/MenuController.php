<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Break_;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menulist = Menu::where('user_id', $request->user_id)->get();
        $categorylist = Category::where('user_id', $request->user_id)->get();
        foreach($menulist as $menu){
            //Modelで設定したのはメソッドだが呼び出す際はプロパティ(category()category)
            //Modelで設定したメソッドが入れ子となりmenulist2に格納される
            //menu:{
            //     category:{
            //     }
            // }
            $categories[] = $menu->category;
            // 重複削除
            $categories = array_unique($categories);
        }

        foreach($categorylist as $cagtegory){
            //Modelで設定したのはメソッドだが呼び出す際はプロパティ(menus()→menu)
            //Modelで設定したメソッドが入れ子となりmenulist2に格納される
            //category:{
            //     menus:{
            //     }
            // }
            $menulist2[] = $cagtegory->menus;
            // 重複削除
            $menulist2 = array_unique($menulist2);
        }

        return response()->json(['status' => 200, "menulist"=>$menulist, "categories"=>$categories, "categorylist" => $categorylist, "munulist2" => $menulist2]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
