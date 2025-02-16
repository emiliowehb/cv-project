<?php

namespace App\Livewire\Workspace;

use App\Enums\WorkspaceInviteStatusEnum;
use App\Events\NewMemberInvited;
use App\Models\User;
use App\Models\WorkspaceInvitation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class InviteMemberModal extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;

    protected $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:workspace_invitations,invited_email|unique:users,email',
    ];

    protected $messages = [
        'email.unique' => 'The email address has already been invited to this workspace, or the email associated with this invite already exists in another workspace.',
    ];

    protected $listeners = [
        'revoke_invitation' => 'revokeInvitation'
    ];

    public function render()
    {
        return view('livewire.workspace.invite-member-modal');
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate($this->rules, $this->messages);

        DB::transaction(function () {
            // Generate a random 14-digit code
            $code = bin2hex(random_bytes(7));

            // Prepare the data for creating a new workspace invitation
            $data = [
                'full_name' => $this->first_name . ' ' . $this->last_name,
                'invited_email' => $this->email,
                'workspace_id' => Auth::user()->workspace->id,
                'status' => WorkspaceInviteStatusEnum::PENDING->value,
                'code' => $code,
            ];

            // Create the workspace invitation
            WorkspaceInvitation::create($data);

            $data['workspace_name'] = Auth::user()->workspace->name;

            // Dispatch the event to send the invitation email
            event(new NewMemberInvited($data));
        });

        // Reset the form fields after successful submission
        $this->reset();

        $this->dispatch('success', 'Member successfully invited.');
    }

    public function revokeInvitation($id)
    {
        $invitation = WorkspaceInvitation::findOrFail($id);

        $invitation->delete();

        $this->dispatch('success', 'Invitation successfully revoked.');
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
