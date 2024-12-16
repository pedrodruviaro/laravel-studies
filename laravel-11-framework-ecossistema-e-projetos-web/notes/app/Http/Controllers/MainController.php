<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function index()
    {
        $user_id = session('user.id');
        $notes = User::findOrFail($user_id)->notes()->whereNull('deleted_at')->get();
        $hasNotes = count($notes) > 0;

        return view('home', ['notes' => $notes, 'hasNotes' => $hasNotes]);
    }

    public function new_note()
    {
        return view('new-note');
    }

    public function new_note_submit(Request $request)
    {
        $request->validate(
            [
                'text_title' => ['required', 'min:3', 'max:200'],
                'text_note' => ['required', 'min:3', 'max:3000']
            ],
            [
                'text_title.required' => 'O título é obrigatório',
                'text_note.required' => 'O conteúdo é obrigatório',
                'text_note.min' => 'O conteúdo deve ter no mínimo 3 caracteres',
                'text_note.max' => 'O conteúdo deve ter no máximo 3000 caracteres',
            ]
        );

        $user_id = session('user.id');

        $note = new Note();
        $note->user_id = $user_id;
        $note->title =$request->text_title;
        $note->text =$request->text_note;

        $note->save();

        return redirect()->route('home');
    }

    public function edit_note(string $id)
    {
        $note_id = Operations::decrypt_id($id);

        // load note
        $note = Note::findOrFail($note_id);

        // view
        return view('edit-note', ['note' => $note]);
    }

    public function edit_note_submit(Request $request)
    {
        $request->validate(
            [
                'text_title' => ['required', 'min:3', 'max:200'],
                'text_note' => ['required', 'min:3', 'max:3000']
            ],
            [
                'text_title.required' => 'O título é obrigatório',
                'text_title.min' => 'O título deve ter no mínimo 3 caracteres',
                'text_note.required' => 'O conteúdo é obrigatório',
                'text_note.min' => 'O conteúdo deve ter no mínimo 3 caracteres',
                'text_note.max' => 'O conteúdo deve ter no máximo 3000 caracteres',
            ]
        );

        // decrypt
        if($request->note_id == null) {
            return redirect()->route('home');
        }

        // load note
        $id = Operations::decrypt_id($request->note_id);
        $note = Note::findOrFail($id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        return redirect()->route('home');
    }

    public function delete_note(string $id)
    {
        $note_id = Operations::decrypt_id($id);

        $note = Note::findOrFail($note_id);

        return view('delete', ['note' => $note]);
    }

    public function delete_note_confirm(string $id)
    {
        $note_id = Operations::decrypt_id($id);

        $note = Note::findOrFail($note_id);

        // hard delete (sem config no model)
        // $note->delete();

        // old soft delete
        // $note->deleted_at = date('Y:m:d H:i:s');
        // $note->save();

        // model soft delete
        $note->delete();

        // hard delete via model
        // $note->forceDelete();

        // podemos recuperar posteriormente via restore


        return redirect()->route('home');
    }
}
