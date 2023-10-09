<?php

namespace App\Http\Controllers;

use App\Models\RecordMenu;
use Illuminate\Http\Request;

class RecordMenuController extends Controller
{
    //
    public function index(Request $request, RecordMenu $recordMenu){
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $menu_id = $request->menu_id;
        $record_state_id = $request->record_state_id;
        $secondRecordState = $recordMenu->where(function($query) use($user_id, $category_id, $menu_id, $record_state_id){
            $query->where([['user_id', $user_id], ['category_id', $category_id], ['menu_id', $menu_id]])->where('record_state_id' ,'<=', $record_state_id);
            // offset(数)←先頭から引数の数だけ飛ばす
        })->orderBy('record_state_id', 'desc')->offset(1)->first();
        if($secondRecordState){
            $secondRecords = $secondRecordState->recordContents()->orderBy('set', 'asc')->get();
            // $secondRecordState = $hasSomeRecords->offset(1)->first()->record_state_id;
            // $secondRecords = $recordMenu->where('record_state_id', $secondRecordState)->where(function($query) use($menu_id, $category_id){
            //     $query->where([['menu_id', $menu_id], ['category_id',$category_id]]);
            // })->get();
            return response()->json(["status_code" => 200, "message" => "２番目に新しい記録を取得します。",'$secondRecordState'=>$secondRecordState, 'secondRecords' => $secondRecords]);
        }else{
            return response()->json(["status_code" => 200, "message" => "記録が１つしか存在しません。"]);
        }
        
    }

    public function create(Request $request, RecordMenu $recordMenu){
        // updateOrCreate()でCreateすると、既にデータがあるとupdateし、なければcreateを自動で行ってくれる。
        // updateOrCreate(['探索カラム名' => 条件となる値], ['値を格納するカラム名' => 値],);
        $recordMenu->updateOrCreate([
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
