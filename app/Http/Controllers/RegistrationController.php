<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;

class RegistrationController extends Controller
{
    public function __construct(){
        //middleware
        $this->middleware('jwt.auth');
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
        $this->validate($request, [
            'meeting_id' => 'required',
            'user_id' => 'required'
        ]);

        $meeting_id = $request->input('meeting_id');
        $user_id = $request->input('user_id');

        $meeting = Meeting::findOrFail($meeting_id);
        $user = User::findOrFail($user_id);

        $response = [
            'msg' => 'User is already registred for meeting',
            'user' => $user,
            'meeting' => $meeting,
            'unregister' => [
                'href' => 'api/v1/meeting/registration/'.$meeting->id,
                'method' => 'DELETE'
            ]
        ];

        if($meeting->users()->where('users.id', $user->id)->first()){
            return response()->json($response, 404);
        }

        $user->meetings()->attach($meeting);

        $response = [
            'msg' => 'User registred for meeting',
            'user' => $user,
            'meeting' => $meeting,
            'unregister' => [
                'href' => 'api/v1/meeting/registration/'.$meeting->id,
                'method' => 'DELETE'
            ]
        ];

        return response()->json($response, 201);

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);

        if (!$user = JWTAuth::parseToken()->authenticate()){
            return response()->json(["msg" => "User not found"], 404);
        }
        $meeting->users()->detach($user->id);

        $response = [
            'msg' => 'User unregistred for meeting',
            'meeting' => $meeting,
            'user' => $user,
            'unregistred' => [
                'href' => 'api/v1/meeting/registration/1',
                'method' => 'POST',
                'params' => 'user_id, meeting_id'
            ] 
        ];
        
        return response()->json($response, 200);
        
    }
}
