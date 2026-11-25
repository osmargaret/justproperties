<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Currency;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCurrencies extends Component
{
    use WithPagination;

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $search = '';

    public string $currency_code = '';

    public string $currency_name = '';

    public string $currency_symbol = '';

    public ?string $payment_gateway = null;

    public bool $show_manual_payment = false;

    public string $bank_name = '';

    public string $bank_account_number = '';

    public string $account_name = '';

    public string $swift_code = '';

    public string $bank_instructions = '';

    public function openCreate(): void
    {
        $this->resetCurrencyForm();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $currency = Currency::query()->findOrFail($id);
        $bankDetails = $currency->bank_details ?? [];

        $this->editingId = $currency->id;
        $this->currency_code = $currency->currency_code;
        $this->currency_name = $currency->currency_name;
        $this->currency_symbol = (string) ($currency->currency_symbol ?? '');
        $this->payment_gateway = $currency->payment_gateway;
        $this->show_manual_payment = ! empty($bankDetails);
        $this->bank_name = $bankDetails['bank_name'] ?? '';
        $this->bank_account_number = $bankDetails['bank_account_number'] ?? '';
        $this->account_name = $bankDetails['account_name'] ?? '';
        $this->swift_code = $bankDetails['swift_code'] ?? '';
        $this->bank_instructions = $bankDetails['instructions'] ?? '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->editingId = null;
    }

    public function saveCurrency(): void
    {
        $this->currency_code = strtoupper(trim($this->currency_code));

        if ($this->editingId) {
            $existingCurrency = Currency::query()->findOrFail($this->editingId);
            if (
                $existingCurrency->currency_code !== $this->currency_code
                && (
                    $existingCurrency->promotionPlanPrices()->exists()
                    || $existingCurrency->advertisementPlanPrices()->exists()
                    || $existingCurrency->countries()->exists()
                    || $existingCurrency->payments()->exists()
                )
            ) {
                $this->addError('currency_code', __('The code cannot be changed while this currency is used by plans, assigned to countries, or referenced by payments.'));

                return;
            }
        }

        $currencyCodeRule = Rule::unique('currencies', 'currency_code');
        if ($this->editingId) {
            $currencyCodeRule->ignore($this->editingId);
        }

        $this->validate([
            'currency_code' => [
                'required',
                'string',
                'size:3',
                $currencyCodeRule,
            ],
            'currency_name' => ['required', 'string', 'max:150'],
            'currency_symbol' => ['nullable', 'string', 'max:16'],
            'payment_gateway' => ['nullable', 'string', Rule::in(['paystack', 'flutterwave'])],
            'show_manual_payment' => ['boolean'],
            'bank_name' => [$this->show_manual_payment ? 'required' : 'nullable', 'string', 'max:255'],
            'bank_account_number' => [$this->show_manual_payment ? 'required' : 'nullable', 'string', 'max:255'],
            'account_name' => [$this->show_manual_payment ? 'required' : 'nullable', 'string', 'max:255'],
            'swift_code' => ['nullable', 'string', 'max:255'],
            'bank_instructions' => ['nullable', 'string'],
        ]);

        $payload = [
            'currency_code' => $this->currency_code,
            'currency_name' => $this->currency_name,
            'currency_symbol' => $this->currency_symbol !== '' ? $this->currency_symbol : null,
            'payment_gateway' => $this->payment_gateway ?: null,
            'bank_details' => $this->show_manual_payment ? [
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'account_name' => $this->account_name,
                'swift_code' => $this->swift_code,
                'instructions' => $this->bank_instructions,
            ] : null,
        ];

        if ($this->editingId) {
            Currency::query()->findOrFail($this->editingId)->update($payload);
        } else {
            Currency::query()->create($payload);
        }

        session()->flash('status', __('Currency saved.'));
        $this->closeModal();
    }

    public function deleteCurrency(int $id): void
    {
        $currency = Currency::query()->findOrFail($id);

        if (
            $currency->promotionPlanPrices()->exists()
            || $currency->advertisementPlanPrices()->exists()
            || $currency->countries()->exists()
            || $currency->payments()->exists()
        ) {
            session()->flash('error', __('Cannot delete a currency used by plans, assigned to countries, or referenced by payments.'));

            return;
        }

        $currency->delete();
        session()->flash('status', __('Currency deleted.'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.settings.admin-currencies', [
            'currencies' => Currency::query()
                ->withCount(['promotionPlanPrices', 'advertisementPlanPrices'])
                ->when(trim($this->search) !== '', function ($query): void {
                    $search = '%'.trim($this->search).'%';

                    $query->where(function ($query) use ($search): void {
                        $query->where('currency_code', 'like', $search)
                            ->orWhere('currency_name', 'like', $search)
                            ->orWhere('currency_symbol', 'like', $search);
                    });
                })
                ->orderBy('currency_code')
                ->paginate(15),
        ]);
    }

    private function resetCurrencyForm(): void
    {
        $this->editingId = null;
        $this->currency_code = '';
        $this->currency_name = '';
        $this->currency_symbol = '';
        $this->payment_gateway = null;
        $this->show_manual_payment = false;
        $this->bank_name = '';
        $this->bank_account_number = '';
        $this->account_name = '';
        $this->swift_code = '';
        $this->bank_instructions = '';
    }
}
