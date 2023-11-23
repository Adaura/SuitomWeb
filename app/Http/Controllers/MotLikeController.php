<?php


namespace App\Http\Controllers;

use App\Models\MotLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotLikeController extends Controller
{
    public function like($motId)
    {
        
        $existing_like = MotLike::where('user_id', Auth::id())->where('mot_id', $motId)->first();

        if ($existing_like) {
            
            $existing_like->delete();
            return back()->with('success', 'Vous avez retiré votre like.');
        } else {
            
            $like = new MotLike(['user_id' => Auth::id(), 'mot_id' => $motId]);
            $like->save();
            return back()->with('success', 'Vous avez liké le mot.');
        }
    }
}
