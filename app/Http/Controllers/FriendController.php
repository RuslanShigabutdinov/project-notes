<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\{
    Note,
    Friend,
    User,
};

class FriendController extends Controller
{
    public function show(){
        $user = Auth::user();
        $friends = $user->friends;
        $friendRequests = $user->friendRequests;
        $pendingFriends = $friends->where('pivot.status', 0);
        $acceptedFriends = $friends->where('pivot.status', 1);
        $rejectedFriends = $friends->where('pivot.status', 2);
        $blockedFriends = $friends->where('pivot.status', 3);
        return view('friends.index', compact('pendingFriends', 'acceptedFriends', 'rejectedFriends', 'blockedFriends', 'friendRequests'));
    }
    public function store(Request $request){
        $validated = $request->validate([
            'email' => 'exists:users,email'
        ]);
        $friend = User::where('email', $validated['email'])->first();
        $user = Auth::user();
        $user->friends()->attach($friend->id, ['status' => 0]);
        return redirect('/friends');
    }
    public function accept($email){
        $friend = User::where('email', $email)->first();
        $user = Auth::user();
        $friend->friends()->detach($user->id);
        $friend->friends()->attach($user->id, ['status' => 1]);
        $user->friends()->attach($friend->id, ['status' => 1]);
        return redirect('/friends');
    }
    public function decline($email){
        $friend = User::where('email', $email)->first();
        $user = Auth::user();
        $friend->friends()->detach($user->id);
        $friend->friends()->attach($user->id, ['status' => 3]);
        return redirect('/friends');
    }
}
