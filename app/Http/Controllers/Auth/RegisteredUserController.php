<?php

namespace App\Http\Controllers\Auth;

use App\Enums\WorkspaceInviteStatusEnum;
use App\Enums\WorkspaceTypeEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\Workspace;
use App\Models\WorkspaceInvitation;
use App\Models\WorkspaceMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-up/general.js');

        return view('pages/auth.register');
    }

    public function createFromInvitation()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-up/general.js');
        $workspace_invitation = WorkspaceInvitation::where('code', request()->invite_code)->where('invited_email', request()->email)->first();

       if(isset($workspace_invitation) && ($workspace_invitation->status !== WorkspaceInviteStatusEnum::REGISTERED->value)) {
            $workspace_invitation->update([
                'status' => WorkspaceInviteStatusEnum::IN_PROGRESS->value,
            ]);
        } else {
            return redirect()->route('register');
        }

        return view('pages/auth.register-from-invitation');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'toc' => ['required'],
        ]);

        $subscription_type = WorkspaceTypeEnum::from($request->subscription_type)->value;

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => 'owner',
            'password' => Hash::make($request->password),
            'last_login_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        $workspace = Workspace::create([
            'owner_id' => $user->id,
            'type' => $subscription_type,
            'name' => $request->first_name . ' ' . $request->last_name . ' Workspace'
        ]);

        WorkspaceMember::create([
            'workspace_id' => $workspace->id,
            'user_id' => $user->id,
        ]);

        $user->update([
            'workspace_id' => $workspace->id
        ]);


        event(new Registered($user));

        Auth::login($user);

        
        return redirect()->route('verification.notice');
    }

    public function storeFromInvitation(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'selected_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'invitation_code' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'toc' => ['required'],
        ]);

        $workspace_invitation = WorkspaceInvitation::where('code', $request->invitation_code)
            ->where('invited_email', $request->selected_email)
            ->first();

        if(isset($workspace_invitation)) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->selected_email,
                'role' => 'member',
                'password' => Hash::make($request->password),
                'last_login_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);

            $workspace = $workspace_invitation->workspace;

            WorkspaceMember::create([
                'workspace_id' => $workspace->id,
                'user_id' => $user->id,
            ]);

            $user->update([
                'workspace_id' => $workspace->id
            ]);

            $workspace_invitation->update([
                'status' => WorkspaceInviteStatusEnum::REGISTERED->value,
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('verification.notice');
        }
    }
}
