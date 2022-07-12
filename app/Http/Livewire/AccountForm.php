<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Reality;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Redirector;

class AccountForm extends Component
{

    public ?Account $account;

    public $show_modal = false;

    public $checkpoint_date;

    public $checkpoint_amount;

    public string $submit = 'Save';

    protected array $rules = [
        'account.name'        => 'required',
        'account.description' => 'nullable|string',
        'account.balance'     => 'required|numeric',
    ];

    protected array $validationAttributes = [
        'account.name'        => 'name of account',
        'account.balance'     => 'account starting balance',
        'account.description' => 'description',
    ];

    public function mount(?Account $account)
    {
        $this->account = $account ?? new Account();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.account-form');
    }

    /**
     * @param $propertName
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated($propertName): void
    {
        $this->validateOnly($propertName);
    }

    public function submit(): RedirectResponse|Redirector
    {
        $this->validate();

        if (!isset($this->account->user_id)) {
            $this->account->user_id = Auth::id();
        }

        $this->account->save();

        return redirect()->route('account.index');
    }

    public function delete(Account $account): RedirectResponse|Redirector
    {
        $account->delete();

        return redirect()->route('account.index');
    }

    public function addCheckpoint()
    {
        $validatedData = $this->validate([
            'checkpoint_date'   => 'required|date',
            'checkpoint_amount' => 'required|numeric',
        ]);

        Reality::create([
            'checkpointable_id'   => $this->account->id,
            'checkpointable_type' => $this->account::class,
            'checkpoint'          => $validatedData['checkpoint_amount'],
            'registered_date'     => $validatedData['checkpoint_date'],
        ]);

        $this->account = Account::find($this->account_id);

        $this->show_modal = false;
    }

}
