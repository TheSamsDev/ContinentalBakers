<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        // Ensure only the authenticated user can view their profile
        if ($user->id != $id) {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.profile.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
    
        // Ensure only the authenticated user can update their profile
        if ($user->id != $id) {
            abort(403, 'Unauthorized action.');
        }
    
        // Validate the input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'language' => 'nullable|string|max:5',
        ]);
    
        // Update user data
        $user->name = $request->input('first_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone', $user->phone);
        $user->address = $request->input('address', $user->address);
        $user->state = $request->input('state', $user->state);
        $user->zip_code = $request->input('zip_code', $user->zip_code);
        $user->language = $request->input('language', $user->language);
    
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
    
        // Save changes
        $user->save();
    
        return redirect()->route('profile.show', $user->id)->with('success', 'Profile updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
