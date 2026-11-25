<?php

namespace App\Livewire\Admin\Settings;

use App\Jobs\FetchCountryStates;
use App\Models\Country;
use App\Models\CountrySetting;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCountries extends Component
{
    use WithPagination;

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $search = '';

    public string $name = '';

    public string $code = '';

    public string $slug = '';

    public string $flag = '';

    public string $phone_code = '';

    public string $language_code = '';

    public bool $is_default = false;

    public string $currency = '';

    public string $currency_code = '';

    public string $currency_symbol = '';

    public function openCreate(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->code = '';
        $this->slug = '';
        $this->flag = '';
        $this->phone_code = '';
        $this->language_code = '';
        $this->is_default = false;
        $this->currency = '';
        $this->currency_code = '';
        $this->currency_symbol = '';
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $country = Country::query()->findOrFail($id);
        $this->editingId = $country->id;
        $this->name = $country->name;
        $this->code = (string) ($country->code ?? '');
        $this->slug = (string) ($country->slug ?? '');
        $this->flag = (string) ($country->flag ?? '');
        $this->phone_code = (string) ($country->phone_code ?? '');
        $this->language_code = (string) ($country->language_code ?? '');
        $this->is_default = (bool) $country->is_default;
        $this->currency = (string) ($country->currency ?? '');
        $this->currency_code = (string) ($country->currency_code ?? '');
        $this->currency_symbol = (string) ($country->currency_symbol ?? '');
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->editingId = null;
    }

    public function saveCountry(): void
    {
        $codeRules = ['nullable', 'string', 'max:8'];
        if ($this->code !== '') {
            $codeRules[] = $this->editingId
                ? Rule::unique('countries', 'code')->ignore($this->editingId)
                : Rule::unique('countries', 'code');
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => $codeRules,
            'slug' => ['nullable', 'string', 'max:255'],
            'flag' => ['nullable', 'string', 'max:32'],
            'phone_code' => ['nullable', 'string', 'max:32'],
            'language_code' => ['nullable', 'string', 'max:16'],
            'is_default' => ['boolean'],
            
            'currency' => ['nullable', 'string', 'max:255'],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'currency_symbol' => ['nullable', 'string', 'max:8'],
        ]);

        $payload = [
            'name'          => $this->name,
            'code'          => $this->code !== '' ? strtoupper($this->code) : null,
            'slug'          => $this->slug !== '' ? Str::slug($this->slug) : null,
            'flag'          => $this->flag !== '' ? $this->flag : null,
            'phone_code'    => $this->phone_code !== '' ? $this->phone_code : null,
            'language_code' => $this->language_code !== '' ? $this->language_code : null,
            'currency' => $this->currency !== '' ? $this->currency : null,
            'currency_code' => $this->currency_code !== '' ? strtoupper($this->currency_code) : null,
            'currency_symbol' => $this->currency_symbol !== '' ? $this->currency_symbol : null,
        ];

        if ($this->is_default) {
            Country::query()->update(['is_default' => false]);
            $payload['is_default'] = true;
        } else {
            $payload['is_default'] = false;
        }

        if ($this->editingId) {
            $country = Country::query()->findOrFail($this->editingId);
            $country->update($payload);
        } else {
            $country = Country::query()->create($payload);

            // Fetch states for the newly created country in the background.
            if ($country && ! $country->states()->exists()) {
                FetchCountryStates::dispatch($country);
            }
        }

        session()->flash('status', __('Country saved.'));
        $this->closeModal();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function setDefault(int $id): void
    {
        Country::query()->update(['is_default' => false]);
        Country::query()->whereKey($id)->update(['is_default' => true]);
        session()->flash('status', __('Default country updated.'));
    }

    public function deleteCountry(int $id): void
    {
        $country = Country::query()->findOrFail($id);
        if ($country->users()->exists() || $country->properties()->exists() || $country->payments()->exists()) {
            session()->flash('error', __('Cannot delete a country that has users, properties, or payments.'));

            return;
        }
        if ($country->is_default) {
            session()->flash('error', __('Unset default before deleting.'));

            return;
        }
        CountrySetting::query()->where('country_id', $country->id)->delete();
        $country->delete();
        session()->flash('status', __('Country deleted.'));
    }

    public function render()
    {
        $countries = Country::query()
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->orderByDesc('is_default')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('livewire.admin.settings.admin-countries', ['countries' => $countries]);
    }
}
