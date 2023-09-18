<?php

namespace App\Http\Controllers;

use App\Models\RecordContent;
use Illuminate\Http\Request;

class RecordContentController extends Controller
{
    //
    public function create(Request $request, RecordContent $recordContent){
        $recordContent->user_id = $request->user_id;
        $recordContent->category_id = $request->category_id;
        $recordContent->menu_id = $request->menu_id;
        $recordContent->record_states_id = $request->record_states_id;
        //save()でCreateすると、既にデータがあるとupdateし、なければcreateを自動で行ってくれる。
        $recordContent->save();
        return response()->json(["status_code" => 200, "message" => "記録開始します"]);
    }
}
