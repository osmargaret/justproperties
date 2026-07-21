<div>
  <!-- Article Header -->
  <header class="text-white pt-32 pb-16 bg-gradient-to-br from-emerald-900 to-emerald-600">
    <div class="max-w-4xl mx-auto px-4">
      <span class="inline-block bg-white/20 text-white px-4 py-1 rounded-full text-sm font-semibold mb-6">
        {{ $post->category?->name ?? 'Blog' }}
      </span>

      <h1 class="font-bold font-serif mb-6 text-6xl leading-tight">{{ $post->title }}</h1>

      <div class="flex flex-wrap gap-8 mb-6 text-emerald-100 text-base">
        <span><i class="ri-calendar-line"></i> {{ $post->published_at?->format('F j, Y') ?? 'Unpublished' }}</span>
        <span><i class="ri-time-line"></i> {{ $readingTime }} min read</span>
        <span><i class="ri-user-line"></i> {{ $post->user?->name ?? 'Admin' }}</span>
      </div>

      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-white/10 text-white grid place-items-center font-semibold text-xl">
          {{ strtoupper(substr($post->user?->name ?? 'A', 0, 1)) }}
        </div>
        <div>
          <h4 class="font-semibold text-base">{{ $post->user?->name ?? 'Admin' }}</h4>
          <p class="text-sm text-emerald-100">{{ $post->category?->name ?? 'Blog' }} • {{ $readingTime }} min read</p>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 py-12">
    <div class="md:flex lg:grid-cols-3 gap-12">
      <!-- Article Body -->
      <div class="lg:col-span-2 lg:grow">
        <div class="bg-white rounded-2xl p-8 shadow">
          @if($post->media->first())
            <img src="{{ $post->media->first()->url }}" alt="{{ $post->title }}" class="w-full rounded-xl object-cover mb-8 h-[400px]" />
          @endif

          @if($post->excerpt)
            <p class="text-gray-500 mb-6 leading-loose">{{ $post->excerpt }}</p>
          @endif

          <div class="prose prose-lg max-w-none text-gray-700 mb-12">
            {!! $post->content !!}
          </div>

          @php $postTagsList = $post->tags ? array_filter(array_map('trim', explode(',', $post->tags))) : []; @endphp
          <div class="flex flex-wrap gap-2 py-6 border-t border-b border-gray-200 mb-6">
            @foreach($postTagsList as $tag)
              <a href="{{ route('blog', ['tag' => $tag]) }}" class="bg-gray-100 text-gray-700 px-4 py-1 rounded-full text-xs font-medium hover:bg-emerald-600 hover:text-white transition">#{{ $tag }}</a>
            @endforeach
          </div>

          <div class="flex items-center gap-4 mb-8">
            <span class="font-medium text-gray-700 text-base">Share this article:</span>
            <div class="flex gap-2">
              <button class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:-translate-y-1 transition"><i class="ri-twitter-x-line"></i></button>
              <button class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:-translate-y-1 transition"><i class="ri-facebook-fill"></i></button>
              <button class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:-translate-y-1 transition"><i class="ri-linkedin-fill"></i></button>
              <button class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:-translate-y-1 transition"><i class="ri-whatsapp-line"></i></button>
            </div>
          </div>

          <div class="flex gap-6 bg-gray-50 rounded-xl p-6 mb-8">
            <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-900 grid place-items-center font-semibold text-xl">{{ strtoupper(substr($post->user?->name ?? 'A', 0, 1)) }}</div>
            <div>
              <h3 class="font-bold text-gray-900 mb-2 text-xl">About {{ $post->user?->name ?? 'Admin' }}</h3>
              <p class="text-gray-500 text-[0.95rem] leading-relaxed">{{ $post->user?->name ?? 'This author' }} shares regular insights from the real estate market and the latest property trends.</p>
            </div>
          </div>

          <div class="mt-12">
            <h3 class="font-bold font-serif text-gray-900 mb-6 text-2xl">Comments ({{ $this->comments->count() }})</h3>

            @if($statusMessage)
              <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                {{ $statusMessage }}
              </div>
            @endif

            @if($this->comments->isEmpty())
              <p class="text-gray-500 mb-8">Be the first to leave a comment.</p>
            @else
              @foreach($this->comments as $comment)
                <div class="flex gap-4 mb-8">
                  <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-900 grid place-items-center font-semibold text-base">{{ strtoupper(substr($comment->name, 0, 1)) }}</div>
                  <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-4 mb-2 text-sm text-gray-400">
                      <span class="font-semibold text-gray-900">{{ $comment->name }}</span>
                      <span>{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-500 mb-2 text-base">{{ $comment->comment }}</p>
                  </div>
                </div>
              @endforeach
            @endif

            <div class="bg-gray-50 rounded-xl p-8 mt-8">
              <h3 class="font-bold font-serif text-gray-900 mb-6 text-xl">Leave a Comment</h3>
              <form wire:submit.prevent="submitComment" class="space-y-4">
                <div>
                  <input wire:model.defer="commentName" type="text" placeholder="Your Name" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 text-base" />
                  @error('commentName') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                  <input wire:model.defer="commentEmail" type="email" placeholder="Your Email" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 text-base" />
                  @error('commentEmail') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                  <textarea wire:model.defer="commentContent" placeholder="Your Comment" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 resize-none min-h-[120px] text-base"></textarea>
                  @error('commentContent') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" wire:loading.attr="disabled" class="px-8 py-3 text-white font-semibold rounded-lg transition hover:-translate-y-1 bg-emerald-600 hover:bg-emerald-700">Post Comment</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <aside class="lg:col-span-1 lg:max-w-[300px] lg:shrink-0">
        <div class="flex flex-col gap-8">
          <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-gray-900 mb-4 pb-3 border-b-2 border-gray-100 text-lg">Related Articles</h3>
            <div class="flex flex-col gap-4">
              @forelse($relatedPosts as $related)
                <a href="{{ route('post', $related) }}" class="flex gap-3 hover:bg-gray-50 rounded-lg p-2 transition">
                  @if($related->media->first())
                    <img src="{{ $related->media->first()->url }}" alt="{{ $related->title }}" class="w-20 h-20 rounded-lg object-cover" />
                  @else
                    <div class="w-20 h-20 rounded-lg bg-gray-100"></div>
                  @endif
                  <div>
                    <h4 class="font-semibold text-gray-900 mb-1 text-base leading-snug">{{ $related->title }}</h4>
                    <p class="text-gray-500 text-xs">{{ $related->published_at?->format('M d, Y') }}</p>
                  </div>
                </a>
              @empty
                <p class="text-gray-500">No related posts available yet.</p>
              @endforelse
            </div>
          </div>

          <div class="bg-white rounded-xl p-6 shadow text-white bg-gradient-to-br from-emerald-900 to-emerald-600">
            <h3 class="font-bold mb-4 pb-3 border-b border-white/20 text-lg">Get Market Updates</h3>
            <p class="mb-4 text-base text-emerald-100">Subscribe to our newsletter and receive the latest post updates for this category.</p>
            <form wire:submit.prevent="subscribe" class="space-y-4">
              <div>
                <input wire:model.defer="subscriptionEmail" type="email" placeholder="Your email address" required class="w-full px-4 py-3 rounded-lg border-none outline-none mb-1 text-base" />
                @error('subscriptionEmail') <span class="text-red-200 text-sm">{{ $message }}</span> @enderror
              </div>
              <button type="submit" wire:loading.attr="disabled" class="w-full py-3 rounded-lg font-semibold transition hover:-translate-y-1 bg-white text-emerald-600">Subscribe</button>
            </form>
          </div>

          <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-gray-900 mb-4 pb-3 border-b-2 border-gray-100 text-lg">Popular Tags</h3>
            <div class="flex flex-wrap gap-2">
              @foreach($postTagsList ?? [] as $tag)
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium hover:bg-emerald-600 hover:text-white transition">{{ $tag }}</span>
              @endforeach
            </div>
          </div>
        </div>
      </aside>
    </div>
  </main>
</div>
