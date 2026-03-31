/**
 * Header Component for JustProperties
 * Manages consistent navigation across all pages and handles authentication state
 */

class HeaderComponent {
  constructor() {
    this.isAuthenticated = false;
    this.userData = null;
    this.init();
  }

  init() {
    // Check authentication state from localStorage
    this.checkAuthState();
    
    // Render the header
    this.render();
    
    // Set up event listeners
    this.setupEventListeners();
    
    // Update UI based on auth state
    this.updateAuthUI();
  }

  checkAuthState() {
    // Check if user is logged in from localStorage
    const userData = localStorage.getItem('justproperties_user');
    const authToken = localStorage.getItem('justproperties_auth_token');
    
    if (userData && authToken) {
      this.isAuthenticated = true;
      this.userData = JSON.parse(userData);
    } else {
      this.isAuthenticated = false;
      this.userData = null;
    }
  }

  render() {
    // Find the navbar container
    const navbar = document.querySelector('nav.navbar') || document.querySelector('nav');
    if (!navbar) return;

    // Create the consistent header HTML
    const headerHTML = `
      <div class="nav-container">
        <a class="nav-brand" href="index.html">
          <img src="images/logo.svg" alt="JustProperties Logo" class="nav-logo" />
          <h1>JustProperties</h1>
        </a>
        
        <div class="nav-links">
          <a href="landedproperty.html" class="nav-link">Landed Properties</a>
          <a href="uncompleted_property.html" class="nav-link">Uncompleted</a>
          <a href="completedproperty.html" class="nav-link">Completed</a>
          <a href="rent_lease.html" class="nav-link">Rent/Lease</a>
          <a href="short_let.html" class="nav-link">Short-Let</a>
          <a href="blog.html" class="nav-link">Blog</a>
        </div>
        
        <div class="nav-actions">
          <a href="list_property.html" class="btn-primary">
            <i class="ri-add-circle-line"></i>
            List Property
          </a>
          <a href="signin.html" class="btn-secondary auth-btn" id="auth-btn">
            <i class="ri-user-line"></i>
            <span id="auth-btn-text">Sign In</span>
          </a>
        </div>
        
        <button class="mobile-menu-btn" id="mobile-menu-btn">
          <i class="ri-menu-line"></i>
        </button>
      </div>
      
      <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-links">
          <a href="landedproperty.html" class="nav-link">Landed Properties</a>
          <a href="uncompleted_property.html" class="nav-link">Uncompleted</a>
          <a href="completedproperty.html" class="nav-link">Completed</a>
          <a href="rent_lease.html" class="nav-link">Rent/Lease</a>
          <a href="short_let.html" class="nav-link">Short-Let</a>
          <a href="blog.html" class="nav-link">Blog</a>
          <a href="list_property.html" class="nav-link">List Property</a>
          <a href="signin.html" class="nav-link auth-btn-mobile" id="auth-btn-mobile">Sign In</a>
        </div>
      </div>
    `;

    navbar.innerHTML = headerHTML;
  }

  setupEventListeners() {
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
      mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
        const icon = mobileMenuBtn.querySelector('i');
        if (mobileMenu.classList.contains('active')) {
          icon.className = 'ri-close-line';
        } else {
          icon.className = 'ri-menu-line';
        }
      });
    }

    // Auth button click handler
    const authBtn = document.getElementById('auth-btn');
    const authBtnMobile = document.getElementById('auth-btn-mobile');
    
    if (authBtn) {
      authBtn.addEventListener('click', (e) => {
        if (this.isAuthenticated) {
          e.preventDefault();
          this.handleSignOut();
        }
      });
    }
    
    if (authBtnMobile) {
      authBtnMobile.addEventListener('click', (e) => {
        if (this.isAuthenticated) {
          e.preventDefault();
          this.handleSignOut();
        }
      });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      if (mobileMenu && mobileMenu.classList.contains('active')) {
        if (!e.target.closest('.mobile-menu') && !e.target.closest('.mobile-menu-btn')) {
          mobileMenu.classList.remove('active');
          const icon = mobileMenuBtn?.querySelector('i');
          if (icon) icon.className = 'ri-menu-line';
        }
      }
    });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      const navbar = document.querySelector('nav.navbar');
      if (navbar) {
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      }
    });
  }

  updateAuthUI() {
    const authBtn = document.getElementById('auth-btn');
    const authBtnText = document.getElementById('auth-btn-text');
    const authBtnMobile = document.getElementById('auth-btn-mobile');
    
    if (this.isAuthenticated && this.userData) {
      // User is signed in - show Sign Out
      if (authBtn) {
        authBtn.href = '#';
        authBtn.classList.add('signed-in');
      }
      if (authBtnText) {
        authBtnText.textContent = 'Sign Out';
      }
      if (authBtnMobile) {
        authBtnMobile.textContent = 'Sign Out';
        authBtnMobile.href = '#';
      }
      
      // Update icon to indicate signed in state
      const authIcon = authBtn?.querySelector('i');
      if (authIcon) {
        authIcon.className = 'ri-logout-box-line';
      }
    } else {
      // User is signed out - show Sign In
      if (authBtn) {
        authBtn.href = 'signin.html';
        authBtn.classList.remove('signed-in');
      }
      if (authBtnText) {
        authBtnText.textContent = 'Sign In';
      }
      if (authBtnMobile) {
        authBtnMobile.textContent = 'Sign In';
        authBtnMobile.href = 'signin.html';
      }
      
      // Update icon to indicate signed out state
      const authIcon = authBtn?.querySelector('i');
      if (authIcon) {
        authIcon.className = 'ri-user-line';
      }
    }
  }

  handleSignOut() {
    // Clear authentication data
    localStorage.removeItem('justproperties_user');
    localStorage.removeItem('justproperties_auth_token');
    
    // Update state
    this.isAuthenticated = false;
    this.userData = null;
    
    // Update UI
    this.updateAuthUI();
    
    // Show notification
    this.showNotification('You have been signed out successfully.', 'success');
    
    // Redirect to home page after a short delay
    setTimeout(() => {
      window.location.href = 'index.html';
    }, 1500);
  }

  handleSignIn(userData, authToken) {
    // Store authentication data
    localStorage.setItem('justproperties_user', JSON.stringify(userData));
    localStorage.setItem('justproperties_auth_token', authToken);
    
    // Update state
    this.isAuthenticated = true;
    this.userData = userData;
    
    // Update UI
    this.updateAuthUI();
    
    // Show notification
    this.showNotification('Welcome back! You are now signed in.', 'success');
  }

  showNotification(message, type = 'info') {
    // Create notification element
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
    
    // Add styles if not already present
    if (!document.getElementById('notification-styles')) {
      const styles = document.createElement('style');
      styles.id = 'notification-styles';
      styles.textContent = `
        .notification {
          position: fixed;
          top: 20px;
          right: 20px;
          background: white;
          border-radius: 8px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.15);
          padding: 16px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 12px;
          z-index: 10000;
          animation: slideIn 0.3s ease;
          max-width: 400px;
        }
        
        .notification-success {
          border-left: 4px solid #10b981;
        }
        
        .notification-info {
          border-left: 4px solid #3b82f6;
        }
        
        .notification-content {
          display: flex;
          align-items: center;
          gap: 12px;
        }
        
        .notification-content i {
          font-size: 20px;
          color: #10b981;
        }
        
        .notification-close {
          background: none;
          border: none;
          cursor: pointer;
          padding: 4px;
          color: #6b7280;
        }
        
        .notification-close:hover {
          color: #111827;
        }
        
        @keyframes slideIn {
          from {
            transform: translateX(100%);
            opacity: 0;
          }
          to {
            transform: translateX(0);
            opacity: 1;
          }
        }
      `;
      document.head.appendChild(styles);
    }
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
      if (notification.parentElement) {
        notification.remove();
      }
    }, 5000);
  }

  // Public method to check if user is authenticated
  isUserAuthenticated() {
    return this.isAuthenticated;
  }

  // Public method to get user data
  getUserData() {
    return this.userData;
  }
}

// Initialize header when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.headerComponent = new HeaderComponent();
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = HeaderComponent;
}
