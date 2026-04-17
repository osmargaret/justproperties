<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - JustProperties Analytics</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #111827;
            line-height: 1.5;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-brand img {
            height: 40px;
            width: auto;
        }

        .nav-brand h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f3f4f6;
            border-radius: 2rem;
            cursor: pointer;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Main Content */
        .main-content {
            max-width: 1280px;
            margin: 90px auto 2rem;
            padding: 0 1rem;
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 2rem;
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
        }

        .profile-avatar {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            font-weight: 700;
            color: #059669;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .avatar-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 28px;
            height: 28px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #059669;
            cursor: pointer;
            border: 2px solid #059669;
            transition: all 0.3s ease;
        }

        .avatar-edit:hover {
            background: #059669;
            color: white;
        }

        .profile-info h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .profile-meta {
            display: flex;
            gap: 1.5rem;
            color: #d1fae5;
            font-size: 0.875rem;
        }

        .profile-meta i {
            margin-right: 0.25rem;
        }

        .header-details {
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .detail-item {
            text-align: center;
        }

        .detail-label {
            color: #d1fae5;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .action-btn-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .action-btn-header:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .action-btn-header.upgrade {
            background: white;
            color: #059669;
            border-color: white;
        }

        .action-btn-header.upgrade:hover {
            background: #f0fdf4;
        }

        @media (max-width: 1024px) {
            .profile-header {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .profile-avatar {
                margin: 0 auto;
            }

            .header-details {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1.5rem;
                width: 100%;
            }
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 1024px) {
            .charts-grid {
                grid-template-columns: 2fr 1fr;
            }
        }

        @media (max-width: 1024px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .chart-title {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .chart-actions {
            display: flex;
            gap: 0.5rem;
        }

        .chart-btn {
            padding: 0.25rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chart-btn:hover,
        .chart-btn.active {
            background: #059669;
            color: white;
            border-color: #059669;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .promo-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 640px) {
            .promo-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .promo-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .promo-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .promo-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
        }

        .promo-card.featured {
            border-color: #fbbf24;
        }

        .promo-card.urgent {
            border-color: #ef4444;
        }

        .promo-card.social {
            border-color: #3b82f6;
        }

        .promo-card.whatsapp {
            border-color: #25D366;
        }

        .promo-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .promo-name {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .promo-name i {
            font-size: 1.25rem;
        }

        .promo-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            background: #f3f4f6;
        }

        .promo-stats {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .promo-stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.875rem;
        }

        .promo-stat .label {
            color: #6b7280;
        }

        .promo-stat .value {
            font-weight: 600;
        }

        .promo-progress {
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
            margin: 0.5rem 0;
        }

        .promo-progress-bar {
            height: 100%;
            background: #059669;
            border-radius: 3px;
        }

        /* Listing Performance Table */
        .performance-section {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .view-all {
            color: #059669;
            cursor: pointer;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .performance-table {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem 0.5rem;
            color: #6b7280;
            font-weight: 500;
            font-size: 0.875rem;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 1rem 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
        }

        .property-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .property-thumb {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            object-fit: cover;
        }

        .property-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .property-type {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .trend-up {
            color: #059669;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .trend-down {
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background: #dcfce7;
            color: #059669;
        }

        .status-pending {
            background: #fef9c3;
            color: #854d0e;
        }

        /* Insights Cards */
        .insights-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 640px) {
            .insights-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .insights-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .insights-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .insight-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .insight-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .insight-icon {
            width: 40px;
            height: 40px;
            background: #f0fdf4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #059669;
        }

        .insight-title {
            font-weight: 600;
        }

        .insight-desc {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .insight-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-top: 0.5rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: #059669;
            color: white;
            border-color: #059669;
        }

        .action-btn i {
            font-size: 1.125rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .performance-table {
                font-size: 0.75rem;
            }

            .property-thumb {
                width: 30px;
                height: 30px;
            }
        }

        /* Dashboard Grid Layout */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 1024px) {
            .profile-grid {
                grid-template-columns: 300px 1fr;
            }
        }

        /* Sidebar Styles */
        .profile-sidebar {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 90px;
            grid-column: 1;
        }

        .dashboard-main {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .menu-item:hover {
            background: #f0fdf4;
        }

        .menu-item.active {
            background: #f0fdf4;
            border-left-color: #059669;
            color: #059669;
        }

        .menu-item i {
            font-size: 1.25rem;
            color: #6b7280;
        }

        .menu-item.active i {
            color: #059669;
        }

        .menu-item span {
            flex: 1;
        }

        .menu-item .badge {
            background: #ef4444;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
        }

        .menu-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 1rem 0;
        }

        .sidebar-section-label {
            padding: 0.75rem 1.5rem 0.25rem;
            font-size: 0.6875rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #9ca3af;
        }

        a.menu-item {
            color: inherit;
            text-decoration: none;
        }

        .sidebar-logout-form {
            margin: 0;
        }

        .menu-item--logout {
            width: 100%;
            border: none;
            background: none;
            font: inherit;
            text-align: left;
        }

        .main-content {
            max-width: 1280px;
            margin: 90px auto 2rem;
            padding: 0 1rem;
        }

        @media (max-width: 1024px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-sidebar {
                position: static;
                grid-column: auto;
                grid-row: auto;
            }

            .charts-grid,
            .promo-grid,
            .performance-section,
            .insights-grid {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.html" class="nav-brand">
                <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png"
                    alt="JustProperties" />
                <h1>JustProperties</h1>
            </a>

            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">JD</div>
                    <span class="user-name">John Doe</span>
                </div>
            </div>
        </div>
    </nav>



    <!-- Main Content -->
    <main class="main-content">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <span>JD</span>
                <div class="avatar-edit" onclick="alert('Change profile picture (Demo)')">
                    <i class="ri-camera-line"></i>
                </div>
            </div>
            <div class="profile-info">
                <h1>John Doe</h1>
                <div class="profile-meta">
                    <span><i class="ri-shield-check-line"></i> Verified Owner</span>
                    <span><i class="ri-star-line"></i> Professional Plan</span>
                </div>
                <p style="color: #d1fae5; margin-top: 0.5rem; font-size: 0.875rem;">Active until December 31, 2026 • 3 listings remaining this month</p>
            </div>
            <div class="header-details">
                <div class="detail-item">
                    <div class="detail-label">Listings Used</div>
                    <div class="detail-value">3/5</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Next Billing</div>
                    <div class="detail-value">Apr 15</div>
                </div>
                <div class="header-actions">
                    <button class="action-btn-header" onclick="alert('Renew subscription (Demo)')">
                        <i class="ri-refresh-line"></i>
                        Renew
                    </button>
                    <button class="action-btn-header upgrade" onclick="alert('Upgrade plan (Demo)')">
                        <i class="ri-arrow-up-line"></i>
                        Upgrade
                    </button>
                </div>
            </div>
        </div>

        <div class="profile-grid">
            <!-- Sidebar Menu -->
            @include('dashboard.sidebar', ['embeddedInProfile' => false])

            <div class="dashboard-main">
                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 items-start">
                  <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 self-start">
                      <div class="flex items-center justify-between mb-4">
                          <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                              <i class="ri-home-4-line text-green-600 text-xl"></i>
                          </div>
                          <div class="flex items-center gap-1 text-sm px-2 py-1 rounded-lg bg-green-50 text-green-600">
                              <i class="ri-arrow-up-line"></i>
                              +12%
                          </div>
                      </div>
                      <div class="text-2xl font-bold text-gray-900 mb-1">12</div>
                      <div class="text-gray-600 text-sm">Total Listings</div>
                  </div>

                  <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                      <div class="flex items-center justify-between mb-4">
                          <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                              <i class="ri-eye-line text-green-600 text-xl"></i>
                          </div>
                          <div class="flex items-center gap-1 text-sm px-2 py-1 rounded-lg bg-green-50 text-green-600">
                              <i class="ri-arrow-up-line"></i>
                              +28%
                          </div>
                      </div>
                      <div class="text-2xl font-bold text-gray-900 mb-1">1,247</div>
                      <div class="text-gray-600 text-sm">Total Views</div>
                  </div>

                  <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                      <div class="flex items-center justify-between mb-4">
                          <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                              <i class="ri-message-3-line text-green-600 text-xl"></i>
                          </div>
                          <div class="flex items-center gap-1 text-sm px-2 py-1 rounded-lg bg-green-50 text-green-600">
                              <i class="ri-arrow-up-line"></i>
                              +8%
                          </div>
                      </div>
                      <div class="text-2xl font-bold text-gray-900 mb-1">23</div>
                      <div class="text-gray-600 text-sm">Inquiries</div>
                  </div>

                  <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                      <div class="flex items-center justify-between mb-4">
                          <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                              <i class="ri-heart-line text-green-600 text-xl"></i>
                          </div>
                          <div class="flex items-center gap-1 text-sm px-2 py-1 rounded-lg bg-red-50 text-red-600">
                              <i class="ri-arrow-down-line"></i>
                              -3%
                          </div>
                      </div>
                      <div class="text-2xl font-bold text-gray-900 mb-1">156</div>
                      <div class="text-gray-600 text-sm">Favorites</div>
                  </div>
                </div>

                <!-- Charts Grid -->
                <div class="charts-grid">
                    <!-- Views Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3 class="chart-title">Property Views Overview</h3>
                            <div class="chart-actions">
                                <button class="chart-btn active" onclick="changeChartPeriod('week')">Week</button>
                                <button class="chart-btn" onclick="changeChartPeriod('month')">Month</button>
                                <button class="chart-btn" onclick="changeChartPeriod('year')">Year</button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>

                    <!-- Device Breakdown -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3 class="chart-title">Traffic Source</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="deviceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Promotional Analytics -->
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Promotional Performance</h2>

                <div class="promo-grid">
                    <!-- Featured Listing -->
                    <div class="promo-card featured">
                        <div class="promo-header">
                            <div class="promo-name">
                                <i class="ri-star-line" style="color: #fbbf24;"></i>
                                <span>Featured Listing</span>
                            </div>
                            <span class="promo-badge">Active</span>
                        </div>
                        <div class="promo-stats">
                            <div class="promo-stat">
                                <span class="label">Views this month</span>
                                <span class="value">847</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Inquiries</span>
                                <span class="value">12</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Conversion Rate</span>
                                <span class="value">1.4%</span>
                            </div>
                            <div class="promo-progress">
                                <div class="promo-progress-bar" style="width: 75%;"></div>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Budget spent</span>
                                <span class="value">₦2,250 / ₦3,000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Urgent Sale -->
                    <div class="promo-card urgent">
                        <div class="promo-header">
                            <div class="promo-name">
                                <i class="ri-flashlight-line" style="color: #ef4444;"></i>
                                <span>Urgent Sale</span>
                            </div>
                            <span class="promo-badge">Active</span>
                        </div>
                        <div class="promo-stats">
                            <div class="promo-stat">
                                <span class="label">Views this month</span>
                                <span class="value">523</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Inquiries</span>
                                <span class="value">8</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Conversion Rate</span>
                                <span class="value">1.5%</span>
                            </div>
                            <div class="promo-progress">
                                <div class="promo-progress-bar" style="width: 45%;"></div>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Budget spent</span>
                                <span class="value">₦900 / ₦2,000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Boost -->
                    <div class="promo-card social">
                        <div class="promo-header">
                            <div class="promo-name">
                                <i class="ri-share-line" style="color: #3b82f6;"></i>
                                <span>Social Media</span>
                            </div>
                            <span class="promo-badge">Active</span>
                        </div>
                        <div class="promo-stats">
                            <div class="promo-stat">
                                <span class="label">Reach</span>
                                <span class="value">2,847</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Engagement</span>
                                <span class="value">156</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Click-through</span>
                                <span class="value">2.3%</span>
                            </div>
                            <div class="promo-progress">
                                <div class="promo-progress-bar" style="width: 60%;"></div>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Budget spent</span>
                                <span class="value">₦3,000 / ₦5,000</span>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Broadcast -->
                    <div class="promo-card whatsapp">
                        <div class="promo-header">
                            <div class="promo-name">
                                <i class="ri-whatsapp-line" style="color: #25D366;"></i>
                                <span>WhatsApp</span>
                            </div>
                            <span class="promo-badge">Completed</span>
                        </div>
                        <div class="promo-stats">
                            <div class="promo-stat">
                                <span class="label">Broadcasts sent</span>
                                <span class="value">1,000</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Responses</span>
                                <span class="value">45</span>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Response rate</span>
                                <span class="value">4.5%</span>
                            </div>
                            <div class="promo-progress">
                                <div class="promo-progress-bar" style="width: 100%;"></div>
                            </div>
                            <div class="promo-stat">
                                <span class="label">Total spent</span>
                                <span class="value">₦4,000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listing Performance Table -->
                <div class="performance-section">
                    <div class="section-header">
                        <h3>Top Performing Listings</h3>
                        <span class="view-all" onclick="alert('View all listings (Demo)')">
                            View All <i class="ri-arrow-right-line"></i>
                        </span>
                    </div>

                    <div class="performance-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Inquiries</th>
                                    <th>Favorites</th>
                                    <th>Trend</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="property-info">
                                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=100&h=100&fit=crop"
                                                class="property-thumb" />
                                            <div>
                                                <div class="property-name">Luxury 5 Bedroom Duplex</div>
                                                <div class="property-type">Landed • Lekki</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>1,247</td>
                                    <td>12</td>
                                    <td>45</td>
                                    <td class="trend-up"><i class="ri-arrow-up-line"></i> +12%</td>
                                    <td>
                                        <button class="chart-btn" onclick="alert('View details (Demo)')">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="property-info">
                                            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=100&h=100&fit=crop"
                                                class="property-thumb" />
                                            <div>
                                                <div class="property-name">4 Bedroom Semi-Detached</div>
                                                <div class="property-type">Landed • Ajah</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>892</td>
                                    <td>8</td>
                                    <td>23</td>
                                    <td class="trend-up"><i class="ri-arrow-up-line"></i> +8%</td>
                                    <td>
                                        <button class="chart-btn" onclick="alert('View details (Demo)')">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="property-info">
                                            <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=100&h=100&fit=crop"
                                                class="property-thumb" />
                                            <div>
                                                <div class="property-name">Uncompleted 6 Bedroom</div>
                                                <div class="property-type">Uncompleted • Ikorodu</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>654</td>
                                    <td>3</td>
                                    <td>12</td>
                                    <td class="trend-down"><i class="ri-arrow-down-line"></i> -3%</td>
                                    <td>
                                        <button class="chart-btn" onclick="alert('View details (Demo)')">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="property-info">
                                            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=100&h=100&fit=crop"
                                                class="property-thumb" />
                                            <div>
                                                <div class="property-name">2 Bedroom Apartment</div>
                                                <div class="property-type">Rent • Ikeja</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>456</td>
                                    <td>5</td>
                                    <td>18</td>
                                    <td class="trend-up"><i class="ri-arrow-up-line"></i> +5%</td>
                                    <td>
                                        <button class="chart-btn" onclick="alert('View details (Demo)')">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Insights Grid -->
                <div class="insights-grid">
                    <div class="insight-card">
                        <div class="insight-header">
                            <div class="insight-icon">
                                <i class="ri-trending-up-line"></i>
                            </div>
                            <div>
                                <div class="insight-title">Best Performing Area</div>
                                <div class="insight-desc">Highest views this month</div>
                            </div>
                        </div>
                        <div class="insight-value">Lekki Phase 1</div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">
                            <i class="ri-arrow-up-line" style="color: #059669;"></i>
                            847 views from this area
                        </div>
                    </div>

                    <div class="insight-card">
                        <div class="insight-header">
                            <div class="insight-icon">
                                <i class="ri-time-line"></i>
                            </div>
                            <div>
                                <div class="insight-title">Peak Viewing Time</div>
                                <div class="insight-desc">When buyers are most active</div>
                            </div>
                        </div>
                        <div class="insight-value">7PM - 9PM</div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">
                            Weekdays • 45% of daily views
                        </div>
                    </div>

                    <div class="insight-card">
                        <div class="insight-header">
                            <div class="insight-icon">
                                <i class="ri-smartphone-line"></i>
                            </div>
                            <div>
                                <div class="insight-title">Device Usage</div>
                                <div class="insight-desc">How users view your listings</div>
                            </div>
                        </div>
                        <div class="insight-value">Mobile 68%</div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">
                            Desktop 28% • Tablet 4%
                        </div>
                    </div>
                </div>

              <!-- Quick Actions -->
              <div
                  style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                  <h2 style="font-size: 1.5rem;">Quick Actions</h2>
                  <div class="quick-actions">
                      <button class="action-btn" onclick="alert('Create new listing (Demo)')">
                          <i class="ri-add-line"></i>
                          New Listing
                      </button>
                      <button class="action-btn" onclick="alert('Boost a listing (Demo)')">
                          <i class="ri-rocket-line"></i>
                          Promote Property
                      </button>
                      <button class="action-btn" onclick="alert('View reports (Demo)')">
                          <i class="ri-file-chart-line"></i>
                          Download Report
                      </button>
                  </div>
              </div>
            </div>
        </div>
    </main>

    <script>
        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Views Chart
            const viewsCtx = document.getElementById('viewsChart').getContext('2d');
            new Chart(viewsCtx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        label: 'Property Views',
                        data: [245, 389, 412, 347],
                        borderColor: '#059669',
                        backgroundColor: 'rgba(5,150,105,0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb'
                            }
                        }
                    }
                }
            });

            // Device Chart
            const deviceCtx = document.getElementById('deviceChart').getContext('2d');
            new Chart(deviceCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Mobile', 'Desktop', 'Tablet'],
                    datasets: [{
                        data: [68, 28, 4],
                        backgroundColor: ['#059669', '#3b82f6', '#fbbf24'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '65%'
                }
            });
        });

        // Chart period change
        function changeChartPeriod(period) {
            const buttons = document.querySelectorAll('.chart-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Update chart data based on period (demo)
            const chart = Chart.getChart('viewsChart');
            if (chart) {
                switch (period) {
                    case 'week':
                        chart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        chart.data.datasets[0].data = [45, 52, 48, 67, 89, 102, 78];
                        break;
                    case 'month':
                        chart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                        chart.data.datasets[0].data = [245, 389, 412, 347];
                        break;
                    case 'year':
                        chart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                        chart.data.datasets[0].data = [1245, 1389, 1412, 1347, 1523, 1489];
                        break;
                }
                chart.update();
            }
        }

        // Simulate real-time updates (demo)
        function simulateUpdate() {
            const kpiValues = document.querySelectorAll('.kpi-value');
            kpiValues.forEach((el, index) => {
                if (index === 0) return; // Skip total listings
                const current = parseInt(el.textContent.replace(/[^0-9]/g, ''));
                const change = Math.floor(Math.random() * 10) - 3;
                const newValue = current + change;
                if (newValue > 0 && index !== 0) {
                    el.textContent = newValue.toLocaleString();
                }
            });
        }

        // Update every 30 seconds (demo)
        // setInterval(simulateUpdate, 30000);

        // User menu click
        const userInfo = document.querySelector('.user-info');
        userInfo.addEventListener('click', () => {
            alert('User menu would open here (Demo)');
        });
    </script>
</body>

</html>
