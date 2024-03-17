<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use GuzzleHttp\Client;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function fetchUsers()
    {
        $client = new Client();

        try {
            $users = $client->request('GET', 'https://api.github.com/users?per_page=10');
            $users = json_decode($users->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Log the error message for debugging
            error_log($e->getMessage());

            // Return a default error message
            return ['error' => 'An error occurred while fetching user details.'];
        }

        // foreach ($users as &$user) {
        //     $userDetailsResponse = $client->request('GET', $user['url']);
        //     $user['details'] = json_decode($userDetailsResponse->getBody()->getContents(), true);
        // }

        return $users;
    }

    public function fetchMoreUsers($param)
    {
        $client = new Client();
        $limit = $param ?? 10;

        try {
            $users = $client->request('GET', 'https://api.github.com/users?per_page=' . $limit);
            $users = json_decode($users->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Log the error message for debugging
            error_log($e->getMessage());

            // Return a default error message
            return ['error' => 'An error occurred while fetching user details.'];
        }
        return $users;
    }

    public function fetchUserDetails($username)
    {
        $client = new Client();
        try {
            $userResponse = $client->request('GET', 'https://api.github.com/users/' . $username);
            $user = json_decode($userResponse->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Log the error message for debugging
            error_log($e->getMessage());

            // Return a default error message
            return ['error' => 'An error occurred while fetching user details.'];
        }

        return $user;
    }
}
