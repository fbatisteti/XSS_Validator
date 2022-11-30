<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\MiniRequestController;
use App\Http\Controllers\Api\MiniLogController;

class MiniController extends Controller
{
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'uid' => 'sometimes|required|uuid',
                'input' => 'required|string'
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                'return' => '"input" is necessary, "uid" field is optional'
            ], 400);
        };

        (array_key_exists("uid", $request->all())) ?
            $uid = $request->all()["uid"]
            : $uid = "00000000-0000-0000-0000-000000000000";
        $input = $request->all()["input"];
         
        $array = [
            "uid" => $uid,
            "input" => $input
        ];

        $return = MiniRequestController::post($array);
        
        return response()->json([
            "isSafe" => $return["isSafe"],
            "results" => json_decode($return["results"])
        ], 201);
    }

    public function show(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'uid' => 'sometimes|uuid',
                'startDate' => 'sometimes|date',
                'endDate' => 'sometimes|date'
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                'return' => 'Invalid URL'
            ], 400);
        };
        
        ($request['uid'] != null) ?
            $uid = $request['uid']
            : $uid = "00000000-0000-0000-0000-000000000000";

        ($request['startDate'] != null) ?
            $start_date = $request['startDate']
            : $start_date = "1970-1-1";
        
        ($request['endDate'] != null) ?
            $end_date = $request['endDate']
            : $end_date = "9999-12-31";

        if ($start_date > $end_date) {
            return response()->json([
                'retorno' => 'Invalid dates (start_date later than end_date)'
            ], 400);
        };

        $array = [
            "uid" => $uid,
            "startDate" => $start_date,
            "endDate" => $end_date
        ];

        $return = MiniLogController::get($array);

        return response()->json([$return], 200);
    }

    public function index()
    {
        return response()->json(['PLEASE USE A "POST" HTTP METHOD TO SEND DATA'], 200);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['PLEASE USE A "POST" HTTP METHOD TO SEND DATA'], 200);
    }

    public function destroy($id)
    {
        return response()->json(['PLEASE USE A "POST" HTTP METHOD TO SEND DATA'], 200);
    }
}
