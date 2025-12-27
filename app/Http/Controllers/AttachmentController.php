<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['file' => 'required|file', 'description' => 'nullable|string']);
        $file = $request->file('file');
        $path = $file->store('attachments', 'public');
        $attachment = Attachment::create([
            'user_id' => $request->user_id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'description' => $request->description
        ]);
        return response()->json(['success' => true, 'attachment' => $attachment]);
    }

    public function update(Request $request, Attachment $attachment)
    {
        $request->validate(['file' => 'nullable|file', 'description' => 'nullable|string']);
        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($attachment->file_path)) Storage::disk('public')->delete($attachment->file_path);
            $file = $request->file('file');
            $path = $file->store('attachments', 'public');
            $attachment->update([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'description' => $request->description
            ]);
        } else {
            $attachment->update(['description' => $request->description]);
        }
        return response()->json(['success' => true, 'attachment' => $attachment]);
    }

    public function destroy(Attachment $attachment)
    {
        if (Storage::disk('public')->exists($attachment->file_path)) Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
        return response()->json(['success' => true]);
    }
}
