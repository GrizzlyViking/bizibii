<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Redirector;

class AccountForm extends Component
{
    public ?string $name = null;
    public ?string $description = null;
    public ?int $account_id = null;
    public $balance;
    public string $submit = 'Save';

    protected array $rules = [
        'name' => 'required',
        'description' => 'nullable|string',
        'balance' => 'required|numeric'
    ];

    public function mount(?Account $account = null)
    {
        if ($account instanceof Account) {
            $this->name = $account->name;
            $this->description = $account->description;
            $this->balance = $account->balance;
            $this->account_id = $account->id;
            $this->submit = 'update';
        }
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
        $account = $this->validate();
        $account['user_id'] = Auth::id();

        Account::updateOrInsert(
            [
                'id' => $this->account_id,
                'user_id' => Auth::id(),
            ],
            $account
        );

        return redirect()->route('account.index');
    }

    public function delete(Account $account): RedirectResponse|Redirector
    {
        $account->delete();

        return redirect()->route('account.index');
    }
}
