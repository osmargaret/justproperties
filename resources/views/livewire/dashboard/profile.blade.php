<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile - JustProperties</title>
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css" />
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f3f4f6;
      color: #111827;
      line-height: 1.5;
    }

    h1, h2, h3, h4, h5, h6 {
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
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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
      display: flex;
      align-items: center;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .profile-avatar {
      position: relative;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      font-weight: 600;
      color: #059669;
      border: 4px solid rgba(255,255,255,0.3);
    }

    .profile-avatar img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }

    .avatar-edit {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 32px;
      height: 32px;
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
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .profile-meta {
      display: flex;
      gap: 2rem;
      color: #d1fae5;
      font-size: 0.875rem;
    }

    .profile-meta i {
      margin-right: 0.25rem;
    }

    .profile-badge {
      margin-left: auto;
      background: rgba(255,255,255,0.2);
      padding: 0.5rem 1.5rem;
      border-radius: 2rem;
      font-weight: 600;
      border: 1px solid rgba(255,255,255,0.3);
    }

    /* Dashboard Layout */
    .profile-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 2rem;
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
        grid-row: 1 / -1;
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

        .main-content {
            max-width: 1280px;
            margin: 90px auto 2rem;
            padding: 0 1rem;
        }


    @media (min-width: 1024px) {
      .profile-grid {
        grid-template-columns: 300px 1fr;
      }
      .profile-sidebar {
          position: static;
          grid-column: auto;
          grid-row: auto;
      }
    }

    /* Sidebar */
    .profile-sidebar {
      background: white;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
      height: fit-content;
      position: sticky;
      top: 90px;
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
    }

    .menu-item:hover {
      background: #f0fdf4;
    }

    .menu-item.active {
      background: #f0fdf4;
      border-left-color: #059669;
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
      font-weight: 500;
    }

    .menu-item .badge {
      background: #ef4444;
      color: white;
      padding: 0.25rem 0.5rem;
      border-radius: 1rem;
      font-size: 0.75rem;
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

    /* Main Content Area */
    .profile-content {
      background: white;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }

    .content-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .content-header h2 {
      font-size: 1.5rem;
      font-weight: 600;
    }

    .edit-toggle {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      background: #f3f4f6;
      border: none;
      border-radius: 2rem;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .edit-toggle:hover {
      background: #e5e7eb;
    }

    .edit-toggle i {
      color: #059669;
    }

    /* Forms */
    .form-section {
      margin-bottom: 2rem;
      padding-bottom: 2rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .section-title {
      font-size: 1.125rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .section-title i {
      color: #059669;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    @media (min-width: 640px) {
      .form-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .form-group.full-width {
      grid-column: 1 / -1;
    }

    .form-label {
      font-weight: 500;
      font-size: 0.875rem;
      color: #374151;
    }

    .form-label i {
      color: #059669;
      margin-right: 0.25rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
      padding: 0.75rem 1rem;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      font-size: 0.875rem;
      transition: all 0.3s ease;
      background: white;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      outline: none;
      border-color: #059669;
      box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
    }

    .form-input:disabled,
    .form-select:disabled,
    .form-textarea:disabled {
      background: #f9fafb;
      cursor: not-allowed;
    }

    .form-actions {
      display: flex;
      gap: 1rem;
      justify-content: flex-end;
      margin-top: 2rem;
    }

    .btn-primary {
      padding: 0.75rem 2rem;
      background: #059669;
      color: white;
      border: none;
      border-radius: 0.5rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background: #047857;
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }

    .btn-secondary {
      padding: 0.75rem 2rem;
      background: #f3f4f6;
      color: #374151;
      border: none;
      border-radius: 0.5rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-secondary:hover {
      background: #e5e7eb;
    }

    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      margin-bottom: 2rem;
    }

    @media (min-width: 640px) {
      .stats-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .stat-card {
      background: #f9fafb;
      padding: 1.5rem 1rem;
      border-radius: 0.75rem;
      text-align: center;
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: #059669;
      margin-bottom: 0.25rem;
    }

    .stat-label {
      font-size: 0.875rem;
      color: #6b7280;
    }

    /* Subscription Card */
    .subscription-card {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      border-radius: 1rem;
      padding: 1.5rem;
      margin-bottom: 2rem;
      border: 1px solid #059669;
    }

    .sub-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1rem;
    }

    .sub-plan {
      font-size: 1.25rem;
      font-weight: 700;
      color: #059669;
    }

    .sub-status {
      background: #059669;
      color: white;
      padding: 0.25rem 1rem;
      border-radius: 1rem;
      font-size: 0.75rem;
    }

    .sub-details {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .sub-detail {
      font-size: 0.875rem;
    }

    .sub-detail .label {
      color: #6b7280;
      display: block;
      margin-bottom: 0.25rem;
    }

    .sub-detail .value {
      font-weight: 600;
    }

    .sub-progress {
      margin: 1rem 0;
    }

    .progress-bar {
      height: 8px;
      background: #e5e7eb;
      border-radius: 4px;
      overflow: hidden;
      margin-bottom: 0.25rem;
    }

    .progress-fill {
      height: 100%;
      background: #059669;
      width: 25%;
      border-radius: 4px;
    }

    .progress-text {
      font-size: 0.75rem;
      color: #6b7280;
      text-align: right;
    }

    .sub-actions {
      display: flex;
      gap: 1rem;
      margin-top: 1rem;
    }

    .sub-btn {
      flex: 1;
      padding: 0.5rem;
      border: 1px solid #059669;
      border-radius: 0.5rem;
      background: transparent;
      color: #059669;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .sub-btn:hover {
      background: #059669;
      color: white;
    }

    /* Listings Table */
    .listings-table {
      width: 100%;
      border-collapse: collapse;
    }

    .listings-table th {
      text-align: left;
      padding: 1rem 0.5rem;
      color: #6b7280;
      font-weight: 500;
      font-size: 0.875rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .listings-table td {
      padding: 1rem 0.5rem;
      border-bottom: 1px solid #e5e7eb;
      font-size: 0.875rem;
    }

    .listing-status {
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

    .status-expired {
      background: #fee2e2;
      color: #b91c1c;
    }

    .listing-actions {
      display: flex;
      gap: 0.5rem;
    }

    .listing-btn {
      padding: 0.25rem 0.75rem;
      border: 1px solid #e5e7eb;
      border-radius: 0.25rem;
      background: white;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 0.75rem;
    }

    .listing-btn:hover {
      background: #059669;
      color: white;
      border-color: #059669;
    }

    /* Notification Settings */
    .notification-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
    }

    .notification-info h4 {
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    .notification-info p {
      font-size: 0.875rem;
      color: #6b7280;
    }

    /* Toggle Switch */
    .switch {
      position: relative;
      display: inline-block;
      width: 52px;
      height: 26px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #e5e7eb;
      transition: .3s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 20px;
      width: 20px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .3s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #059669;
    }

    input:checked + .slider:before {
      transform: translateX(26px);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .profile-grid {
        grid-template-columns: 1fr;
      }
      
      .profile-sidebar {
        position: static;
      }

      .sub-details {
        grid-template-columns: 1fr;
      }

      .listings-table {
        display: block;
        overflow-x: auto;
      }
    }

    /* Verification Badge */
    .verification-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      padding: 0.25rem 0.75rem;
      background: #f0fdf4;
      color: #059669;
      border-radius: 1rem;
      font-size: 0.75rem;
      border: 1px solid #059669;
    }

    .verification-badge i {
      font-size: 0.875rem;
    }

    /* Document Upload */
    .document-upload {
      border: 2px dashed #e5e7eb;
      border-radius: 0.5rem;
      padding: 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .document-upload:hover {
      border-color: #059669;
      background: #f0fdf4;
    }

    .document-upload i {
      font-size: 2rem;
      color: #9ca3af;
      margin-bottom: 0.5rem;
    }

    .document-list {
      margin-top: 1rem;
    }

    .document-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 0.75rem;
      background: #f9fafb;
      border-radius: 0.5rem;
      margin-bottom: 0.5rem;
    }



    .document-item i {
      color: #059669;
    }

    .document-item .name {
      flex: 1;
      font-size: 0.875rem;
    }

    .document-item .status {
      font-size: 0.75rem;
      color: #059669;
    }

    .document-item .remove {
      color: #ef4444;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="index.html" class="nav-brand">
        <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png" alt="JustProperties" />
        <h1>JustProperties</h1>
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Profile Header -->
    <div class="profile-header">
      <div class="profile-avatar">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" />
        <div class="avatar-edit" onclick="alert('Change profile picture (Demo)')">
          <i class="ri-camera-line"></i>
        </div>
      </div>
      <div class="profile-info">
        <h1>John Doe</h1>
        <div class="profile-meta">
          <span><i class="ri-map-pin-line"></i> Ikorodu, Lagos</span>
          <span><i class="ri-calendar-line"></i> Member since Jan 2025</span>
          <span class="verification-badge">
            <i class="ri-verified-badge-fill"></i> Identity Verified
          </span>
        </div>
      </div>
      <div class="profile-badge">
        <i class="ri-crown-line"></i> Professional Plan
      </div>
    </div>

    <!-- Profile Grid -->
    <div class="profile-grid">
      <!-- Sidebar Menu -->
      @include('dashboard.sidebar', ['embeddedInProfile' => true])

      <!-- Main Content Area - Personal Information Tab (Default) -->
      <div class="profile-content" id="personal-tab">
        <div class="content-header">
          <h2>Personal Information</h2>
          <button class="edit-toggle" onclick="toggleEdit()">
            <i class="ri-pencil-line"></i>
            <span id="editText">Edit Profile</span>
          </button>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-value">12</div>
            <div class="stat-label">Properties Listed</div>
          </div>
          <div class="stat-card">
            <div class="stat-value">8</div>
            <div class="stat-label">Active Listings</div>
          </div>
          <div class="stat-card">
            <div class="stat-value">156</div>
            <div class="stat-label">Total Views</div>
          </div>
          <div class="stat-card">
            <div class="stat-value">23</div>
            <div class="stat-label">Inquiries</div>
          </div>
        </div>

        <form id="profileForm">
          <!-- Basic Information -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="ri-information-line"></i>
              Basic Information
            </h3>
            <div class="form-grid">
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-user-line"></i>
                  Full Name
                </label>
                <input type="text" class="form-input" value="John Doe" disabled id="fullName" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-user-smile-line"></i>
                  Display Name
                </label>
                <input type="text" class="form-input" value="John D." disabled id="displayName" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-calendar-line"></i>
                  Date of Birth
                </label>
                <input type="date" class="form-input" value="1990-01-01" disabled id="dob" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-map-pin-line"></i>
                  Location
                </label>
                <input type="text" class="form-input" value="Ikorodu, Lagos" disabled id="location" />
              </div>
            </div>
          </div>

          <!-- Contact Information -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="ri-contacts-line"></i>
              Contact Information
            </h3>
            <div class="form-grid">
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-mail-line"></i>
                  Email Address
                </label>
                <input type="email" class="form-input" value="john.doe@example.com" disabled id="email" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-phone-line"></i>
                  Phone Number
                </label>
                <input type="tel" class="form-input" value="+234 806 704 2140" disabled id="phone" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-whatsapp-line"></i>
                  WhatsApp Number
                </label>
                <input type="tel" class="form-input" value="+234 806 704 2140" disabled id="whatsapp" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-global-line"></i>
                  Website (Optional)
                </label>
                <input type="url" class="form-input" value="https://justproperties.com/johndoe" disabled id="website" />
              </div>
            </div>
          </div>

          <!-- About / Bio -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="ri-file-text-line"></i>
              About Me
            </h3>
            <div class="form-group full-width">
              <textarea class="form-textarea" rows="4" disabled id="bio">Experienced real estate professional with over 5 years in the Lagos property market. Specializing in luxury homes and investment properties in Ikorodu and surrounding areas.</textarea>
            </div>
          </div>

          <!-- Social Media Links -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="ri-share-line"></i>
              Social Media Links
            </h3>
            <div class="form-grid">
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-facebook-line"></i>
                  Facebook
                </label>
                <input type="url" class="form-input" value="https://facebook.com/johndoe" disabled id="facebook" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-instagram-line"></i>
                  Instagram
                </label>
                <input type="url" class="form-input" value="https://instagram.com/johndoe" disabled id="instagram" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-twitter-line"></i>
                  Twitter
                </label>
                <input type="url" class="form-input" value="https://twitter.com/johndoe" disabled id="twitter" />
              </div>
              <div class="form-group">
                <label class="form-label">
                  <i class="ri-linkedin-line"></i>
                  LinkedIn
                </label>
                <input type="url" class="form-input" value="https://linkedin.com/in/johndoe" disabled id="linkedin" />
              </div>
            </div>
          </div>

          <!-- Form Actions (Hidden by default) -->
          <div class="form-actions" id="formActions" style="display: none;">
            <button type="button" class="btn-secondary" onclick="cancelEdit()">Cancel</button>
            <button type="button" class="btn-primary" onclick="saveChanges()">Save Changes</button>
          </div>
        </form>
      </div>

      <!-- Subscription Tab (Hidden by default) -->
      <div class="profile-content" id="subscription-tab" style="display: none;">
        <div class="content-header">
          <h2>Subscription & Billing</h2>
        </div>

        <!-- Current Subscription -->
        <div class="subscription-card">
          <div class="sub-header">
            <span class="sub-plan">Professional Plan</span>
            <span class="sub-status">Active</span>
          </div>
          <div class="sub-details">
            <div class="sub-detail">
              <span class="label">Billing Cycle</span>
              <span class="value">Monthly</span>
            </div>
            <div class="sub-detail">
              <span class="label">Next Billing</span>
              <span class="value">April 15, 2026</span>
            </div>
            <div class="sub-detail">
              <span class="label">Amount</span>
              <span class="value">₦12,000/month</span>
            </div>
            <div class="sub-detail">
              <span class="label">Listings Used</span>
              <span class="value">3 of 5</span>
            </div>
          </div>
          <div class="sub-progress">
            <div class="progress-bar">
              <div class="progress-fill" style="width: 60%"></div>
            </div>
            <div class="progress-text">3 listings remaining this month</div>
          </div>
          <div class="sub-actions">
            <button class="sub-btn" onclick="alert('Change plan (Demo)')">Change Plan</button>
            <button class="sub-btn" onclick="alert('Cancel subscription (Demo)')">Cancel Subscription</button>
          </div>
        </div>

        <!-- Payment Methods -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-bank-card-line"></i>
            Payment Methods
          </h3>
          
          <div class="payment-methods" style="margin-bottom: 1rem;">
            <div class="payment-method" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; margin-bottom: 0.75rem;">
              <img src="https://public.readdy.ai/ai/img_res/card-payment.svg" alt="Visa" style="height: 24px;" />
              <span style="flex: 1;">Visa ending in 4242</span>
              <span style="color: #059669;">Default</span>
              <button class="listing-btn" onclick="alert('Edit card (Demo)')">Edit</button>
            </div>
            <div class="payment-method" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
              <img src="https://public.readdy.ai/ai/img_res/bank-transfer.svg" alt="Bank" style="height: 24px;" />
              <span style="flex: 1;">GTBank - 0123456789</span>
              <button class="listing-btn" onclick="alert('Edit bank (Demo)')">Edit</button>
            </div>
          </div>
          
          <button class="btn-secondary" onclick="alert('Add payment method (Demo)')">
            <i class="ri-add-line"></i> Add Payment Method
          </button>
        </div>

        <!-- Billing History -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-history-line"></i>
            Billing History
          </h3>
          
          <table class="listings-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Invoice</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Mar 15, 2026</td>
                <td>Professional Plan - Monthly</td>
                <td>₦12,000</td>
                <td><span class="listing-status status-active">Paid</span></td>
                <td><button class="listing-btn" onclick="alert('Download invoice (Demo)')"><i class="ri-download-line"></i> PDF</button></td>
              </tr>
              <tr>
                <td>Feb 15, 2026</td>
                <td>Professional Plan - Monthly</td>
                <td>₦12,000</td>
                <td><span class="listing-status status-active">Paid</span></td>
                <td><button class="listing-btn" onclick="alert('Download invoice (Demo)')"><i class="ri-download-line"></i> PDF</button></td>
              </tr>
              <tr>
                <td>Jan 15, 2026</td>
                <td>Professional Plan - Monthly</td>
                <td>₦12,000</td>
                <td><span class="listing-status status-active">Paid</span></td>
                <td><button class="listing-btn" onclick="alert('Download invoice (Demo)')"><i class="ri-download-line"></i> PDF</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- My Listings Tab (Hidden by default) -->
      <div class="profile-content" id="listings-tab" style="display: none;">
        <div class="content-header">
          <h2>My Listings</h2>
          <button class="btn-primary" onclick="alert('Create new listing (Demo)')">
            <i class="ri-add-line"></i> New Listing
          </button>
        </div>

        <table class="listings-table">
          <thead>
            <tr>
              <th>Property</th>
              <th>Type</th>
              <th>Price</th>
              <th>Status</th>
              <th>Views</th>
              <th>Inquiries</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Luxury 5 Bedroom Duplex</td>
              <td>Landed</td>
              <td>₦85,000,000</td>
              <td><span class="listing-status status-active">Active</span></td>
              <td>1,247</td>
              <td>12</td>
              <td>
                <div class="listing-actions">
                  <button class="listing-btn" onclick="alert('Edit listing (Demo)')">Edit</button>
                  <button class="listing-btn" onclick="alert('View listing (Demo)')">View</button>
                </div>
              </td>
            </tr>
            <tr>
              <td>4 Bedroom Semi-Detached</td>
              <td>Landed</td>
              <td>₦45,000,000</td>
              <td><span class="listing-status status-active">Active</span></td>
              <td>892</td>
              <td>8</td>
              <td>
                <div class="listing-actions">
                  <button class="listing-btn" onclick="alert('Edit listing (Demo)')">Edit</button>
                  <button class="listing-btn" onclick="alert('View listing (Demo)')">View</button>
                </div>
              </td>
            </tr>
            <tr>
              <td>2 Bedroom Apartment</td>
              <td>Rent</td>
              <td>₦1,200,000/year</td>
              <td><span class="listing-status status-pending">Pending</span></td>
              <td>456</td>
              <td>3</td>
              <td>
                <div class="listing-actions">
                  <button class="listing-btn" onclick="alert('Edit listing (Demo)')">Edit</button>
                  <button class="listing-btn" onclick="alert('View listing (Demo)')">View</button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Uncompleted 6 Bedroom</td>
              <td>Uncompleted</td>
              <td>₦35,000,000</td>
              <td><span class="listing-status status-expired">Expired</span></td>
              <td>654</td>
              <td>0</td>
              <td>
                <div class="listing-actions">
                  <button class="listing-btn" onclick="alert('Renew listing (Demo)')">Renew</button>
                  <button class="listing-btn" onclick="alert('View listing (Demo)')">View</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Documents Tab -->
      <div class="profile-content" id="documents-tab" style="display: none;">
        <div class="content-header">
          <h2>Verified Documents</h2>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-shield-check-line"></i>
            Verification Status
          </h3>
          
          <div class="verification-status" style="margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f0fdf4; border-radius: 0.5rem; border: 1px solid #059669;">
              <i class="ri-verified-badge-fill" style="font-size: 2rem; color: #059669;"></i>
              <div>
                <h4 style="font-weight: 600; margin-bottom: 0.25rem;">Identity Verified</h4>
                <p style="font-size: 0.875rem; color: #6b7280;">Your identity has been verified. You can now list properties with the "Verified Owner" badge.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-upload-line"></i>
            Upload Documents
          </h3>
          
          <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
            Upload government-issued ID, proof of address, or property documents to increase trust with buyers.
          </p>

          <div class="document-upload" onclick="alert('Upload document (Demo)')">
            <i class="ri-upload-cloud-line"></i>
            <p>Click to upload or drag and drop</p>
            <p style="font-size: 0.75rem;">PDF, JPEG, PNG (Max 10MB)</p>
          </div>

          <div class="document-list">
            <div class="document-item">
              <i class="ri-file-pdf-line"></i>
              <span class="name">Government ID - Passport.pdf</span>
              <span class="status">Verified</span>
              <i class="ri-check-line" style="color: #059669;"></i>
            </div>
            <div class="document-item">
              <i class="ri-file-image-line"></i>
              <span class="name">Utility Bill - March 2026.jpg</span>
              <span class="status">Pending</span>
              <i class="ri-time-line" style="color: #f59e0b;"></i>
            </div>
            <div class="document-item">
              <i class="ri-file-copy-line"></i>
              <span class="name">C of O - Property Document.pdf</span>
              <span class="status">Verified</span>
              <i class="ri-check-line" style="color: #059669;"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Notifications Tab -->
      <div class="profile-content" id="notifications-tab" style="display: none;">
        <div class="content-header">
          <h2>Notification Settings</h2>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-notification-line"></i>
            Email Notifications
          </h3>

          <div class="notification-item">
            <div class="notification-info">
              <h4>New Inquiries</h4>
              <p>Get notified when someone inquires about your properties</p>
            </div>
            <label class="switch">
              <input type="checkbox" checked id="notifyInquiries">
              <span class="slider"></span>
            </label>
          </div>

          <div class="notification-item">
            <div class="notification-info">
              <h4>Listing Views</h4>
              <p>Daily digest of views and engagement on your listings</p>
            </div>
            <label class="switch">
              <input type="checkbox" checked id="notifyViews">
              <span class="slider"></span>
            </label>
          </div>

          <div class="notification-item">
            <div class="notification-info">
              <h4>Subscription Updates</h4>
              <p>Billing reminders and plan change notifications</p>
            </div>
            <label class="switch">
              <input type="checkbox" checked id="notifySubscription">
              <span class="slider"></span>
            </label>
          </div>

          <div class="notification-item">
            <div class="notification-info">
              <h4>Promotions & Offers</h4>
              <p>Special offers and promotion opportunities</p>
            </div>
            <label class="switch">
              <input type="checkbox" id="notifyPromotions">
              <span class="slider"></span>
            </label>
          </div>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-whatsapp-line"></i>
            WhatsApp Notifications
          </h3>

          <div class="notification-item">
            <div class="notification-info">
              <h4>Instant Alerts</h4>
              <p>Get instant WhatsApp alerts for urgent inquiries</p>
            </div>
            <label class="switch">
              <input type="checkbox" checked id="whatsappAlerts">
              <span class="slider"></span>
            </label>
          </div>
        </div>
      </div>

      <!-- Security Tab -->
      <div class="profile-content" id="security-tab" style="display: none;">
        <div class="content-header">
          <h2>Security Settings</h2>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-lock-password-line"></i>
            Change Password
          </h3>

          <div class="form-grid">
            <div class="form-group full-width">
              <label class="form-label">Current Password</label>
              <input type="password" class="form-input" placeholder="Enter current password" />
            </div>
            <div class="form-group">
              <label class="form-label">New Password</label>
              <input type="password" class="form-input" placeholder="Enter new password" />
            </div>
            <div class="form-group">
              <label class="form-label">Confirm New Password</label>
              <input type="password" class="form-input" placeholder="Confirm new password" />
            </div>
          </div>
          <button class="btn-primary" style="margin-top: 1rem;" onclick="alert('Password updated (Demo)')">Update Password</button>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-shield-line"></i>
            Two-Factor Authentication
          </h3>

          <div class="notification-item">
            <div class="notification-info">
              <h4>Enable 2FA</h4>
              <p>Add an extra layer of security to your account</p>
            </div>
            <label class="switch">
              <input type="checkbox" id="enable2fa">
              <span class="slider"></span>
            </label>
          </div>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <i class="ri-delete-bin-line"></i>
            Delete Account
          </h3>
          <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
            Once you delete your account, there is no going back. Please be certain.
          </p>
          <button class="btn-secondary" style="background: #fee2e2; color: #b91c1c; border: none;" onclick="alert('Account deletion (Demo)')">
            Delete Account
          </button>
        </div>
      </div>

      <!-- Favorites Tab -->
      <div class="profile-content" id="favorites-tab" style="display: none;">
        <div class="content-header">
          <h2>Saved Properties</h2>
          <span>12 properties saved</span>
        </div>

        <div class="property-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
          <!-- Favorite Property Card 1 -->
          <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&h=250&fit=crop" style="width: 100%; height: 150px; object-fit: cover;" />
            <div style="padding: 1rem;">
              <h4 style="font-weight: 600; margin-bottom: 0.25rem;">Luxury 5 Bedroom Duplex</h4>
              <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Lekki Phase 1</p>
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 700; color: #059669;">₦85M</span>
                <button class="listing-btn" onclick="alert('Remove from favorites (Demo)')">
                  <i class="ri-heart-fill" style="color: #ef4444;"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Favorite Property Card 2 -->
          <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=400&h=250&fit=crop" style="width: 100%; height: 150px; object-fit: cover;" />
            <div style="padding: 1rem;">
              <h4 style="font-weight: 600; margin-bottom: 0.25rem;">4 Bedroom Semi-Detached</h4>
              <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Ajah</p>
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 700; color: #059669;">₦45M</span>
                <button class="listing-btn" onclick="alert('Remove from favorites (Demo)')">
                  <i class="ri-heart-fill" style="color: #ef4444;"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    let isEditing = false;

    // Tab switching
    function switchTab(tabName, el) {
      // Hide all tabs
      const tabs = ['personal', 'subscription', 'listings', 'documents', 'notifications', 'security', 'favorites'];
      tabs.forEach(tab => {
        const element = document.getElementById(`${tab}-tab`);
        if (element) element.style.display = 'none';
      });

      // Show selected tab
      const selectedTab = document.getElementById(`${tabName}-tab`);
      if (selectedTab) selectedTab.style.display = 'block';

      // Update active menu item (profile tab rows only)
      const menuItems = document.querySelectorAll('.menu-item[data-profile-tab]');
      menuItems.forEach(item => item.classList.remove('active'));
      if (el) {
        el.classList.add('active');
      }
    }

    // Toggle edit mode
    function toggleEdit() {
      isEditing = !isEditing;
      const inputs = document.querySelectorAll('#profileForm input, #profileForm textarea');
      const formActions = document.getElementById('formActions');
      const editText = document.getElementById('editText');

      inputs.forEach(input => {
        input.disabled = !isEditing;
      });

      if (isEditing) {
        formActions.style.display = 'flex';
        editText.textContent = 'Cancel Editing';
      } else {
        formActions.style.display = 'none';
        editText.textContent = 'Edit Profile';
      }
    }

    // Cancel edit
    function cancelEdit() {
      isEditing = true; // This will be toggled to false
      toggleEdit();
      // Reset form to original values (demo)
      alert('Changes discarded');
    }

    // Save changes
    function saveChanges() {
      // Get all values
      const fullName = document.getElementById('fullName').value;
      const email = document.getElementById('email').value;
      
      // Validate (demo)
      if (!fullName || !email) {
        alert('Please fill in all required fields');
        return;
      }

      alert('Profile updated successfully! (Demo)');
      toggleEdit(); // Exit edit mode
    }

    // Handle notification toggles
    const notificationToggles = document.querySelectorAll('.switch input');
    notificationToggles.forEach(toggle => {
      toggle.addEventListener('change', (e) => {
        alert(`Notification ${e.target.checked ? 'enabled' : 'disabled'} (Demo)`);
      });
    });

    // Avatar edit
    const avatarEdit = document.querySelector('.avatar-edit');
    avatarEdit.addEventListener('click', () => {
      alert('Change profile picture dialog would open (Demo)');
    });

    // Document upload
    const docUpload = document.querySelector('.document-upload');
    if (docUpload) {
      docUpload.addEventListener('click', () => {
        alert('Document upload dialog (Demo)');
      });
    }

    // Remove document
    const removeDocs = document.querySelectorAll('.document-item .remove');
    removeDocs.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (confirm('Remove this document?')) {
          btn.closest('.document-item').remove();
        }
      });
    });

    // Password strength indicator (demo)
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
      input.addEventListener('input', () => {
        if (input.value.length > 0 && input.value.length < 6) {
          input.style.borderColor = '#ef4444';
        } else if (input.value.length >= 6) {
          input.style.borderColor = '#059669';
        } else {
          input.style.borderColor = '#e5e7eb';
        }
      });
    });

    // 2FA toggle
    const twoFA = document.getElementById('enable2fa');
    if (twoFA) {
      twoFA.addEventListener('change', (e) => {
        if (e.target.checked) {
          alert('2FA setup would be initiated (Demo)');
        }
      });
    }

    // Delete account confirmation
    const deleteBtn = document.querySelector('button[onclick*="Delete Account"]');
    if (deleteBtn) {
      deleteBtn.addEventListener('click', () => {
        if (confirm('Are you absolutely sure? This action cannot be undone.')) {
          alert('Account deletion process (Demo)');
        }
      });
    }

    // Initialize - ensure personal tab is active
    document.addEventListener('DOMContentLoaded', () => {
      const defaultTab = document.querySelector('.menu-item[data-profile-tab="personal"]');
      if (defaultTab) {
        document.querySelectorAll('.menu-item[data-profile-tab]').forEach(item => item.classList.remove('active'));
        defaultTab.classList.add('active');
      }
    });
  </script>
</body>
</html>