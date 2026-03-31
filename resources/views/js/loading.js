/**
 * Loading States Module for JustProperties
 * Provides loading indicators for forms, buttons, and page elements
 */

class LoadingManager {
  constructor() {
    this.loadingElements = new Map();
    this.init();
  }

  init() {
    // Add loading CSS if not present
    this.addLoadingStyles();
  }

  // Add loading styles to document
  addLoadingStyles() {
    if (document.getElementById('loading-styles')) return;
    
    const style = document.createElement('style');
    style.id = 'loading-styles';
    style.textContent = `
      .loading-spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: currentColor;
        animation: spin 0.8s linear infinite;
        margin-right: 0.5rem;
        vertical-align: middle;
      }

      @keyframes spin {
        to { transform: rotate(360deg); }
      }

      .loading-dots {
        display: inline-flex;
        gap: 0.25rem;
        align-items: center;
      }

      .loading-dots span {
        width: 0.5rem;
        height: 0.5rem;
        background-color: currentColor;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
      }

      .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
      .loading-dots span:nth-child(2) { animation-delay: -0.16s; }

      @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
      }

      .loading-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
      }

      @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
      }

      .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: skeleton 1.5s infinite;
        border-radius: 0.25rem;
      }

      @keyframes skeleton {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
      }

      .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
      }

      .loading-overlay.active {
        opacity: 1;
        visibility: visible;
      }

      .loading-overlay-content {
        background-color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      }

      .loading-overlay-spinner {
        width: 3rem;
        height: 3rem;
        border: 3px solid #e5e7eb;
        border-top-color: #10b981;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
      }

      .btn-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
      }

      .btn-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 1.25rem;
        height: 1.25rem;
        margin-top: -0.625rem;
        margin-left: -0.625rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
      }

      .skeleton-text {
        height: 1rem;
        margin-bottom: 0.5rem;
        border-radius: 0.25rem;
      }

      .skeleton-text.short { width: 60%; }
      .skeleton-text.medium { width: 80%; }
      .skeleton-text.long { width: 100%; }

      .skeleton-image {
        width: 100%;
        height: 200px;
        border-radius: 0.5rem;
      }

      .skeleton-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
      }

      .skeleton-button {
        width: 100%;
        height: 2.5rem;
        border-radius: 0.5rem;
      }
    `;
    document.head.appendChild(style);
  }

  // Show loading on button
  showButtonLoading(button, text = 'Loading...') {
    if (!button) return;
    
    const originalText = button.innerHTML;
    const originalDisabled = button.disabled;
    
    this.loadingElements.set(button, { originalText, originalDisabled });
    
    button.disabled = true;
    button.classList.add('btn-loading');
    button.innerHTML = `<span class="loading-spinner"></span>${text}`;
  }

  // Hide loading on button
  hideButtonLoading(button) {
    if (!button) return;
    
    const data = this.loadingElements.get(button);
    if (data) {
      button.disabled = data.originalDisabled;
      button.classList.remove('btn-loading');
      button.innerHTML = data.originalText;
      this.loadingElements.delete(button);
    }
  }

  // Show loading overlay
  showOverlay(message = 'Loading...') {
    let overlay = document.getElementById('loading-overlay');
    
    if (!overlay) {
      overlay = document.createElement('div');
      overlay.id = 'loading-overlay';
      overlay.className = 'loading-overlay';
      overlay.innerHTML = `
        <div class="loading-overlay-content">
          <div class="loading-overlay-spinner"></div>
          <p>${message}</p>
        </div>
      `;
      document.body.appendChild(overlay);
    }
    
    // Trigger reflow
    overlay.offsetHeight;
    overlay.classList.add('active');
  }

  // Hide loading overlay
  hideOverlay() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
      overlay.classList.remove('active');
    }
  }

  // Create skeleton loader
  createSkeleton(type = 'text', options = {}) {
    const skeleton = document.createElement('div');
    skeleton.className = 'loading-skeleton';
    
    switch (type) {
      case 'text':
        skeleton.classList.add('skeleton-text', options.size || 'medium');
        break;
      case 'image':
        skeleton.classList.add('skeleton-image');
        if (options.height) skeleton.style.height = options.height;
        break;
      case 'avatar':
        skeleton.classList.add('skeleton-avatar');
        break;
      case 'button':
        skeleton.classList.add('skeleton-button');
        break;
      case 'card':
        skeleton.innerHTML = `
          <div class="loading-skeleton skeleton-image" style="height: ${options.imageHeight || '200px'}"></div>
          <div style="padding: 1rem;">
            <div class="loading-skeleton skeleton-text long"></div>
            <div class="loading-skeleton skeleton-text medium"></div>
            <div class="loading-skeleton skeleton-text short"></div>
          </div>
        `;
        skeleton.style.backgroundColor = 'white';
        skeleton.style.borderRadius = '0.5rem';
        skeleton.style.overflow = 'hidden';
        break;
    }
    
    return skeleton;
  }

  // Show skeleton in container
  showSkeleton(container, count = 1, type = 'text') {
    if (!container) return;
    
    container.innerHTML = '';
    
    for (let i = 0; i < count; i++) {
      const skeleton = this.createSkeleton(type);
      container.appendChild(skeleton);
    }
  }

  // Create loading dots
  createLoadingDots() {
    const dots = document.createElement('div');
    dots.className = 'loading-dots';
    dots.innerHTML = '<span></span><span></span><span></span>';
    return dots;
  }

  // Add loading state to element
  addLoadingState(element) {
    if (!element) return;
    element.classList.add('loading-pulse');
  }

  // Remove loading state from element
  removeLoadingState(element) {
    if (!element) return;
    element.classList.remove('loading-pulse');
  }
}

// Create global instance
const loadingManager = new LoadingManager();

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { LoadingManager, loadingManager };
}