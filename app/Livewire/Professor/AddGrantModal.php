<?php

namespace App\Livewire\Professor;

use App\Models\Grant;
use App\Models\GrantType;
use App\Models\Currency;
use App\Models\FundingSource;
use App\Models\ProfessorGrant;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\GrantRoleEnum;
use Carbon\Carbon;

class AddGrantModal extends Component
{
    public $name;
    public $amount;
    public $grant_type_id;
    public $currency_id;
    public $funding_source_id;
    public $role;
    public $professor_id;
    public $edit_mode = false;
    public $grant_to_edit;
    public $start_date;
    public $end_date;
    public $notes;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'grant_type_id' => 'required',
            'currency_id' => 'required',
            'funding_source_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'nullable|after:start_date',
            'role' => 'required|in:' . implode(',', GrantRoleEnum::values()),
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->grant_type_id = GrantType::first()->id;
        $this->currency_id = Currency::first()->id;
        $this->funding_source_id = FundingSource::first()->id;
        $this->role = GrantRoleEnum::values()[0];
        $this->start_date = Carbon::now()->format('d/m/Y');
        $this->end_date = Carbon::now()->endOfYear()->format('d/m/Y');
    }

    protected $listeners = [
        'update_grant' => 'updateGrant',
        'delete_grant' => 'deleteGrant',
        'start_date_updated' => 'updateStartDate',
        'end_date_updated' => 'updateEndDate',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $grantTypes = GrantType::all();
        $currencies = Currency::all();
        $fundingSources = FundingSource::all();
        $roles = GrantRoleEnum::values();
        
        return view('livewire.professors.add-grant-modal', compact('grantTypes', 'currencies', 'fundingSources', 'roles'));
    }

    public function submit()
    {
        // Validate the form input data
        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing professor grant
                $grant = Grant::findOrFail($this->grant_to_edit);
                $professorGrant = ProfessorGrant::where('grant_id', $this->grant_to_edit)->where('professor_id', Auth::user()->professor->id)->first();

                $grant->update([
                    'name' => $this->name,
                    'amount' => $this->amount,
                    'grant_type_id' => $this->grant_type_id,
                    'currency_id' => $this->currency_id,
                    'funding_source_id' => $this->funding_source_id,
                    'start_date' => Carbon::createFromFormat('d/m/Y',$this->start_date)->format('Y-m-d'),
                    'end_date' => Carbon::createFromFormat('d/m/Y', $this->end_date)->format('Y-m-d'),
                    'notes' => $this->notes,
                ]);
                $professorGrant->update([
                    'role' => $this->role,
                ]);
            } else {
                // Create a new professor grant
                $grant = Grant::create([
                    'name' => $this->name,
                    'amount' => $this->amount,
                    'grant_type_id' => $this->grant_type_id,
                    'currency_id' => $this->currency_id,
                    'funding_source_id' => $this->funding_source_id,
                    'start_date' => Carbon::createFromFormat('d/m/Y',$this->start_date)->format('Y-m-d'),
                    'end_date' => Carbon::createFromFormat('d/m/Y', $this->end_date)->format('Y-m-d'),
                    'notes' => $this->notes,
                ]);

                ProfessorGrant::create([
                    'professor_id' =>  Auth::user()->professor->id,
                    'grant_id' => $grant->id,
                    'role' => $this->role,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Grant successfully updated.' : 'Grant successfully added.');
    }

    public function deleteGrant($id)
    {
        $grant = ProfessorGrant::findOrFail($id);

        $grant->delete();

        $this->dispatch('success', 'This grant has been successfully deleted.');
    }

    public function updateGrant($id)
    {
        $this->edit_mode = true;
        $this->grant_to_edit = $id;
        $grant = Grant::find($id);
        $professorGrant = ProfessorGrant::where('grant_id', $id)->where('professor_id', Auth::user()->professor->id)->first();
        if(!$grant) {
            $grant = ProfessorGrant::find($id)->grant;
        }

        $this->name = $grant->name;
        $this->amount = $grant->amount;
        $this->grant_type_id = $grant->grant_type_id;
        $this->currency_id = $grant->currency_id;
        $this->funding_source_id = $grant->funding_source_id;
        $this->role = $professorGrant->role;
        $this->start_date = Carbon::createFromFormat('Y-m-d',$grant->start_date)->format('d/m/Y');
        $this->end_date = Carbon::createFromFormat('Y-m-d', $grant->end_date)->format('d/m/Y');
        $this->notes = $grant->notes;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updateStartDate($value)
    {
        $this->start_date = $value;
    }

    public function updateEndDate($value)
    {
        $this->end_date = $value;
    }

    public function resetForm()
    {
        $this->reset(['name', 'amount', 'grant_type_id', 'currency_id', 'funding_source_id', 'role', 'start_date', 'end_date', 'notes', 'edit_mode', 'grant_to_edit']);
        $this->mount();
    }
}
