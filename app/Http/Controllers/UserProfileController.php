<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response; // Import Inertia Response type

class UserProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     *
     * @param  string $username
     * @return Response
     */
    public function show(string $username): Response
    {
        //find the user by username or fail with a 404 error
        $user = User::where('username', $username)->firstOrFail();

        //prepare data for the frontend
        $profileData = [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,

            //conditionally generate profile picture URL public/profiles
            'profile_pic' => $user->profile_pic ? Storage::url('images/profiles/' . $user->profile_pic) : null,

            'join_date' => $user->formatted_join_date, // Accessor for formatted join date
            'created_at' => $user->created_at,
        ];

       // Render the Inertia view, passing the user data
       return Inertia::render('Profile/Show', [ // View name: Profile/Show.vue
            'profileUser' => $profileData, // Pass data under 'profileUser' prop
       ]);
    }

}
