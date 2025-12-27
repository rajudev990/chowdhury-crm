<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class UserNoteController extends Controller
{
    public function index(User $user)
    {
        return response()->json($user->notes()->latest()->get());
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'note' => 'required|string|min:3'
        ]);

        $note = $user->notes()->create([
            'note' => $request->note
        ]);

        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'note' => 'required|string|min:3'
        ]);

        $note->update(['note'=>$request->note]);

        return response()->json(['success'=>true]);
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(['success'=>true]);
    }
}
