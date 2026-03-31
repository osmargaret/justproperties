/**
 * Analytics Module for JustProperties
 * Provides comprehensive analytics tracking and reporting
 */

class AnalyticsManager {
  constructor() {
    this.config = {
      trackingId: null,
      debug: false,
      anonymizeIp: true,
      cookieFlags: 'SameSite=None;Secure',
      cookieDomain: 'auto',
      cookieExpires: 63072000 // 2 years in seconds
    };
    this.eventQueue = [];
    this.initialized = false;
    this.init();
  }

  init() {
    // Add analytics styles
    this.addAnalyticsStyles();
    
    // Set up event listeners
    this.setupEventListeners();
    
    // Track page view
    this.trackPageView();
  }

  // Add analytics styles
  addAnalyticsStyles() {
    if (document.getElementById('analytics-styles')) return;
    
    const style = document.createElement('style');
    style.id = 'analytics-styles';
    style.textContent = `
      .analytics-consent {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #1f2937;
        color: white;
        padding: 1rem;
        z-index: 9999;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
      }

      .analytics-consent.show {
        transform: translateY(0);
      }

      .analytics-consent-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
      }

      .analytics-consent-text {
        flex: 1;
        min-width: 300px;
      }

      .analytics-consent-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .analytics-consent-description {
        font-size: 0.875rem;
        color: #d1d5db;
      }

      .analytics-consent-actions {
        display: flex;
        gap: 0.5rem;
      }

      .analytics-consent-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
      }

      .analytics-consent-button.accept {
        background-color: #10b981;
        color: white;
      }

      .analytics-consent-button.accept:hover {
        background-color: #059669;
      }

      .analytics-consent-button.decline {
        background-color: transparent;
        color: #d1d5db;
        border: 1px solid #4b5563;
      }

      .analytics-consent-button.decline:hover {
        background-color: #374151;
      }

      .analytics-consent-button.settings {
        background-color: transparent;
        color: #d1d5db;
        border: 1px solid #4b5563;
      }

      .analytics-consent-button.settings:hover {
        background-color: #374151;
      }

      .analytics-settings {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        border-radius: 0.5rem;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        z-index: 10000;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: none;
      }

      .analytics-settings.show {
        display: block;
      }

      .analytics-settings-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #111827;
      }

      .analytics-settings-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
      }

      .analytics-settings-option:last-child {
        border-bottom: none;
      }

      .analytics-settings-option-label {
        font-weight: 500;
        color: #374151;
      }

      .analytics-settings-option-description {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
      }

      .analytics-settings-toggle {
        position: relative;
        width: 3rem;
        height: 1.5rem;
        background-color: #d1d5db;
        border-radius: 9999px;
        cursor: pointer;
        transition: background-color 0.2s;
      }

      .analytics-settings-toggle.active {
        background-color: #10b981;
      }

      .analytics-settings-toggle::after {
        content: '';
        position: absolute;
        top: 0.125rem;
        left: 0.125rem;
        width: 1.25rem;
        height: 1.25rem;
        background-color: white;
        border-radius: 50%;
        transition: transform 0.2s;
      }

      .analytics-settings-toggle.active::after {
        transform: translateX(1.5rem);
      }

      .analytics-settings-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1.5rem;
        justify-content: flex-end;
      }

      .analytics-settings-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
      }

      .analytics-settings-button.save {
        background-color: #10b981;
        color: white;
      }

      .analytics-settings-button.save:hover {
        background-color: #059669;
      }

      .analytics-settings-button.cancel {
        background-color: #e5e7eb;
        color: #374151;
      }

      .analytics-settings-button.cancel:hover {
        background-color: #d1d5db;
      }

      .analytics-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none;
      }

      .analytics-overlay.show {
        display: block;
      }
    `;
    document.head.appendChild(style);
  }

  // Set up event listeners
  setupEventListeners() {
    // Track clicks
    document.addEventListener('click', (e) => {
      const target = e.target.closest('[data-track]');
      if (target) {
        const event = target.dataset.track;
        const data = this.getElementData(target);
        this.trackEvent(event, data);
      }
    });

    // Track form submissions
    document.addEventListener('submit', (e) => {
      const form = e.target;
      if (form.dataset.track) {
        const event = form.dataset.track;
        const data = this.getFormData(form);
        this.trackEvent(event, data);
      }
    });

    // Track scroll depth
    let maxScroll = 0;
    window.addEventListener('scroll', () => {
      const scrollPercent = Math.round(
        (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100
      );
      
      if (scrollPercent > maxScroll) {
        maxScroll = scrollPercent;
        
        // Track at 25%, 50%, 75%, 100%
        if ([25, 50, 75, 100].includes(scrollPercent)) {
          this.trackEvent('scroll_depth', { depth: scrollPercent });
        }
      }
    });

    // Track time on page
    let startTime = Date.now();
    window.addEventListener('beforeunload', () => {
      const timeOnPage = Math.round((Date.now() - startTime) / 1000);
      this.trackEvent('time_on_page', { seconds: timeOnPage });
    });

    // Track errors
    window.addEventListener('error', (e) => {
      this.trackEvent('javascript_error', {
        message: e.message,
        filename: e.filename,
        lineno: e.lineno
      });
    });
  }

  // Get element data
  getElementData(element) {
    const data = {};
    
    // Get all data attributes
    for (const attr of element.attributes) {
      if (attr.name.startsWith('data-') && attr.name !== 'data-track') {
        const key = attr.name.replace('data-', '').replace(/-([a-z])/g, (g) => g[1].toUpperCase());
        data[key] = attr.value;
      }
    }

    // Get element text
    if (element.textContent) {
      data.text = element.textContent.trim().substring(0, 100);
    }

    // Get element href
    if (element.href) {
      data.href = element.href;
    }

    return data;
  }

  // Get form data
  getFormData(form) {
    const data = {};
    const formData = new FormData(form);
    
    for (const [key, value] of formData.entries()) {
      // Don't track sensitive data
      if (!['password', 'credit_card', 'ssn'].includes(key.toLowerCase())) {
        data[key] = typeof value === 'string' ? value.substring(0, 100) : 'file';
      }
    }

    return data;
  }

  // Track page view
  trackPageView() {
    const data = {
      page: window.location.pathname,
      title: document.title,
      url: window.location.href,
      referrer: document.referrer,
      screen_width: window.screen.width,
      screen_height: window.screen.height,
      viewport_width: window.innerWidth,
      viewport_height: window.innerHeight
    };

    this.trackEvent('page_view', data);
  }

  // Track event
  trackEvent(eventName, eventData = {}) {
    const event = {
      event: eventName,
      timestamp: new Date().toISOString(),
      session_id: this.getSessionId(),
      user_id: this.getUserId(),
      ...eventData
    };

    // Add to queue
    this.eventQueue.push(event);

    // Log in debug mode
    if (this.config.debug) {
      console.log('Analytics Event:', event);
    }

    // Send to analytics services
    this.sendToServices(event);

    // Save to local storage
    this.saveToLocalStorage(event);
  }

  // Get session ID
  getSessionId() {
    let sessionId = sessionStorage.getItem('analytics_session_id');
    if (!sessionId) {
      sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
      sessionStorage.setItem('analytics_session_id', sessionId);
    }
    return sessionId;
  }

  // Get user ID
  getUserId() {
    let userId = localStorage.getItem('analytics_user_id');
    if (!userId) {
      userId = 'user_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
      localStorage.setItem('analytics_user_id', userId);
    }
    return userId;
  }

  // Send to analytics services
  sendToServices(event) {
    // Google Analytics
    if (window.gtag) {
      window.gtag('event', event.event, event);
    }

    // Facebook Pixel
    if (window.fbq) {
      window.fbq('track', event.event, event);
    }

    // Custom analytics endpoint
    if (this.config.endpoint) {
      fetch(this.config.endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(event)
      }).catch(() => {
        // Silently fail - don't disrupt user experience
      });
    }
  }

  // Save to local storage
  saveToLocalStorage(event) {
    try {
      const stored = localStorage.getItem('analytics_events');
      const events = stored ? JSON.parse(stored) : [];
      
      events.push(event);
      
      // Keep only last 100 events
      if (events.length > 100) {
        events.shift();
      }
      
      localStorage.setItem('analytics_events', JSON.stringify(events));
    } catch (e) {
      // Storage might be full
    }
  }

  // Show consent banner
  showConsentBanner() {
    const consent = localStorage.getItem('analytics_consent');
    if (consent) return;

    const banner = document.createElement('div');
    banner.className = 'analytics-consent';
    banner.innerHTML = `
      <div class="analytics-consent-content">
        <div class="analytics-consent-text">
          <div class="analytics-consent-title">We use cookies</div>
          <div class="analytics-consent-description">
            We use cookies and similar technologies to improve your experience, analyze traffic, and personalize content. 
            By continuing to use this site, you consent to our use of cookies.
          </div>
        </div>
        <div class="analytics-consent-actions">
          <button class="analytics-consent-button settings" onclick="analyticsManager.showSettings()">Settings</button>
          <button class="analytics-consent-button decline" onclick="analyticsManager.declineConsent()">Decline</button>
          <button class="analytics-consent-button accept" onclick="analyticsManager.acceptConsent()">Accept All</button>
        </div>
      </div>
    `;

    document.body.appendChild(banner);

    // Show banner
    setTimeout(() => banner.classList.add('show'), 100);
  }

  // Accept consent
  acceptConsent() {
    localStorage.setItem('analytics_consent', 'accepted');
    this.hideConsentBanner();
    this.trackEvent('consent_accepted');
  }

  // Decline consent
  declineConsent() {
    localStorage.setItem('analytics_consent', 'declined');
    this.hideConsentBanner();
    this.trackEvent('consent_declined');
  }

  // Hide consent banner
  hideConsentBanner() {
    const banner = document.querySelector('.analytics-consent');
    if (banner) {
      banner.classList.remove('show');
      setTimeout(() => banner.remove(), 300);
    }
  }

  // Show settings
  showSettings() {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'analytics-overlay';
    overlay.id = 'analytics-overlay';

    // Create settings modal
    const settings = document.createElement('div');
    settings.className = 'analytics-settings';
    settings.id = 'analytics-settings';
    settings.innerHTML = `
      <h3 class="analytics-settings-title">Analytics Settings</h3>
      
      <div class="analytics-settings-option">
        <div>
          <div class="analytics-settings-option-label">Essential Cookies</div>
          <div class="analytics-settings-option-description">Required for the website to function properly</div>
        </div>
        <div class="analytics-settings-toggle active" data-option="essential"></div>
      </div>

      <div class="analytics-settings-option">
        <div>
          <div class="analytics-settings-option-label">Analytics Cookies</div>
          <div class="analytics-settings-option-description">Help us understand how visitors interact with our website</div>
        </div>
        <div class="analytics-settings-toggle active" data-option="analytics"></div>
      </div>

      <div class="analytics-settings-option">
        <div>
          <div class="analytics-settings-option-label">Marketing Cookies</div>
          <div class="analytics-settings-option-description">Used to deliver personalized advertisements</div>
        </div>
        <div class="analytics-settings-toggle" data-option="marketing"></div>
      </div>

      <div class="analytics-settings-actions">
        <button class="analytics-settings-button cancel" onclick="analyticsManager.hideSettings()">Cancel</button>
        <button class="analytics-settings-button save" onclick="analyticsManager.saveSettings()">Save Settings</button>
      </div>
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(settings);

    // Show
    setTimeout(() => {
      overlay.classList.add('show');
      settings.classList.add('show');
    }, 100);

    // Add toggle functionality
    settings.querySelectorAll('.analytics-settings-toggle').forEach(toggle => {
      toggle.addEventListener('click', () => {
        if (toggle.dataset.option !== 'essential') {
          toggle.classList.toggle('active');
        }
      });
    });
  }

  // Hide settings
  hideSettings() {
    const overlay = document.getElementById('analytics-overlay');
    const settings = document.getElementById('analytics-settings');
    
    if (overlay) overlay.classList.remove('show');
    if (settings) settings.classList.remove('show');
    
    setTimeout(() => {
      if (overlay) overlay.remove();
      if (settings) settings.remove();
    }, 300);
  }

  // Save settings
  saveSettings() {
    const settings = document.getElementById('analytics-settings');
    const options = {};
    
    settings.querySelectorAll('.analytics-settings-toggle').forEach(toggle => {
      options[toggle.dataset.option] = toggle.classList.contains('active');
    });

    localStorage.setItem('analytics_settings', JSON.stringify(options));
    localStorage.setItem('analytics_consent', 'custom');
    
    this.hideSettings();
    this.hideConsentBanner();
    this.trackEvent('consent_custom', options);
  }

  // Get stored events
  getStoredEvents() {
    try {
      const stored = localStorage.getItem('analytics_events');
      return stored ? JSON.parse(stored) : [];
    } catch (e) {
      return [];
    }
  }

  // Clear stored events
  clearStoredEvents() {
    localStorage.removeItem('analytics_events');
  }

  // Export events
  exportEvents() {
    const events = this.getStoredEvents();
    const blob = new Blob([JSON.stringify(events, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `analytics-events-${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    URL.revokeObjectURL(url);
  }

  // Configure
  configure(config) {
    this.config = { ...this.config, ...config };
  }
}

// Create global instance
const analyticsManager = new AnalyticsManager();

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { AnalyticsManager, analyticsManager };
}