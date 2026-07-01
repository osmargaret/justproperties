<?php

namespace App\Livewire\Buyer;

use App\Models\Media;
use App\Models\Moderation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $activeTab = 'basic';

    public string $govt_id_number = '';

    public ?string $govt_id_expiry = null;

    public string $address = '';

    public ?TemporaryUploadedFile $govt_id_file = null;

    public ?TemporaryUploadedFile $address_proof_file = null;

    public ?TemporaryUploadedFile $facial_image = null;

    public string $current_password = '';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    public string $phone = '';

    public string $whatsapp = '';

    public string $website = '';

    public string $facebook = '';

    public string $twitter = '';

    public string $instagram = '';

    public string $youtube = '';

    public string $linkedin = '';

    public bool $new_inquiries = true;

    public bool $listing_views = true;

    public bool $instant_alerts = true;

    public function mount(): void
    {
        $user = Auth::user();

        $this->phone = $user->phone ?? '';
        $this->whatsapp = $user->whatsapp ?? '';
        $this->website = $user->website ?? '';
        $this->facebook = $user->facebook ?? '';
        $this->twitter = $user->twitter ?? '';
        $this->instagram = $user->instagram ?? '';
        $this->linkedin = $user->linkedin ?? '';
        $this->youtube = $user->youtube ?? '';
    }

    public function submitVerification(): void
    {
        $this->validate([
            'govt_id_number' => ['required', 'string', 'max:50'],
            'govt_id_expiry' => ['required', 'date'],
            'address' => ['required', 'string', 'max:500'],
            'govt_id_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'address_proof_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'facial_image' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = Auth::user();

        $user->update([
            'govt_id_number' => $this->govt_id_number,
            'govt_id_expiry' => $this->govt_id_expiry,
            'address' => $this->address,
        ]);

        $media = [];
        foreach (['govt_id_file', 'address_proof_file', 'facial_image'] as $fileField) {
            $file = $this->{$fileField};
            if ($file) {
                $path = $file->store('verification', 'public');
                $type = $fileField === 'facial_image' ? 'facial' : ($fileField === 'govt_id_file' ? 'govt_id' : 'address_proof');
                $media[] = [
                    'user_id' => $user->id,
                    'mediable_type' => User::class,
                    'mediable_id' => $user->id,
                    'name' => Media::verificationDocumentLabel($type),
                    'path' => $path,
                    'type' => $type,
                    'mime_type' => $file->getMimeType(),
                    'size' => (string) $file->getSize(),
                    'extension' => $file->getClientOriginalExtension() ?: null,
                    'is_primary' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if ($media !== []) {
            Media::insert($media);
        }

        Moderation::create([
            'moderatable_type' => User::class,
            'moderatable_id' => $user->id,
            'action' => 'created',
            'status' => 'pending',
        ]);

        session()->flash('status', __('Verification request submitted. Please wait for review.'));

        $this->reset(['govt_id_number', 'govt_id_expiry', 'address', 'govt_id_file', 'address_proof_file', 'facial_image']);
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', __('The current password is incorrect.'));

            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        session()->flash('status', __('Password updated successfully.'));
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function updateNotifications(): void
    {
        $user = Auth::user();

        $user->update([
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'website' => $this->website,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
        ]);

        session()->flash('status', __('Notification settings updated.'));
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.buyer.profile');
    }
}
