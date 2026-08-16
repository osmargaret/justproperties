<div class="min-h-screen bg-gradient-to-br from-slate-50 to-emerald-50/30" data-navbar="solid">

    {{-- Page Header --}}
    <div class="pt-28 pb-12 text-center px-4">
        <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-semibold tracking-widest uppercase px-4 py-1.5 rounded-full mb-4">
            Subscription Plans
        </span>
        <h1 class="font-serif text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Choose Your Perfect Plan</h1>
        <p class="text-lg text-gray-500 max-w-xl mx-auto">
            Select a subscription that fits your needs. All plans include access to our property listing platform.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 pb-20">
        @if (session()->has('error'))
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 max-w-xl mx-auto text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- Country Switcher + Billing Toggle --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
            {{-- Country Switcher --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 font-medium">Pricing for:</span>
                <div class="relative">
                    <select
                        wire:change="switchCountry($event.target.value)"
                        class="appearance-none bg-white border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-sm font-medium text-gray-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-sm"
                    >
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $country->id == $selectedCountryId ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    <i class="ri-arrow-down-s-line absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            {{-- Divider --}}
            <span class="hidden sm:block text-gray-300">|</span>

            {{-- Billing toggle --}}
            <div class="flex items-center gap-3">
                <button
                    wire:click="setBillingCycle('monthly')"
                    class="text-sm font-medium px-4 py-2 rounded-lg transition-all {{ $billingCycle === 'monthly' ? 'bg-emerald-600 text-white shadow' : 'text-gray-500 hover:text-gray-700' }}"
                >
                    Monthly
                </button>
                <button
                    wire:click="setBillingCycle('yearly')"
                    class="text-sm font-medium px-4 py-2 rounded-lg transition-all flex items-center gap-2 {{ $billingCycle === 'yearly' ? 'bg-emerald-600 text-white shadow' : 'text-gray-500 hover:text-gray-700' }}"
                >
                    Yearly
                    <span class="text-xs {{ $billingCycle === 'yearly' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700' }} px-2 py-0.5 rounded-full font-semibold">
                        Save 30%
                    </span>
                </button>
            </div>
        </div>

        {{-- Plans Grid --}}
        @if($plans->isEmpty())
            <div class="text-center py-20 text-gray-400">
                <i class="ri-price-tag-3-line text-5xl mb-4 block"></i>
                <p class="text-lg">No plans available yet. Please check back soon.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min(4, $plans->count()) }} gap-6 mb-14">
                @foreach($plans as $plan)
                    @php
                        $price = $plan->prices->first();
                        $currency = $price?->currency;
                        $monthlyAmount = $price ? (float) $price->amount : null;
                        $yearlyAmount = $monthlyAmount ? round($monthlyAmount * 12 * 0.70) : null; // 30% off
                        $displayAmount = $billingCycle === 'yearly' ? $yearlyAmount : $monthlyAmount;
                        $isPopular = $loop->iteration === 3;
                        $currencySymbol = $currency?->symbol ?? '$';
                    @endphp

                    <div class="relative bg-white rounded-2xl p-6 shadow-md border-2 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl
                        {{ $isPopular ? 'border-emerald-500 scale-105 z-10' : 'border-transparent' }}"
                    >
                        @if($isPopular)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-xs font-bold tracking-wider uppercase px-5 py-1 rounded-full whitespace-nowrap">
                                Most Popular
                            </div>
                        @endif

                        {{-- Plan Header --}}
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-3
                                {{ $isPopular ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-600' }}">
                                <i class="ri-vip-crown-line text-2xl"></i>
                            </div>
                            <h2 class="font-serif text-xl font-bold text-gray-900">{{ $plan->name }}</h2>

                            @if($displayAmount !== null)
                                <div class="mt-3">
                                    <span class="text-4xl font-bold text-emerald-600">
                                        {{ $currencySymbol }}{{ number_format($displayAmount) }}
                                    </span>
                                    <span class="text-gray-400 text-sm">
                                        /{{ $billingCycle === 'yearly' ? 'year' : 'month' }}
                                    </span>
                                </div>
                                @if($billingCycle === 'yearly' && $monthlyAmount)
                                    <p class="text-xs text-emerald-600 font-semibold mt-1">
                                        Save {{ $currencySymbol }}{{ number_format($monthlyAmount * 12 - $yearlyAmount) }}/year
                                    </p>
                                @endif
                            @else
                                <div class="mt-3">
                                    <span class="text-3xl font-bold text-gray-400">No price set</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Contact us for pricing in your region</p>
                            @endif
                        </div>

                        {{-- Features --}}
                        <ul class="space-y-3 mb-6">
                            @if($plan->features && count($plan->features) > 0)
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                        <i class="ri-check-line text-emerald-500 mt-0.5 shrink-0 text-base"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="flex items-center gap-2.5 text-sm text-gray-400">
                                    <i class="ri-information-line shrink-0"></i>
                                    <span>Features coming soon</span>
                                </li>
                            @endif

                            @if($plan->seats)
                                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                                    <i class="ri-home-4-line text-emerald-500 shrink-0"></i>
                                    <span><strong>{{ $plan->seats }}</strong> property listing{{ $plan->seats > 1 ? 's' : '' }}</span>
                                </li>
                            @endif

                            @if($plan->days)
                                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                                    <i class="ri-calendar-check-line text-emerald-500 shrink-0"></i>
                                    <span>Listings active for <strong>{{ $plan->days }} days</strong></span>
                                </li>
                            @endif
                        </ul>

                        {{-- CTA Button --}}
                        @auth
                                    <button wire:click="selectPlan({{ $plan->id }})"
                                       class="block w-full text-center py-3 rounded-xl font-semibold text-sm transition-all duration-200
                                           {{ $isPopular
                            ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-200'
                            : 'border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white' }}"
                                    >
                                        Get {{ $plan->name }}
                                    </button>
                        @else
                                    <a href="{{ route('login') }}"
                                       class="block w-full text-center py-3 rounded-xl font-semibold text-sm transition-all duration-200
                                           {{ $isPopular
                            ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-200'
                            : 'border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white' }}"
                                    >
                                        Get Started
                                    </a>
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Feature Comparison Table --}}
        <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8 mb-12">
            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6">Compare All Features</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 pr-4 font-semibold text-gray-600 w-1/3">Feature</th>
                            @foreach($plans as $plan)
                                <th class="py-3 px-2 font-semibold text-gray-700 text-center">{{ $plan->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr>
                            <td class="py-3 pr-4 text-gray-600 font-medium">Property Listings</td>
                            @foreach($plans as $plan)
                                <td class="py-3 px-2 text-center font-semibold text-gray-800">
                                    {{ $plan->seats ?? '—' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-gray-600 font-medium">Listing Duration</td>
                            @foreach($plans as $plan)
                                <td class="py-3 px-2 text-center text-gray-700">
                                    {{ $plan->days ? $plan->days . ' days' : '—' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-gray-600 font-medium">Email Support</td>
                            @foreach($plans as $plan)
                                <td class="py-3 px-2 text-center">
                                    <i class="ri-check-line text-emerald-500 text-lg"></i>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-gray-600 font-medium">WhatsApp Support</td>
                            @foreach($plans as $planItem)
                                @php $isPaid = $planItem->prices->isNotEmpty() && (float) $planItem->prices->first()?->amount > 0; @endphp
                                <td class="py-3 px-2 text-center">
                                    @if($isPaid)
                                        <i class="ri-check-line text-emerald-500 text-lg"></i>
                                    @else
                                        <i class="ri-close-line text-gray-300 text-lg"></i>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-gray-600 font-medium">Featured Listing Boost</td>
                            @foreach($plans as $planItem)
                                @php $isHighTier = $loop->iteration >= 3; @endphp
                                <td class="py-3 px-2 text-center">
                                    @if($isHighTier)
                                        <i class="ri-check-line text-emerald-500 text-lg"></i>
                                    @else
                                        <i class="ri-close-line text-gray-300 text-lg"></i>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FAQ Section --}}
        <div class="mb-12">
            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6 text-center">Frequently Asked Questions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $pricingFaqs = [
                        ['q' => 'Can I switch plans anytime?', 'a' => 'Yes, you can upgrade or downgrade your plan at any time. Changes take effect on your next billing cycle.'],
                        ['q' => 'What payment methods do you accept?', 'a' => 'We accept bank transfers and other local payment options. Details are provided at checkout based on your country.'],
                        ['q' => 'Is there a refund policy?', 'a' => 'We offer a 14-day money-back guarantee if you\'re not satisfied with our service.'],
                        ['q' => 'What happens to my listings if I cancel?', 'a' => 'Your listings remain active until the end of your billing period. You can renew at any time.'],
                    ];
                @endphp
                @foreach($pricingFaqs as $faq)
                    <div
                        x-data="{ open: false }"
                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 cursor-pointer select-none"
                        @click="open = !open"
                    >
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="font-semibold text-gray-800 text-sm">{{ $faq['q'] }}</h3>
                            <i class="ri-arrow-down-s-line text-gray-400 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </div>
                        <p x-show="open" x-collapse class="mt-3 text-sm text-gray-500 leading-relaxed">
                            {{ $faq['a'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CTA Banner --}}
        <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-8 text-center text-white shadow-xl">
            <h2 class="font-serif text-2xl sm:text-3xl font-bold mb-2">Ready to get started?</h2>
            <p class="text-emerald-100 mb-6 max-w-md mx-auto">
                Join thousands of property owners already listing on Propatis.
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-block bg-white text-emerald-700 font-semibold px-8 py-3 rounded-xl hover:bg-emerald-50 transition shadow-md">
                    Create Free Account
                </a>
            @else
                <a href="{{ route('list-property') }}" class="inline-block bg-white text-emerald-700 font-semibold px-8 py-3 rounded-xl hover:bg-emerald-50 transition shadow-md">
                    List Your Property
                </a>
            @endguest
        </div>

    </div>

    @livewire('guest.footer')

</div>