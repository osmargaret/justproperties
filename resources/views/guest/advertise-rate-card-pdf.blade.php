<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propatis Advertising Rate Card & Media Kit (PDF)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css" />
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900 min-h-screen py-10">

    <!-- Floating Print / Save PDF Controls -->
    <div class="no-print fixed top-6 right-6 z-50 flex items-center gap-3">
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-3 rounded-xl shadow-xl transition cursor-pointer">
            <i class="ri-printer-line text-lg"></i>
            <span>Print or Save as PDF</span>
        </button>
        <a href="{{ route('advertise') }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-700 font-semibold px-4 py-3 rounded-xl shadow border border-gray-200 transition">
            <i class="ri-arrow-left-line"></i> Back to Site
        </a>
    </div>

    <!-- PDF Document Container -->
    <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-200 p-8 sm:p-12 space-y-10">

        <!-- Document Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-8 gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <img src="{{ asset('frontend/images/logoo.png') }}" alt="Propatis Logo" class="h-10 w-auto">
                    <span class="text-xs font-extrabold uppercase tracking-widest px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full">Media Kit 2026/2027</span>
                </div>
                <h1 class="text-3xl font-extrabold font-serif text-gray-900">Advertising Rate Card & Media Kit</h1>
                <p class="text-sm text-gray-500 mt-1">Nigeria's Premier Direct Real Estate Marketplace</p>
            </div>
            <div class="text-left sm:text-right border-l sm:border-l-0 sm:border-r border-emerald-500 pl-4 sm:pl-0 sm:pr-4">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Official Document</p>
                <p class="text-sm font-bold text-emerald-700">Ref: PRO-ADS-2026</p>
                <p class="text-xs text-gray-500">Issued: August 2026</p>
            </div>
        </div>

        <!-- Audience Reach Summary -->
        <div>
            <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wider mb-4 text-emerald-800 flex items-center gap-2">
                <i class="ri-line-chart-line"></i> Platform Audience & Reach Metrics
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <p class="text-2xl font-black text-emerald-700">10,000+</p>
                    <p class="text-xs text-gray-600 font-medium">Monthly Active Visitors</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <p class="text-2xl font-black text-emerald-700">5,000+</p>
                    <p class="text-xs text-gray-600 font-medium">Verified Property Listings</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <p class="text-2xl font-black text-emerald-700">36</p>
                    <p class="text-xs text-gray-600 font-medium">States & FCT Coverage</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <p class="text-2xl font-black text-emerald-700">95%</p>
                    <p class="text-xs text-gray-600 font-medium">High-Intent Buyers & Investors</p>
                </div>
            </div>
        </div>

        <!-- Individual Ad Spot Rates (Per Week / Per 1,000 Emails) -->
        <div>
            <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wider mb-4 text-emerald-800 flex items-center gap-2">
                <i class="ri-layout-grid-line"></i> Individual Ad Spot Rates (Weekly & Email CPM)
            </h2>
            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="w-full text-left text-xs sm:text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-gray-700 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="p-3.5">Placement Spot</th>
                            <th class="p-3.5">Ad Format</th>
                            <th class="p-3.5">Dimensions</th>
                            <th class="p-3.5">Billing Basis</th>
                            <th class="p-3.5 text-right">Rate (NGN / USD)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr>
                            <td class="p-3.5 font-bold text-gray-900">1. Homepage Hero Banner</td>
                            <td class="p-3.5">Top Leaderboard</td>
                            <td class="p-3.5 font-mono text-xs">1200 x 300 px</td>
                            <td class="p-3.5"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">Per Week</span></td>
                            <td class="p-3.5 font-bold text-right text-emerald-700">₦35,000 <span class="text-gray-400 font-normal">($25)/wk</span></td>
                        </tr>
                        <tr>
                            <td class="p-3.5 font-bold text-gray-900">2. Catalog & Listing Pages</td>
                            <td class="p-3.5">Billboard Banner</td>
                            <td class="p-3.5 font-mono text-xs">970 x 250 px</td>
                            <td class="p-3.5"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">Per Week</span></td>
                            <td class="p-3.5 font-bold text-right text-emerald-700">₦25,000 <span class="text-gray-400 font-normal">($18)/wk</span></td>
                        </tr>
                        <tr>
                            <td class="p-3.5 font-bold text-gray-900">3. Property Details Page</td>
                            <td class="p-3.5">Sticky Sidebar & Calculator Ad</td>
                            <td class="p-3.5 font-mono text-xs">300 x 250 px</td>
                            <td class="p-3.5"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">Per Week</span></td>
                            <td class="p-3.5 font-bold text-right text-emerald-700">₦20,000 <span class="text-gray-400 font-normal">($15)/wk</span></td>
                        </tr>
                        <tr>
                            <td class="p-3.5 font-bold text-gray-900">4. Blog & Article Sidebar</td>
                            <td class="p-3.5">Skyscraper / In-Article</td>
                            <td class="p-3.5 font-mono text-xs">300 x 600 px</td>
                            <td class="p-3.5"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">Per Week</span></td>
                            <td class="p-3.5 font-bold text-right text-emerald-700">₦15,000 <span class="text-gray-400 font-normal">($10)/wk</span></td>
                        </tr>
                        <tr>
                            <td class="p-3.5 font-bold text-gray-900">5. Newsletter & Email</td>
                            <td class="p-3.5">Sponsored Email Header</td>
                            <td class="p-3.5 font-mono text-xs">600 x 200 px</td>
                            <td class="p-3.5"><span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-bold rounded">Per 1,000 Emails</span></td>
                            <td class="p-3.5 font-bold text-right text-emerald-700">₦30,000 <span class="text-gray-400 font-normal">($20)/1k</span></td>
                        </tr>
                        <tr>
                            <td class="p-3.5 font-bold text-gray-900">6. Partner Directory Listing</td>
                            <td class="p-3.5">Featured Directory Profile</td>
                            <td class="p-3.5 font-mono text-xs">Logo + 50 Words</td>
                            <td class="p-3.5"><span class="px-2 py-0.5 bg-purple-100 text-purple-800 text-[10px] font-bold rounded">Per Month</span></td>
                            <td class="p-3.5 font-bold text-right text-emerald-700">₦50,000 <span class="text-gray-400 font-normal">($35)/mo</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="page-break"></div> --}}

        <!-- Premium Bundle Packages -->
        <div>
            <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wider mb-4 text-emerald-800 flex items-center gap-2">
                <i class="ri-price-tag-3-line"></i> Premium Bundle Packages (Multi-Spot Savings)
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Starter Package -->
                <div class="border border-gray-200 rounded-2xl p-6 bg-white space-y-3 relative">
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full">Monthly Bundle</span>
                    <h3 class="font-extrabold text-gray-900 text-lg">Starter Package</h3>
                    <p class="text-2xl font-black text-emerald-600">₦150,000 <span class="text-xs font-normal text-gray-500">/ mo</span></p>
                    <ul class="text-xs space-y-2 text-gray-600 pt-2 border-t border-gray-100">
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> 1 Placement Area Spot</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> 50,000 Guaranteed Impressions</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> Monthly Analytics Report</li>
                    </ul>
                </div>

                <!-- Growth Package -->
                <div class="border-2 border-emerald-500 rounded-2xl p-6 bg-emerald-50/40 space-y-3 relative shadow-md">
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 bg-emerald-600 text-white rounded-full">Quarterly (Most Popular)</span>
                    <h3 class="font-extrabold text-gray-900 text-lg">Growth Package</h3>
                    <p class="text-2xl font-black text-emerald-600">₦380,000 <span class="text-xs font-normal text-gray-500">/ 3 mos</span></p>
                    <ul class="text-xs space-y-2 text-gray-700 pt-2 border-t border-emerald-200">
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> 2 Placement Area Spots</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> 180,000 Guaranteed Impressions</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> Priority Rotator & Custom CTA</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> Save 15% vs Monthly</li>
                    </ul>
                </div>

                <!-- Enterprise Partner -->
                <div class="border border-gray-200 rounded-2xl p-6 bg-white space-y-3 relative">
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full">Annual (Best Value)</span>
                    <h3 class="font-extrabold text-gray-900 text-lg">Enterprise Partner</h3>
                    <p class="text-2xl font-black text-emerald-600">₦1,200,000 <span class="text-xs font-normal text-gray-500">/ year</span></p>
                    <ul class="text-xs space-y-2 text-gray-600 pt-2 border-t border-gray-100">
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> All 6 Placement Spots Included</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> 750,000+ Impressions</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> Newsletter & Email Feature</li>
                        <li class="flex items-center gap-1.5"><i class="ri-check-line text-emerald-600 font-bold"></i> Save 33% Annual Discount</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Guidelines & Contact -->
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div class="space-y-1">
                <h4 class="font-bold text-gray-900 text-base">Ready to Book Your Campaign?</h4>
                <p class="text-xs text-gray-600">Contact our advertising team to lock in your placement dates and request custom packages.</p>
                <div class="pt-2 text-xs font-semibold text-emerald-700 flex flex-wrap gap-4">
                    <span><i class="ri-mail-line"></i> ads@propatis.com</span>
                    <span><i class="ri-phone-line"></i> +234 800 PROPATIS</span>
                    <span><i class="ri-global-line"></i> propatis.com/advertise</span>
                </div>
            </div>
            <button onclick="window.print()" class="no-print shrink-0 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl text-xs shadow transition">
                Print / Save PDF
            </button>
        </div>

        <!-- Document Footer -->
        <div class="text-center border-t border-gray-100 pt-6 text-[11px] text-gray-400">
            <p>© 2026 Propatis Real Estate Marketplace. All rights reserved. Rates subject to official confirmation upon booking.</p>
        </div>

    </div>

</body>
</html>
