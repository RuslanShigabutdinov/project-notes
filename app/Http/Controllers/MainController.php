<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\{
    Note,
};

class MainController extends Controller
{
    public function index(){
        $createdNotes = [];
        $guestNotes = [];
        if($user = Auth::user()) {
            $createdNotes = $user->createdNotes;
            $guestNotes = $user->guestNotes;
        }
        return view('index', compact('createdNotes', 'guestNotes'));
    }

    public function noteView($id){
        $note = Note::with('users')->findOrFail($id);
        $friendIds = $note->users->pluck('id')->toArray();
        $friends = Auth::user()->friends;
        return view('noteView', compact('note', 'friends', 'friendIds'));
    }
    public function noteDelete($id){
        $note = Note::findOrFail($id);
        if($note->creator_id == Auth::id()) {
            $note->delete;
            return redirect('/');
        }
        return redirect()->back();
    }

    public function noteColorCreate(Request $request){
        $request->session()->flash('note_color', $request->note_color);
        $request->session()->flash('text_color', $request->text_color);
        $request->session()->flash('line_color', $request->line_color);
        return redirect('/note/create');
    }
    public function noteColorUpdate(Request $request){
        $note = Note::findOrFail($request->id);
        $note->update([
            'note_color'=> $request->note_color,
            'text_color'=> $request->text_color,
            'line_color'=> $request->line_color,
        ]);
        return redirect('/note/'.$request->id.'/edit');
    }
    public function noteUpdate(Request $request){
        $validated = $request->validate([
            'id' => 'integer|required|exists:notes',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string',
            'content' => 'nullable|string',
        ]);
        $note = Note::findOrFail($validated['id']);
        if(isset($validated['image'])) {
            // delete old image if exists
            if($note->image) {
                if (Storage::exists($note->image)) Storage::delete($note->image);
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img/notes'), $imageName);
            $validated['image'] = 'img/notes/'.$imageName;
        }
        $note->update($validated);
        return redirect('/note/'.$request->id);
    }

    public function noteEdit($id){
        $note = Note::findOrFail($id);
        return view('noteEdit', compact('note'));
    }

    public function noteCreate(Request $request){
        $note_color = '#fff';
        $text_color = '#000';
        $line_color = '#395bf5';
        if (Request()->session()->has('line_color')) {
            $note_color = Request()->session()->get('note_color');
            $text_color = Request()->session()->get('text_color');
            $line_color = Request()->session()->get('line_color');
        }
        $request->session()->reflash();
        return view('noteCreate', compact('note_color', 'text_color', 'line_color'));
    }

    public function noteSubmit(Request $request){
        $request->session()->reflash();
        $validated = $request->validate([
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        $validated['creator_id'] = Auth()->id();
        if (Request()->session()->has('line_color')) {
            $validated['note_color'] = Request()->session()->get('note_color');
            $validated['text_color'] = Request()->session()->get('text_color');
            $validated['line_color'] = Request()->session()->get('line_color');
        }
        if(isset($validated['image'])){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img/notes'), $imageName);
            $validated['image'] = 'img/notes/'.$imageName;
        }
        $note = Note::create($validated);
        return redirect('/note/'.$note->id);
    }

    public function noteAddFriend($id, Request $request){
        $note = Note::findOrFail($id);
        // Пользователи которые уже прикреплены к записке
        $attachedFriends = $note->users->pluck('id')->toArray();
        // пользователи которые были выбраны в чекбоксе
        $friendsField = $request->friends;
        $friendsToAttach = array_diff($friendsField, $attachedFriends);
        $friendsToDetach = array_diff($attachedFriends, $friendsField);
        $note->users()->detach($friendsToDetach);
        $note->users()->attach($friendsToAttach);
        return redirect('/note/'.$id);
    }
}
