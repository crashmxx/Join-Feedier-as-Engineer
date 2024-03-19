<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::with('user')->withTrashed()->get();
        return  inertia()->render('Feedback/Index', ['feedbacks' => $feedbacks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->check()) {
            $props = ['user' => auth()->user()];
        } else {
            $props = [];
        }
        return  inertia()->render('Feedback/Create', $props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationRules = [
            'description' => ['required', 'max:255'],
        ];
        if (!auth()->check()) {
            $validationRules['email'] = ['required', 'email'];
        }
        $this->validate($request, $validationRules);

        $feedback = new Feedback([
            'description' => $request->description,
            'email'       => $request->email,
            'type'        => 'dashboard'
        ]);
        // Associated the user connected (we avoid to use the $fillable model property to insert user_id for security reasons)
        if (auth()->check()) {
            auth()->user()->feedbacks()->save($feedback);
        } else {
            $feedback->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        // @todo send success message 'Feedback destroy successfully.' to inertia
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $feedback = Feedback::withTrashed()->findOrFail($id);
        $feedback->restore();
        // @todo send success message 'Feedback restored successfully.' to inertia
    }
}
