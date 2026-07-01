@props(['promotion'])

@php
    $deliverable = $promotion->promotable;
    $usage = $promotion->usage ?? [];
@endphp

<div class="mt-4 rounded-lg bg-gray-50 border border-gray-100 p-4 text-sm">
    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Deliverable</p>
    @if (! $deliverable)
        <p class="text-gray-500">No deliverable linked yet.</p>
        @if ($promotion->status === 'pending_content')
            <p class="mt-2 text-xs text-amber-700">Our team will prepare content after payment. You will see the deliverable here once it is ready.</p>
        @endif
    @elseif ($deliverable instanceof \App\Models\FeaturedProperty)
        
        <div class="space-y-2">
            <p class="text-gray-600">
                Featured status: <span class="capitalize font-medium">{{ $deliverable->status }}</span>
            </p>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div>Views: <span class="font-medium">{{ number_format($deliverable->views_count) }}</span></div>
                <div>Clicks: <span class="font-medium">{{ number_format($deliverable->click_count) }}</span></div>
            </div>
            @if ($deliverable->target_type && $deliverable->target_count)
                <p class="text-xs text-gray-500">
                    Target: {{ number_format($deliverable->click_count + $deliverable->views_count) }} / {{ number_format($deliverable->target_count) }} {{ str_replace('_', ' ', $deliverable->target_type) }}
                </p>
            @endif
        </div>
        
    @elseif ($deliverable instanceof \App\Models\Post)
        
        <div class="space-y-1">
            <p class="font-medium text-gray-900">{{ $deliverable->title }}</p>
            <p class="text-gray-600">
               Status: <span class="capitalize">{{ $deliverable->status }}</span>
                @if ($deliverable->published_at)
                    · Published {{ $deliverable->published_at->format('M d, Y') }}
                @endif
            </p>
            @if ($deliverable->excerpt)
                <p class="text-gray-600 line-clamp-2">{{ $deliverable->excerpt }}</p>
            @endif
            @if (isset($usage['posts']))
                <p class="text-xs text-gray-500">Posts generated: {{ $usage['posts'] }}</p>
            @endif
            @if ($deliverable->status === 'published')
                <a href="{{ route('post') }}" target="_blank" rel="noopener" class="inline-flex text-xs font-medium text-emerald-700 hover:underline">
                    View on site
                </a>
            @endif
            <details class="mt-2 rounded border border-gray-200 bg-white p-2">
                <summary class="cursor-pointer text-xs font-medium text-emerald-700">Preview post</summary>
                <div class="mt-2 whitespace-pre-line text-xs text-gray-700">{{ $deliverable->content ?: 'No content yet.' }}</div>
            </details>
        </div>
    @elseif ($deliverable instanceof \App\Models\Newsletter)
        @php
            $recipientStats = $deliverable->recipients()
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');
        @endphp
        <div class="space-y-1">
            <p class="font-medium text-gray-900">{{ $deliverable->title }}</p>
            @if ($deliverable->subject)
                <p class="text-gray-600">Subject: {{ $deliverable->subject }}</p>
            @endif
            <p class="text-gray-600">
                Status: <span class="capitalize">{{ $deliverable->status }}</span>
                @if ($deliverable->sent_at)
                    · Sent {{ $deliverable->sent_at->format('M d, Y') }}
                @endif
            </p>
            @if (isset($usage['emails']))
                <p class="text-xs text-gray-500">Emails sent: {{ $usage['emails'] }}</p>
            @endif
            @if ($recipientStats->isNotEmpty())
                <p class="text-xs text-gray-500">
                    Recipients:
                    {{ number_format($recipientStats->sum()) }} queued
                    @if ($recipientStats->has('sent'))
                        · {{ number_format($recipientStats->get('sent')) }} sent
                    @endif
                    @if ($recipientStats->has('opened'))
                        · {{ number_format($recipientStats->get('opened')) }} opened
                    @endif
                </p>
            @endif
            <button
                type="button"
                wire:click="showNewsletterPreview({{ $deliverable->id }})"
                class="mt-2 text-xs font-medium text-emerald-700 hover:underline"
            >
                Preview email
            </button>
        </div>
    
    @else
        <p class="text-gray-500">{{ class_basename($deliverable) }} #{{ $deliverable->id }}</p>
    @endif
</div>
