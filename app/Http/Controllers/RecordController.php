<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use Carbon\Carbon;

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
        // $hasRecord = Record::where('user_id', $request->user_id)->where('recorded_at', $recorded_at)->get();
        Record::create([
            'user_id' => $request->user_id,
            'recorded_at' => $recorded_at
        ]);
        return response()->json(["status_code" => 200, "message" => "記録開始しました"]);
        // if($hasRecord){
        //     return;
        // }else{
        //     Record::create([
        //         'user_id' => $request->user_id,
        //         'recorded_at' => $request->recording_day
        //     ]);
        //     return response()->json(["status_code" => 200, "message" => "記録開始しました"]);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSelectDay(Request $request)
    {
        
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
