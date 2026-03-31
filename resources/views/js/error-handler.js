/**
 * Error Handling Module for JustProperties
 * Provides comprehensive error handling and user feedback
 */

class ErrorHandler {
  constructor() {
    this.errorLog = [];
    this.maxLogSize = 100;
    this.init();
  }

  init() {
    // Add error styles
    this.addErrorStyles();
    
    // Set up global error handlers
    this.setupGlobalHandlers();
  }

  // Add error styles to document
  addErrorStyles() {
    if (document.getElementById('error-styles')) return;
    
    const style = document.createElement('style');
    style.id = 'error-styles';
    style.textContent = `
      .error-toast {
        position: fixed;
        top: 1rem;
        right: 1rem;
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        border-left: 4px solid #ef4444;
        border-radius: 0.5rem;
        padding: 1rem 1.5rem;
        max-width: 400px;
        z-index: 10000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      }

      .error-toast.show {
        transform: translateX(0);
      }

      .error-toast-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
      }

      .error-toast-icon {
        color: #ef4444;
        font-size: 1.25rem;
      }

      .error-toast-title {
        font-weight: 600;
        color: #991b1b;
        font-size: 0.875rem;
      }

      .error-toast-message {
        color: #b91c1c;
        font-size: 0.875rem;
        line-height: 1.5;
      }

      .error-toast-close {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: none;
        border: none;
        color: #991b1b;
        cursor: pointer;
        padding: 0.25rem;
        font-size: 1rem;
        line-height: 1;
        opacity: 0.7;
        transition: opacity 0.2s;
      }

      .error-toast-close:hover {
        opacity: 1;
      }

      .success-toast {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-left: 4px solid #22c55e;
      }

      .success-toast .error-toast-icon {
        color: #22c55e;
      }

      .success-toast .error-toast-title {
        color: #166534;
      }

      .success-toast .error-toast-message {
        color: #15803d;
      }

      .warning-toast {
        background-color: #fffbeb;
        border: 1px solid #fde68a;
        border-left: 4px solid #f59e0b;
      }

      .warning-toast .error-toast-icon {
        color: #f59e0b;
      }

      .warning-toast .error-toast-title {
        color: #92400e;
      }

      .warning-toast .error-toast-message {
        color: #b45309;
      }

      .info-toast {
        background-color: #eff6ff;
        border: 1px solid #bfdbfe;
        border-left: 4px solid #3b82f6;
      }

      .info-toast .error-toast-icon {
        color: #3b82f6;
      }

      .info-toast .error-toast-title {
        color: #1e40af;
      }

      .info-toast .error-toast-message {
        color: #1d4ed8;
      }

      .error-boundary {
        padding: 2rem;
        text-align: center;
        background-color: #fef2f2;
        border-radius: 0.5rem;
        margin: 1rem;
      }

      .error-boundary-icon {
        font-size: 3rem;
        color: #ef4444;
        margin-bottom: 1rem;
      }

      .error-boundary-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #991b1b;
        margin-bottom: 0.5rem;
      }

      .error-boundary-message {
        color: #b91c1c;
        margin-bottom: 1rem;
      }

      .error-boundary-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
      }

      .error-boundary-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
      }

      .error-boundary-button.primary {
        background-color: #ef4444;
        color: white;
        border: none;
      }

      .error-boundary-button.primary:hover {
        background-color: #dc2626;
      }

      .error-boundary-button.secondary {
        background-color: white;
        color: #ef4444;
        border: 1px solid #ef4444;
      }

      .error-boundary-button.secondary:hover {
        background-color: #fef2f2;
      }

      .network-error {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
      }

      .network-error-icon {
        font-size: 4rem;
        color: #9ca3af;
        margin-bottom: 1rem;
      }

      .network-error-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
      }

      .network-error-message {
        color: #6b7280;
        margin-bottom: 1.5rem;
        max-width: 400px;
      }

      .network-error-button {
        background-color: #10b981;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
      }

      .network-error-button:hover {
        background-color: #059669;
      }
    `;
    document.head.appendChild(style);
  }

  // Set up global error handlers
  setupGlobalHandlers() {
    // Handle uncaught errors
    window.addEventListener('error', (event) => {
      this.logError({
        type: 'uncaught',
        message: event.message,
        filename: event.filename,
        lineno: event.lineno,
        colno: event.colno,
        error: event.error
      });
    });

    // Handle unhandled promise rejections
    window.addEventListener('unhandledrejection', (event) => {
      this.logError({
        type: 'unhandledrejection',
        message: event.reason?.message || 'Unhandled promise rejection',
        reason: event.reason
      });
    });

    // Handle fetch errors
    const originalFetch = window.fetch;
    window.fetch = async (...args) => {
      try {
        const response = await originalFetch(...args);
        if (!response.ok) {
          this.logError({
            type: 'fetch',
            message: `HTTP error! status: ${response.status}`,
            url: args[0],
            status: response.status
          });
        }
        return response;
      } catch (error) {
        this.logError({
          type: 'fetch',
          message: error.message,
          url: args[0],
          error: error
        });
        throw error;
      }
    };
  }

  // Log error
  logError(errorInfo) {
    const error = {
      ...errorInfo,
      timestamp: new Date().toISOString(),
      userAgent: navigator.userAgent,
      url: window.location.href
    };

    this.errorLog.push(error);

    // Keep log size manageable
    if (this.errorLog.length > this.maxLogSize) {
      this.errorLog.shift();
    }

    // Log to console in development
    if (process.env.NODE_ENV === 'development') {
      console.error('Error logged:', error);
    }

    // Send to analytics if available
    this.sendToAnalytics(error);
  }

  // Send error to analytics
  sendToAnalytics(error) {
    // Integration point for analytics services
    if (window.gtag) {
      window.gtag('event', 'exception', {
        description: error.message,
        fatal: error.type === 'uncaught'
      });
    }
  }

  // Show toast notification
  showToast(message, type = 'error', duration = 5000) {
    const toast = document.createElement('div');
    toast.className = `error-toast ${type}-toast`;
    
    const icons = {
      error: '⚠️',
      success: '✓',
      warning: '⚡',
      info: 'ℹ️'
    };

    const titles = {
      error: 'Error',
      success: 'Success',
      warning: 'Warning',
      info: 'Information'
    };

    toast.innerHTML = `
      <button class="error-toast-close" onclick="this.parentElement.remove()">×</button>
      <div class="error-toast-header">
        <span class="error-toast-icon">${icons[type]}</span>
        <span class="error-toast-title">${titles[type]}</span>
      </div>
      <div class="error-toast-message">${message}</div>
    `;

    document.body.appendChild(toast);

    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 10);

    // Auto remove
    if (duration > 0) {
      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
      }, duration);
    }

    return toast;
  }

  // Show error toast
  showError(message, duration = 5000) {
    return this.showToast(message, 'error', duration);
  }

  // Show success toast
  showSuccess(message, duration = 3000) {
    return this.showToast(message, 'success', duration);
  }

  // Show warning toast
  showWarning(message, duration = 4000) {
    return this.showToast(message, 'warning', duration);
  }

  // Show info toast
  showInfo(message, duration = 3000) {
    return this.showToast(message, 'info', duration);
  }

  // Handle API errors
  handleApiError(error, customMessage = null) {
    let message = customMessage || 'An error occurred. Please try again.';
    
    if (error.response) {
      // Server responded with error
      switch (error.response.status) {
        case 400:
          message = 'Invalid request. Please check your input.';
          break;
        case 401:
          message = 'Please sign in to continue.';
          break;
        case 403:
          message = 'You do not have permission to perform this action.';
          break;
        case 404:
          message = 'The requested resource was not found.';
          break;
        case 500:
          message = 'Server error. Please try again later.';
          break;
        default:
          message = error.response.data?.message || message;
      }
    } else if (error.request) {
      // Network error
      message = 'Network error. Please check your connection.';
    }

    this.showError(message);
    this.logError({
      type: 'api',
      message: message,
      error: error
    });
  }

  // Create error boundary
  createErrorBoundary(container, fallbackContent = null) {
    if (!container) return;

    const errorBoundary = document.createElement('div');
    errorBoundary.className = 'error-boundary';
    errorBoundary.innerHTML = fallbackContent || `
      <div class="error-boundary-icon">⚠️</div>
      <h2 class="error-boundary-title">Something went wrong</h2>
      <p class="error-boundary-message">We're sorry, but something unexpected happened. Please try again.</p>
      <div class="error-boundary-actions">
        <button class="error-boundary-button primary" onclick="window.location.reload()">Reload Page</button>
        <button class="error-boundary-button secondary" onclick="history.back()">Go Back</button>
      </div>
    `;

    container.innerHTML = '';
    container.appendChild(errorBoundary);
  }

  // Show network error
  showNetworkError(container, retryCallback = null) {
    if (!container) return;

    const networkError = document.createElement('div');
    networkError.className = 'network-error';
    networkError.innerHTML = `
      <div class="network-error-icon">📡</div>
      <h3 class="network-error-title">Connection Error</h3>
      <p class="network-error-message">Unable to connect to the server. Please check your internet connection and try again.</p>
      ${retryCallback ? '<button class="network-error-button" onclick="this.textContent=\'Retrying...\'; setTimeout(() => location.reload(), 1000)">Retry</button>' : ''}
    `;

    container.innerHTML = '';
    container.appendChild(networkError);
  }

  // Get error log
  getErrorLog() {
    return [...this.errorLog];
  }

  // Clear error log
  clearErrorLog() {
    this.errorLog = [];
  }

  // Export error log
  exportErrorLog() {
    const log = this.getErrorLog();
    const blob = new Blob([JSON.stringify(log, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `error-log-${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    URL.revokeObjectURL(url);
  }
}

// Create global instance
const errorHandler = new ErrorHandler();

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { ErrorHandler, errorHandler };
}