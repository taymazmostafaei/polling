<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Selection;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vote $vote, Selection $Selection, Participant $participant)
    {
        
        $user = User::where('email', $request->header('php-auth-user'))->first();
        $pollingId = false;

        $validate = Validator::make($request->all(), [
            'selectionIds' => ['array','min:1','max:10']
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        foreach ($request->selectionIds as $selectionId) {
            if ($selection = $Selection->find($selectionId)) {

                #check to not vote twice
                $participant = $participant::where('user_id', $user->id)->first();
                if ($participant->polling_id == $selection->polling->id) {
                    return response()->json(['selectionIds' => 'alredy voted this polling'], 400);
                }

                $vote->insert([
                    'selection_id' => $selection->id
                ]);

                # check to not insert two times
                if ($pollingId != $selection->polling->id) {
                    $participant->insert([
                        'user_id' => $user->id,
                        'polling_id' => $selection->polling->id,
                    ]);
                }
                $pollingId = $selection->polling->id;
            } else {
                return response('', 404);
            }
        }
        return;
    }
}
