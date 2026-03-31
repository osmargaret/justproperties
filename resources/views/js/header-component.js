/**
 * JustProperties Header Component
 * Handles navigation and authentication state across all pages
 */

class HeaderComponent {
  constructor() {
    this.currentPage = this.getCurrentPage();
    this.init();
  }

  getCurrentPage() {
    const path = window.location.pathname;
    const page = path.split('/').pop() || 'index.html';
    return page;
  }

  init() {
    this.renderHeader();
    this.updateAuthState();
    this.setupEventListeners();
  }

  renderHeader() {
    const headerHTML = `
      <header class="header">
        <div class="header-container">
          <a href="index.html" class="logo">
            <div class="logo-icon">
              <i class="ri-home-4-line"></i>
            </div>
            <span class="logo-text">JustProperties</span>
          </a>

          <nav class="nav-menu">
            <a href="index.html" class="nav-link ${this.currentPage === 'index.html' ? 'active' : ''}">Home</a>
            <a href="browse_all.html" class="nav-link ${this.currentPage === 'browse_all.html' ? 'active' : ''}">Properties</a>
            <a href="blog.html" class="nav-link ${this.currentPage === 'blog.html' ? 'active' : ''}">Blog</a>
            <a href="about.html" class="nav-link ${this.currentPage === 'about.html' ? 'active' : ''}">About</a>
            <a href="contact.html" class="nav-link ${this.currentPage === 'contact.html' ? 'active' : ''}">Contact</a>
          </nav>

          <div class="header-actions">
            <a href="list_property.html" class="btn btn-primary">
              <i class="ri-add-line"></i>
              List Property
            </a>
            <a href="signin.html" class="btn btn-outline auth-btn" id="authBtn">
              <i class="ri-login-box-line"></i>
              <span id="authBtnText">Sign In</span>
            </a>
            <button class="mobile-menu-btn" id="mobileMenuBtn">
              <i class="ri-menu-line"></i>
            </button>
          </div>
        </div>

        <nav class="mobile-nav" id="mobileNav">
          <a href="index.html" class="mobile-nav-link ${this.currentPage === 'index.html' ? 'active' : ''}">Home</a>
          <a href="browse_all.html" class="mobile-nav-link ${this.currentPage === 'browse_all.html' ? 'active' : ''}">Properties</a>
          <a href="blog.html" class="mobile-nav-link ${this.currentPage === 'blog.html' ? 'active' : ''}">Blog</a>
          <a href="about.html" class="mobile-nav-link ${this.currentPage === 'about.html' ? 'active' : ''}">About</a>
          <a href="contact.html" class="mobile-nav-link ${this.currentPage === 'contact.html' ? 'active' : ''}">Contact</a>
          <a href="list_property.html" class="mobile-nav-link">List Property</a>
          <a href="signin.html" class="mobile-nav-link auth-btn-mobile" id="authBtnMobile">Sign In</a>
        </nav>
      </header>
    `;

    // Insert header at the beginning of body
    document.body.insertAdjacentHTML('afterbegin', headerHTML);
  }

  updateAuthState() {
    const isLoggedIn = localStorage.getItem('justproperties_logged_in') === 'true';
    const authBtn = document.getElementById('authBtn');
    const authBtnText = document.getElementById('authBtnText');
    const authBtnMobile = document.getElementById('authBtnMobile');

    if (isLoggedIn) {
      // User is logged in - show Sign Out
      if (authBtn) {
        authBtn.href = '#';
        authBtn.classList.add('logged-in');
        authBtn.onclick = (e) => {
          e.preventDefault();
          this.handleSignOut();
        };
      }
      if (authBtnText) {
        authBtnText.textContent = 'Sign Out';
      }
      if (authBtnMobile) {
        authBtnMobile.textContent = 'Sign Out';
        authBtnMobile.href = '#';
        authBtnMobile.onclick = (e) => {
          e.preventDefault();
          this.handleSignOut();
        };
      }
    } else {
      // User is not logged in - show Sign In
      if (authBtn) {
        authBtn.href = 'signin.html';
        authBtn.classList.remove('logged-in');
        authBtn.onclick = null;
      }
      if (authBtnText) {
        authBtnText.textContent = 'Sign In';
      }
      if (authBtnMobile) {
        authBtnMobile.textContent = 'Sign In';
        authBtnMobile.href = 'signin.html';
        authBtnMobile.onclick = null;
      }
    }
  }

  handleSignOut() {
    // Clear authentication data
    localStorage.removeItem('justproperties_logged_in');
    localStorage.removeItem('justproperties_user');
    localStorage.removeItem('justproperties_auth_token');
    
    // Show notification
    this.showNotification('You have been signed out successfully.', 'success');
    
    // Redirect to home page after a short delay
    setTimeout(() => {
      window.location.href = 'index.html';
    }, 1000);
  }

  showNotification(message, type = 'info') {
    // Remove existing notification
    const existing = document.querySelector('.notification');
    if (existing) {
      existing.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
      <div class="notification-content">
        <i class="ri-${type === 'success' ? 'check-line' : 'information-line'}"></i>
        <span>${message}</span>
      </div>
      <button class="notification-close" onclick="this.parentElement.remove()">
        <i class="ri-close-line"></i>
      </button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
      if (notification.parentElement) {
        notification.remove();
      }
    }, 5000);
  }

  setupEventListeners() {
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileNav = document.getElementById('mobileNav');

    if (mobileMenuBtn && mobileNav) {
      mobileMenuBtn.addEventListener('click', () => {
        mobileNav.classList.toggle('active');
        const icon = mobileMenuBtn.querySelector('i');
        if (mobileNav.classList.contains('active')) {
          icon.className = 'ri-close-line';
        } else {
          icon.className = 'ri-menu-line';
        }
      });

      // Close mobile menu when clicking on a link
      const mobileLinks = mobileNav.querySelectorAll('.mobile-nav-link');
      mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
          mobileNav.classList.remove('active');
          const icon = mobileMenuBtn.querySelector('i');
          icon.className = 'ri-menu-line';
        });
      });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      if (mobileNav && mobileNav.classList.contains('active')) {
        if (!e.target.closest('.header')) {
          mobileNav.classList.remove('active');
          const icon = mobileMenuBtn?.querySelector('i');
          if (icon) icon.className = 'ri-menu-line';
        }
      }
    });
  }
}

// Initialize header when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new HeaderComponent();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
  module.exports = HeaderComponent;
}
