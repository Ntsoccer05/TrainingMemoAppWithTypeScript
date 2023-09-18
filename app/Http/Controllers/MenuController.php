<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

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
            //Modelで設定したのはメソッドだが呼び出す際はプロパティ(menus()→menus)
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
    public function store(Request $request, Category $category, Menu $menu)
    {
        // 引数にModel名を渡すことでCategoryではなく$categoryから取得できる(Newでインスタンス化しなくていい)

        //Vueで「""」の値を渡した場合、PHPではNULLの値となる。issetはNULLでない場合TRUE
        if(isset($request->category_content)){
            if($request->category_content === false){
                return response()->json(['status' => 400, "errors"=>["category_content" => "部位を入力してください"]]);
            }
            $menulists = $category->where("user_id", $request->user_id)->get();
            foreach($menulists as $menulist){
                if($menulist->content === $request->category_content){
                    return response()->json(['status' => 400, "errors"=>["category_content" => "入力された部位は既に登録されています"],"menulist"=>$menulist->content,"category"=>$request->category_content]);
                }
            }
            $category->user_id = $request->user_id;
            $category->content = $request->category_content;
            $category->save();
            return response()->json(['status' => 200, "message"=>"部位を登録しました。"]);
        }


        if((isset($request->menu)) && (isset($request->category_id))){
            $menulists = $menu->where("user_id", $request->user_id)->where("category_id", $request->category_id)->get();
            foreach($menulists as $menulist){
                if($menulist->content === $request->menu){
                    return response()->json(['status' => 400, "errors"=>["menu" => "入力された種目は既に登録されています"]]);
                }
            }
            $menu->user_id = $request->user_id;
            $menu->category_id = $request->category_id;
            $menu->content = $request->menu;
            $menu->oneSide = $request->oneSide;
            $menu->save();
            return response()->json(['status' => 200, "message"=>"種目を登録しました。"]); 
        }else{
            $errors = [];
            if(!isset($request->category_id)){
                $errors["category_content"] = "部位を選択してください。";
            }
            if(!isset($request->menu)){
                $errors["menu"] = "種目を記入してください。";
            }
            return response()->json(['status' => 400, "errors"=>$errors, "menu"=> $request->menu]);
        }
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
    // 元々３つの引数だが、Vueからはrequestしかないため３つ引数だとエラーが生じる
    public function update(Request $request)
    {
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $menu_id = $request ->menu_id;
        $menulist = Menu::where(function($query) use($user_id, $category_id, $menu_id){
            $query->where([['user_id', $user_id],['category_id', $category_id],['id', $menu_id]]);
        })->first();
        If(count($menulist) !== 0){
            $menulist->content = $request->content;
            $menulist->save();
            return response()->json(["status_code" => 200, "message" => "メニューを更新しました"]);
        }else{
            return response()->json(["status_code" => 200,"message"=>"データが存在していません", "user_id" => $user_id,"category_id"=>$category_id, "menu_id"=>$menu_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Menu $menu)
    {
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $menu_id = $request ->menu_id;
        // firstだとstdClassを返すためdelete()メソッドが存在しない←インスタンス化が必要
        // $menulist = Menu::where(function($query) use($user_id, $category_id, $menu_id){
        //     $query->where([['user_id', $user_id],['category_id', $category_id],['id', $menu_id]]);
        // })->get();

        // Menu $menuを引数とすることでMenuテーブルに依存関係が生まれるため、インスタンス化(New Menu)をしなくていい
        $menulist= $menu->where(function($query) use($user_id, $category_id, $menu_id){
            $query->where([['user_id', $user_id],['category_id', $category_id],['id', $menu_id]]);
        })->first();
        If($menulist){
            $menulist->delete();
            return response()->json(["status_code" => 200, "message" => "メニューを削除しました"]);
        }else{
            return response()->json(["status_code" => 200,"message"=>"データが存在していません", "user_id" => $user_id,"category_id"=>$category_id, "menu_id"=>$menu_id]);
        }
    }
}
