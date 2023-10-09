<?php

namespace App\Http\Controllers;

use App\Models\RecordMenu;
use App\Models\RecordContent;
use App\Models\RecordState;
use Illuminate\Http\Request;

class RecordContentController extends Controller
{
    public function index(Request $request, RecordMenu $recordMenu){
        $tgtRecords = Null;

        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $menu_id = $request->menu_id;
        $record_state_id = $request->record_state_id;

        $tgtRecord=$recordMenu->where(function($query) use($user_id, $category_id, $menu_id,$record_state_id){
            $query->where([['user_id', $user_id], ['category_id', $category_id], ['menu_id', $menu_id],['record_state_id', $record_state_id]]);
        })->first();

        if($tgtRecord){
            $tgtRecords=$tgtRecord->recordContents()->orderBy('set', 'asc')->get();
            return response()->json(["status_code" => 200, "message" => "記録日のデータを取得", 'tgtRecords'=>$tgtRecords]);
        }else{
            return response()->json(["status_code" => 200, "message" => "記録日のデータはありません", 'tgtRecords'=>$tgtRecords]);
        }
    }

    public function create(Request $request, RecordMenu $recordMenu,RecordContent $recordContent){
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $menu_id = $request->menu_id;
        $record_state_id = $request->record_state_id;
        
        $tgtRecordMenu=$recordMenu->where(function($query) use($user_id, $category_id, $menu_id,$record_state_id){
            $query->where([['user_id', $user_id], ['category_id', $category_id], ['menu_id', $menu_id],['record_state_id', $record_state_id]]);
        })->first();
        $tgtRecordContent = $tgtRecordMenu->recordContents()->where('set',$request->set)->first();
        if($tgtRecordContent){
            $tgtRecordContent->record_menu_id=$tgtRecordMenu->id;
            $tgtRecordContent->weight = $request->weight;
            $tgtRecordContent->right_weight = $request->right_weight;
            $tgtRecordContent->right_rep = $request->right_rep;
            $tgtRecordContent->left_weight = $request->left_weight;
            $tgtRecordContent->left_rep = $request->left_rep;
            $tgtRecordContent->set = $request->set;
            $tgtRecordContent->rep = $request->rep;
            $tgtRecordContent->memo = $request->memo;
            $tgtRecordContent->save();
            return response()->json(["status_code" => 200, "message" => "記録を更新しました。"]);
        }elseif($tgtRecordMenu){
            $recordContent->record_menu_id=$tgtRecordMenu->id;
            $recordContent->weight = $request->weight;
            $recordContent->right_weight = $request->right_weight;
            $recordContent->right_rep = $request->right_rep;
            $recordContent->left_weight = $request->left_weight;
            $recordContent->left_rep = $request->left_rep;
            $recordContent->set = $request->set;
            $recordContent->rep = $request->rep;
            $recordContent->memo = $request->memo;
            $recordContent->save();
            return response()->json(["status_code" => 200, "message" => "新規に記録しました。"]);
        }
        return response()->json(["status_code" => 200, "message" => "記録できるデータがないです。"]);
    }
}
