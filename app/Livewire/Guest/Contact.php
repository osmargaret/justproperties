<?php

namespace App\Livewire\Guest;

use App\Models\Faq;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $subject = '';
    public string $message = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ];
    }

    public function send(): void
    {
        $validatedData = $this->validate();

        try {
            $toEmail = config('mail.from.address') ?: env('MAIL_FROM_ADDRESS', 'admin@example.com');
            Mail::to($toEmail)->send(new ContactMessage($validatedData));

            $this->reset(['name', 'email', 'phone', 'subject', 'message']);

            session()->flash('status', __('Thank you for contacting us! We will get back to you shortly.'));
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to send message: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $faqs = Faq::query()
            ->where('is_active', true)
            ->where('show_on_contact_page', true)
            ->latest()
            ->get();

        return view('livewire.guest.contact', [
            'faqs' => $faqs,
        ]);
    }
}
