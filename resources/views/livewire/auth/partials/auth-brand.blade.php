@props([
    'title',
    'description',
])
<div class="brand-panel">
    <div class="brand-content">
        <div class="logo">
            <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png" alt="JustProperties">
            <span>JustProperties</span>
        </div>

        <div class="brand-text">
            <h1>{{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <ul class="features">
            <li>
                <i class="ri-check-line"></i>
                <span>Direct contact with verified property owners</span>
            </li>
            <li>
                <i class="ri-check-line"></i>
                <span>No agent fees or hidden charges</span>
            </li>
            <li>
                <i class="ri-check-line"></i>
                <span>500+ active listings across Lagos</span>
            </li>
            <li>
                <i class="ri-check-line"></i>
                <span>24/7 customer support</span>
            </li>
        </ul>
    </div>
</div>
