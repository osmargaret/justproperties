<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.partials.role-sidebar')

            <div class="space-y-6">
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-semibold">{{ $property->name }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $property->full_address }}</p>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700">Status: {{ str_replace('_', ' ', ucfirst($property->status)) }}</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-amber-100 text-amber-700">Moderation: {{ ucfirst($property->moderation_status ?? 'pending') }}</span>
                        </div>
                    </div>
                    @if ($pendingPayment)
                        <div class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 p-3 text-sm text-yellow-800">
                            Pending payment detected for this listing.
                            <a class="font-medium underline ml-1" href="{{ route('seller.checkout', ['payment' => $pendingPayment->id]) }}">Continue checkout</a>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $cards = [
                            ['label' => 'Views', 'value' => '1,284', 'icon' => 'ri-eye-line'],
                            ['label' => 'Inquiries', 'value' => '86', 'icon' => 'ri-question-answer-line'],
                            ['label' => 'Calls', 'value' => '34', 'icon' => 'ri-phone-line'],
                            ['label' => 'WhatsApp', 'value' => '22', 'icon' => 'ri-whatsapp-line'],
                            ['label' => 'Email', 'value' => '14', 'icon' => 'ri-mail-line'],
                            ['label' => 'Inspection Requests', 'value' => '9', 'icon' => 'ri-calendar-check-line'],
                            ['label' => 'Payments', 'value' => '4', 'icon' => 'ri-bank-card-line'],
                            ['label' => 'Promotions', 'value' => '2', 'icon' => 'ri-rocket-line'],
                        ];
                    @endphp
                    @foreach ($cards as $card)
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="{{ $card['icon'] }}"></i>{{ $card['label'] }}</div>
                            <div class="text-2xl font-semibold mt-2">{{ $card['value'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
