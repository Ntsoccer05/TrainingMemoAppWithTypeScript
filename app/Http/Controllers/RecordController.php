<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Record;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Else_;

class RecordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $recorded_at = Carbon::parse($request->recording_day);
        $recording_day =$recorded_at->toDateString();
        $hasRecord = Record::where('user_id', $request->user_id)->whereDate('recorded_at', $recording_day)->get();
        
        if(count($hasRecord) !== 0){
            return response()->json(["status_code" => 200, "hasrecord" => $hasRecord,"recorded_at"=>$recorded_at, "request"=>$request->recording_day,"record" => $recording_day]);
        }else{
            Record::create([
                'user_id' => $request->user_id,
                'recorded_at' => $recording_day
            ]);
            return response()->json(["status_code" => 200, "message" => "トレーニング日を記録しました"]);
        }
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
    public function updated(Request $request)
    {
        $recorded_at = Carbon::parse($request->recording_day);
        $recording_day =$recorded_at->toDateString();
        $hasRecord = Record::where('user_id', $request->user_id)->whereDate('recorded_at', $recording_day)->get();
        $selectedCategory = Category::where('user_id', $request->user_id)->where('id', $request->category_id)->get();
        if(count($selectedCategory) !== 0){
            return response()->json(["status_code" => 200, "selectedCategory" => $selectedCategory,"recorded_at"=>$recorded_at, "request"=>$request->recording_day,"record" => $recording_day]);
        }else{
            $hasRecord->category_id = $request->category_id;
            $hasRecord->save();
            return response()->json(["status_code" => 200, "message" => "メニューを記録しました"]);
        }
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
