<?php

namespace App\Http\Controllers;

use App\Models\polling;
use App\Models\Selection;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PollingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return polling::paginate(10);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($query)
    {
        return polling::where('pollingname', 'like', "%$query%")->get();
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
    public function store(Request $request, polling $polling, Selection $Selection)
    {
        $validate = Validator::make($request->all(), [
            "pollingname" => ['required', 'string', 'min:6', 'max:60'],
            "selections" => ['array', 'required', 'max:20', 'min:2'],
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = User::where('email', $request->header('php-auth-user'))->first();
        $polling->pollingname = $request->pollingname;
        $polling->user_id = $user->id;

        $polling->save();

        foreach ($request->selections as $selection) {
            $Selection->insert([
                "polling_id" => $polling->id,
                "value" => $selection
            ]);
        }

        $polling->selection;
        return $polling;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\polling  $polling
     * @return \Illuminate\Http\Response
     */
    public function show(polling $polling)
    {
        $polling->participant;
        $polling->user;
        $polling->selection;
        return response()->json($polling);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\polling  $polling
     * @return \Illuminate\Http\Response
     */
    public function showresult(polling $polling, Vote $vote)
    {
        $result = [];

        #counting wich selection vote
        foreach ($polling->selection as $selection) {
            $voteCount = $vote->where('selection_id', $selection->id)->count();

            $result[] = [
                "id" => $selection->id,
                "name" => $selection->value,
                "count" => $voteCount,
            ];
        }

        #add result to $polling object
        $polling->result = $result;

        return $polling;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\polling  $polling
     * @return \Illuminate\Http\Response
     */
    public function edit(polling $polling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\polling  $polling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, polling $polling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\polling  $polling
     * @return \Illuminate\Http\Response
     */
    public function destroy(polling $polling)
    {
        return $polling->delete();
    }
}
