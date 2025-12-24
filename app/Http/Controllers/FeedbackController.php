<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function feedbacks() {
        $feedbacks = Feedback::with(['sales.customers'])->get();

        return view('feedbacks', compact('feedbacks'));
    }

    public function feedbacks_search(Request $request) {
        $feedbacks = Feedback::when($request->search, function ($query) use ($request) {
            return $query
            ->whereAny([
                'comment',
                'rating'
            ], 'LIKE', '%' . $request->search . '%');
        })
            ->when($request->rating, function ($query) use ($request) {
            return $query->where('rating', $request->rating);
        })->get();
        return view('feedbacks', compact('feedbacks'));
    }
}
