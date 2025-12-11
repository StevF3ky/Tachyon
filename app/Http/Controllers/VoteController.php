<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request)
    {
        $request->validate([
            'votable_id' => 'required',
            'votable_type' => 'required|in:thread,comment', // Bisa thread atau comment
            'value' => 'required|in:1,-1', // 1 (Up/Like), -1 (Down)
        ]);

        $user = Auth::user();
        
        // Tentukan Model target (Thread atau Comment)
        $modelClass = $request->votable_type === 'thread' ? Thread::class : Comment::class;
        
        // Cek apakah user sudah pernah vote item ini
        $existingVote = Vote::where('user_id', $user->id)
                            ->where('votable_id', $request->votable_id)
                            ->where('votable_type', $modelClass)
                            ->first();

        if ($existingVote) {
            // Skenario 1: User klik tombol yang sama (misal udah Upvote, klik Upvote lagi) -> Hapus Vote
            if ($existingVote->value == $request->value) {
                $existingVote->delete();
                return back();
            }
            // Skenario 2: User ubah vote (misal dari Upvote jadi Downvote) -> Update nilai
            $existingVote->update(['value' => $request->value]);
        } else {
            // Skenario 3: Belum pernah vote -> Buat baru
            Vote::create([
                'user_id' => $user->id,
                'votable_id' => $request->votable_id,
                'votable_type' => $modelClass,
                'value' => $request->value
            ]);
        }

        return back();
    }
}