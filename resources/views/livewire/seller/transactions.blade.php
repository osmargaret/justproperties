<div class="min-w-0 w-full">
    <main class="white-header min-w-0 max-w-7xl mx-auto w-full px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        <div class="grid min-w-0 grid-cols-1 lg:grid-cols-[300px_minmax(0,1fr)] gap-8">
            @include('layouts.seller-sidebar')

            <div class="min-w-0 space-y-8">
                <!-- Page Header -->
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <h1 class="text-3xl font-bold mb-2">Transaction History</h1>
                    <p class="text-gray-500">View and manage all your payment transactions</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-md hover:-translate-y-1 transition-transform">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 text-2xl mb-4">
                            <i class="ri-bank-card-line"></i>
                        </div>
                        <div class="text-3xl font-bold mb-1">{{ $this->userCurrency?->symbol ?? '₦' }}{{ number_format($this->payments->sum('total'), 0) }}</div>
                        <div class="text-gray-500 text-sm">Total Spent</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-md hover:-translate-y-1 transition-transform">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 text-2xl mb-4">
                            <i class="ri-swap-line"></i>
                        </div>
                        <div class="text-3xl font-bold mb-1">{{ $this->payments->total() }}</div>
                        <div class="text-gray-500 text-sm">Transactions</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-md hover:-translate-y-1 transition-transform">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 text-2xl mb-4">
                            <i class="ri-check-line"></i>
                        </div>
                        <div class="text-3xl font-bold mb-1">{{ $this->payments->where('status', 'success')->count() }}</div>
                        <div class="text-gray-500 text-sm">Successful</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-md hover:-translate-y-1 transition-transform">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 text-2xl mb-4">
                            <i class="ri-refund-line"></i>
                        </div>
                        <div class="text-3xl font-bold mb-1">{{ $this->userCurrency?->symbol ?? '₦' }}{{ number_format($this->payments->where('status', 'refunded')->sum('total'), 0) }}</div>
                        <div class="text-gray-500 text-sm">Total Refunds</div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Date Range</label>
                            <select wire:model.live="dateRange" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Transaction Type</label>
                            <select wire:model.live="transactionType" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="all">All Types</option>
                                <option value="subscription">Subscription</option>
                                <option value="promotion">Promotion</option>
                                <option value="featured">Featured Listing</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Status</label>
                            <select wire:model.live="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="all">All Status</option>
                                <option value="success">Successful</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="flex gap-2 items-end">
                            <button wire:click="resetFilters" class="flex-1 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200">Reset Filters</button>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex min-w-0 gap-4">
                    <div class="min-w-0 flex-1 relative">
                        <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" wire:model.live="search" placeholder="Search transactions by ID, description, or amount..." class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="min-w-0 bg-white rounded-xl p-6 shadow-md">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold">Recent Transactions</h2>
                        <span class="text-gray-500 text-sm">{{ $this->payments->count() }} transactions</span>
                    </div>
                    <div class="min-w-0 w-full overflow-x-auto overscroll-x-contain">
                        @if($this->payments->count())
                            <table class="w-full min-w-[1000px]">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="text-left py-4 px-4 text-gray-500 font-medium text-sm">Transaction</th>
                                        <th class="text-left py-4 px-4 text-gray-500 font-medium text-sm">Date</th>
                                        <th class="text-left py-4 px-4 text-gray-500 font-medium text-sm">Type</th>
                                        <th class="text-left py-4 px-4 text-gray-500 font-medium text-sm">Payment Method</th>
                                        <th class="text-left py-4 px-4 text-gray-500 font-medium text-sm">Status</th>
                                        <th class="text-left py-4 px-4 text-gray-500 font-medium text-sm">Amount</th>
                                        <th class="text-left py-4 px-4 text-gray-500 font-medium text-sm">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($this->payments as $payment)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="py-4 px-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                                                        @if(str_contains($payment->paymentable_type, 'Subscription'))
                                                            <i class="ri-crown-line"></i>
                                                        @elseif(str_contains($payment->paymentable_type, 'Promotion'))
                                                            <i class="ri-star-line"></i>
                                                        @elseif(str_contains($payment->paymentable_type, 'FeaturedProperty'))
                                                            <i class="ri-fire-line"></i>
                                                        @else
                                                            <i class="ri-home-4-line"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h4 class="font-medium">{{ ucfirst(str_replace('_', ' ', class_basename($payment->paymentable_type))) }}</h4>
                                                        <p class="text-gray-500 text-xs">{{ $payment->reference }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4">
                                                {{ $payment->created_at->format('M d, Y') }}<br>
                                                <span class="text-gray-400 text-xs">{{ $payment->created_at->format('g:i A') }}</span>
                                            </td>
                                            <td class="py-4 px-4">{{ str_replace('_', ' ', class_basename($payment->paymentable_type)) }}</td>
                                            <td class="py-4 px-4"><span class="font-medium">{{ ucfirst($payment->method ?? 'Unknown') }}</span></td>
                                            <td class="py-4 px-4">
                                                @if($payment->status === 'success')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                                        <i class="ri-check-line"></i> Completed
                                                    </span>
                                                @elseif($payment->status === 'pending')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                                        <i class="ri-time-line"></i> Pending
                                                    </span>
                                                @elseif($payment->status === 'failed')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                                        <i class="ri-close-line"></i> Failed
                                                    </span>
                                                @elseif($payment->status === 'refunded')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                                        <i class="ri-refund-line"></i> Refunded
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 font-semibold @if($payment->status === 'refunded') text-red-600 @else text-emerald-600 @endif">
                                                {{ $this->userCurrency?->symbol ?? '₦' }}{{ number_format($payment->total, 2) }}
                                            </td>
                                            <td class="py-4 px-4">
                                                <button wire:click="openPaymentModal({{ $payment->id }})" class="text-gray-400 hover:text-emerald-600">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                                No transactions found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                No transactions found
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if($this->payments->count())
                        <div class="flex items-center justify-between mt-8">
                            <div class="text-gray-500 text-sm">
                                Showing {{ $this->payments->firstItem() }} to {{ $this->payments->lastItem() }} of {{ $this->payments->total() }} transactions
                            </div>
                            <div class="flex gap-2">
                                {{ $this->payments->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Payment Details Modal -->
    @if($showPaymentModal && $selectedPayment)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-6 border-b">
                    <h3 class="text-xl font-semibold">Payment Details</h3>
                    <button wire:click="closePaymentModal" class="text-2xl text-gray-400 hover:text-gray-500">&times;</button>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Transaction ID -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction ID</label>
                        <p class="text-gray-900 font-mono">{{ $selectedPayment->reference }}</p>
                    </div>

                    <!-- Request ID (Gateway Reference) -->
                    @if($selectedPayment->request_id)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gateway Reference</label>
                            <p class="text-gray-900 font-mono text-sm break-all">{{ $selectedPayment->request_id }}</p>
                        </div>
                    @endif

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Type</label>
                        <p class="text-gray-900">{{ str_replace('_', ' ', class_basename($selectedPayment->paymentable_type)) }}</p>
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <p class="text-gray-900">{{ $selectedPayment->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <p class="text-gray-900">{{ ucfirst($selectedPayment->method ?? 'Unknown') }} ({{ ucfirst($selectedPayment->gateway ?? 'Unknown') }})</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div>
                            @if($selectedPayment->status === 'success')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                    <i class="ri-check-line"></i> Completed
                                </span>
                            @elseif($selectedPayment->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                    <i class="ri-time-line"></i> Pending
                                </span>
                            @elseif($selectedPayment->status === 'failed')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                    <i class="ri-close-line"></i> Failed
                                </span>
                            @elseif($selectedPayment->status === 'refunded')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                    <i class="ri-refund-line"></i> Refunded
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Amount Breakdown -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Amount</span>
                            <span class="font-semibold">{{ $this->userCurrency?->symbol ?? '₦' }}{{ number_format($selectedPayment->amount, 2) }}</span>
                        </div>
                        @if($selectedPayment->coupon_value > 0)
                            <div class="flex justify-between items-center text-emerald-600">
                                <span>Coupon Discount</span>
                                <span class="font-semibold">-{{ $this->userCurrency?->symbol ?? '₦' }}{{ number_format($selectedPayment->coupon_value, 2) }}</span>
                            </div>
                        @endif
                        @if($selectedPayment->vat_value > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">VAT ({{ $selectedPayment->vat_rate }}%)</span>
                                <span class="font-semibold">{{ $this->userCurrency?->symbol ?? '₦' }}{{ number_format($selectedPayment->vat_value, 2) }}</span>
                            </div>
                        @endif
                        <div class="border-t border-gray-200 pt-2 flex justify-between items-center font-bold text-lg">
                            <span class="text-gray-900">Total</span>
                            <span class="text-emerald-600">{{ $this->userCurrency?->symbol ?? '₦' }}{{ number_format($selectedPayment->total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Paid At -->
                    @if($selectedPayment->paid_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Paid At</label>
                            <p class="text-gray-900">{{ $selectedPayment->paid_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    @endif
                </div>
                <div class="p-6 border-t flex gap-4 justify-end">
                    <button wire:click="closePaymentModal" class="px-4 py-2 bg-gray-100 rounded-lg font-medium hover:bg-gray-200">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>