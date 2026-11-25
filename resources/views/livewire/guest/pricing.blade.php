<div class="min-h-screen bg-gradient-to-br from-slate-50 to-emerald-50/30" data-navbar="solid">
    <header class="px-4 pb-12 pt-28 text-center">
        <span class="mb-4 inline-block rounded-full bg-emerald-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-emerald-700">
            Promotion plans
        </span>
        <h1 class="mb-4 font-serif text-4xl font-bold text-gray-900 sm:text-5xl">Promote your property</h1>
        <p class="mx-auto max-w-xl text-lg text-gray-500">
            Property listings are free. Choose a promotion after listing to increase your reach.
        </p>
    </header>

    <main class="mx-auto max-w-7xl px-4 pb-20">
        <div class="mb-10 flex justify-center">
            <label class="flex items-center gap-3 text-sm font-medium text-gray-600">
                Pricing for
                <select wire:model.live="selectedCountryId" class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700">
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        @if ($plans->isEmpty())
            <div class="py-20 text-center text-gray-500">No promotion plans are available yet.</div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    @php
                        $price = $priceQuotes[$plan->id] ?? null;
                        $targetDetails = $plan->targetsForDisplay();
                    @endphp
                    <article class="rounded-2xl border border-gray-100 bg-white p-6 shadow-md">
                        <div class="mb-5">
                            <h2 class="font-serif text-xl font-bold text-gray-900">{{ $plan->name }}</h2>
                            <p class="mt-1 text-sm capitalize text-gray-500">{{ str_replace('_', ' ', $plan->type) }}</p>
                            @if ($price)
                                <p class="mt-4 text-3xl font-bold text-emerald-600">
                                    {{ $price['currency_symbol'] ?? '' }}{{ number_format((float) $price['amount'], 2) }}
                                    <span class="text-sm">{{ $price['currency_code'] }}</span>
                                </p>
                            @else
                                <p class="mt-4 text-sm text-gray-500">Contact us for pricing in your region.</p>
                            @endif
                        </div>

                        @if ($targetDetails !== [])
                            <ul class="mb-6 space-y-2 border-t border-gray-100 pt-4 text-sm text-gray-600">
                                @foreach ($targetDetails as $target)
                                    <li>{{ number_format($target['count']) }} {{ $target['type'] }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @auth
                            <a href="{{ route('account.promotions') }}" class="block rounded-xl bg-emerald-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-emerald-700">
                                View promotions
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="block rounded-xl bg-emerald-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-emerald-700">
                                Create free account
                            </a>
                        @endauth
                    </article>
                @endforeach
            </div>
        @endif

        <div class="mt-12 rounded-2xl bg-emerald-700 p-8 text-center text-white">
            <h2 class="mb-2 font-serif text-2xl font-bold">Start with a free listing</h2>
            <p class="mb-6 text-emerald-100">Create your listing first, then select a promotion whenever you are ready.</p>
            @auth
                <a href="{{ route('list-property') }}" class="inline-block rounded-xl bg-white px-8 py-3 font-semibold text-emerald-700 hover:bg-emerald-50">List your property</a>
            @else
                <a href="{{ route('register') }}" class="inline-block rounded-xl bg-white px-8 py-3 font-semibold text-emerald-700 hover:bg-emerald-50">Create free account</a>
            @endauth
        </div>
    </main>

    @livewire('guest.footer')
</div>
