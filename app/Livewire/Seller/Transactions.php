<?php

namespace App\Livewire\Seller;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Transactions extends Component
{
    use WithPagination;

    public string $search = '';
    public string $dateRange = 'all';
    public string $transactionType = 'all';
    public string $status = 'all';
    
    public ?Payment $selectedPayment = null;
    public bool $showPaymentModal = false;

    protected $queryString = ['search', 'dateRange', 'transactionType', 'status'];

    #[\Livewire\Attributes\Computed]
    public function payments()
    {
        $query = Payment::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Search by transaction ID, description, or amount
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('reference', 'like', "%{$this->search}%")
                  ->orWhere('amount', $this->search)
                  ->orWhere('total', $this->search);
            });
        }

        // Filter by date range
        if ($this->dateRange !== 'all') {
            $now = Carbon::now();
            match ($this->dateRange) {
                'today' => $query->whereDate('created_at', $now->toDateString()),
                'week' => $query->whereBetween('created_at', [$now->clone()->startOfWeek(), $now->clone()->endOfWeek()]),
                'month' => $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year),
                'year' => $query->whereYear('created_at', $now->year),
                default => null,
            };
        }

        // Filter by transaction type
        if ($this->transactionType !== 'all') {
            $query->where('paymentable_type', 'like', "%{$this->transactionType}%");
        }

        // Filter by status
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        return $query->paginate(10);
    }

    #[\Livewire\Attributes\Computed]
    public function userCurrency()
    {
        return Auth::user()->country?->currency;
    }

    public function openPaymentModal(Payment $payment)
    {
        $this->selectedPayment = $payment;
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedPayment = null;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->dateRange = 'all';
        $this->transactionType = 'all';
        $this->status = 'all';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.seller.transactions');
    }
}
