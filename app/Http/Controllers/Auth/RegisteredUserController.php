<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:25',
                'min:3',
                'unique:users',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('username')) {
                $suggestions = $this->generateUsernameSuggestions($request->username);
                $errors->add('username', "This username is taken. Try: ".implode(', ', $suggestions));
            }
            return back()->withErrors($errors)->withInput();
        }


        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'users_username_unique')) {
                $suggestions = $this->generateUsernameSuggestions($request->username);
                return back()->withErrors([
                    'username' => "Username taken just now! Try: ".implode(', ', $suggestions)
                ])->withInput();
            }
            throw $e;
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }


    
    /**
     * Generate alternative username suggestions
     */

    private function generateUsernameSuggestions(string $username): array
    {
        $base = Str::slug($username);//sanitize the username
        $suggestions = [
            $base . rand(1, 100),
            substr($base, 0, 15) . '-' . rand(10, 99),
            $base . '_' . Str::random(3),
            $base . '_' . Str::of(now()->timestamp)->substr(-3),
            $base . '_' . Str::of(uniqid())->substr(-3),
        ];

        //Remove duplicates and existing usernames
        return collect($suggestions)
            ->unique()
            ->reject(function ($suggestion) {
                return User::where('username', $suggestion)->exists();
            })
            ->take(3) // Limit to 5 suggestions
            ->toArray();
    }
    

}
