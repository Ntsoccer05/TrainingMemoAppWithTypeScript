<?php

namespace App\Http\Controllers;

use App\Models\RecordContent;
use Illuminate\Http\Request;

class RecordContentController extends Controller
{
    public function index(Request $request, RecordContent $recordContent){
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $menu_id = $request->menu_id;
        $hasSomRecords = $recordContent->where(function($query) use($user_id, $category_id, $menu_id){
            $query->where([['user_id', $user_id], ['category_id', $category_id], ['menu_id', $menu_id]]);
        })->get();
        if($hasSomRecords->count() >= 2){
            // offset(数)←先頭から引数の数だけ飛ばす
            $secondRecord = $recordContent->where(function($query) use($user_id, $category_id, $menu_id){
                $query->where([['user_id', $user_id], ['category_id', $category_id], ['menu_id', $menu_id]]);
            })->orderBy('record_state_id', 'desc')->offset(1)->first();
            return response()->json(["status_code" => 200, "message" => "２番目に新しい記録を取得します。", 'secondRecord' => $secondRecord]);
        }else{
            return response()->json(["status_code" => 200, "message" => "記録が１つしか存在しません。"]);
        }
        
    }

    public function create(Request $request, RecordContent $recordContent){
        // updateOrCreate()でCreateすると、既にデータがあるとupdateし、なければcreateを自動で行ってくれる。
        // updateOrCreate(['探索カラム名' => 条件となる値], ['値を格納するカラム名' => 値],);
        $recordContent->updateOrCreate([
                'user_id'=>$request->user_id,
                'category_id'=>$request->category_id,
                'menu_id'=>$request->menu_id,
                'record_state_id'=>$request->record_state_id
            ],[
                'user_id'=>$request->user_id,
                'category_id'=>$request->category_id,
                'menu_id'=>$request->menu_id,
                'record_state_id'=>$request->record_state_id
            ]
        );
        return response()->json(["status_code" => 200, "message" => "記録開始します"]);
    }
}
