/**
 * Form Validation Module for JustProperties
 * Provides comprehensive form validation with real-time feedback
 */

class FormValidator {
  constructor(formElement, options = {}) {
    this.form = formElement;
    this.options = {
      validateOnInput: true,
      validateOnBlur: true,
      showErrors: true,
      errorClass: 'error',
      successClass: 'success',
      ...options
    };
    this.validators = {};
    this.init();
  }

  init() {
    if (!this.form) return;
    
    // Add submit handler
    this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    
    // Add real-time validation
    if (this.options.validateOnInput || this.options.validateOnBlur) {
      const inputs = this.form.querySelectorAll('input, textarea, select');
      inputs.forEach(input => {
        if (this.options.validateOnInput) {
          input.addEventListener('input', () => this.validateField(input));
        }
        if (this.options.validateOnBlur) {
          input.addEventListener('blur', () => this.validateField(input));
        }
      });
    }
  }

  // Validation rules
  static rules = {
    required: (value) => {
      if (typeof value === 'string') return value.trim() !== '';
      return value !== null && value !== undefined;
    },
    email: (value) => {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(value);
    },
    phone: (value) => {
      const phoneRegex = /^(\+234|0)[789][01]\d{8}$/;
      return phoneRegex.test(value.replace(/\s/g, ''));
    },
    minLength: (value, length) => {
      return value.length >= length;
    },
    maxLength: (value, length) => {
      return value.length <= length;
    },
    min: (value, min) => {
      return parseFloat(value) >= min;
    },
    max: (value, max) => {
      return parseFloat(value) <= max;
    },
    pattern: (value, regex) => {
      return regex.test(value);
    },
    match: (value, fieldId) => {
      const matchField = document.getElementById(fieldId);
      return matchField && value === matchField.value;
    },
    url: (value) => {
      try {
        new URL(value);
        return true;
      } catch {
        return false;
      }
    },
    number: (value) => {
      return !isNaN(parseFloat(value)) && isFinite(value);
    },
    integer: (value) => {
      return Number.isInteger(parseFloat(value));
    },
    alpha: (value) => {
      return /^[a-zA-Z]+$/.test(value);
    },
    alphanumeric: (value) => {
      return /^[a-zA-Z0-9]+$/.test(value);
    },
    date: (value) => {
      const date = new Date(value);
      return !isNaN(date.getTime());
    },
    futureDate: (value) => {
      const date = new Date(value);
      return date > new Date();
    },
    pastDate: (value) => {
      const date = new Date(value);
      return date < new Date();
    }
  };

  // Error messages
  static messages = {
    required: 'This field is required',
    email: 'Please enter a valid email address',
    phone: 'Please enter a valid Nigerian phone number (e.g., 08012345678)',
    minLength: (length) => `Must be at least ${length} characters`,
    maxLength: (length) => `Must be no more than ${length} characters`,
    min: (min) => `Must be at least ${min}`,
    max: (max) => `Must be no more than ${max}`,
    pattern: 'Invalid format',
    match: 'Fields do not match',
    url: 'Please enter a valid URL',
    number: 'Please enter a valid number',
    integer: 'Please enter a whole number',
    alpha: 'Only letters are allowed',
    alphanumeric: 'Only letters and numbers are allowed',
    date: 'Please enter a valid date',
    futureDate: 'Date must be in the future',
    pastDate: 'Date must be in the past'
  };

  // Add custom validator
  addValidator(fieldName, validatorFn, message) {
    this.validators[fieldName] = { fn: validatorFn, message };
  }

  // Validate a single field
  validateField(field) {
    const fieldName = field.name || field.id;
    const value = field.value;
    const validations = field.dataset.validate ? field.dataset.validate.split('|') : [];
    
    let isValid = true;
    let errorMessage = '';

    // Check built-in validations
    for (const validation of validations) {
      const [rule, param] = validation.split(':');
      
      if (FormValidator.rules[rule]) {
        const result = FormValidator.rules[rule](value, param);
        if (!result) {
          isValid = false;
          errorMessage = typeof FormValidator.messages[rule] === 'function' 
            ? FormValidator.messages[rule](param) 
            : FormValidator.messages[rule];
          break;
        }
      }
    }

    // Check custom validators
    if (isValid && this.validators[fieldName]) {
      const result = this.validators[fieldName].fn(value, field);
      if (!result) {
        isValid = false;
        errorMessage = this.validators[fieldName].message;
      }
    }

    // Update UI
    if (this.options.showErrors) {
      this.showFieldStatus(field, isValid, errorMessage);
    }

    return isValid;
  }

  // Show field validation status
  showFieldStatus(field, isValid, message) {
    const formGroup = field.closest('.form-group') || field.parentElement;
    const existingError = formGroup.querySelector('.error-message');
    
    // Remove existing error
    if (existingError) {
      existingError.remove();
    }

    // Remove existing classes
    field.classList.remove(this.options.errorClass, this.options.successClass);
    formGroup.classList.remove('has-error', 'has-success');

    if (!isValid && message) {
      // Add error state
      field.classList.add(this.options.errorClass);
      formGroup.classList.add('has-error');
      
      // Create error message
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.textContent = message;
      errorDiv.style.color = '#ef4444';
      errorDiv.style.fontSize = '0.875rem';
      errorDiv.style.marginTop = '0.25rem';
      formGroup.appendChild(errorDiv);
    } else if (isValid && field.value) {
      // Add success state
      field.classList.add(this.options.successClass);
      formGroup.classList.add('has-success');
    }
  }

  // Validate entire form
  validateForm() {
    const inputs = this.form.querySelectorAll('input, textarea, select');
    let isFormValid = true;
    
    inputs.forEach(input => {
      if (input.hasAttribute('required') || input.dataset.validate) {
        const isFieldValid = this.validateField(input);
        if (!isFieldValid) {
          isFormValid = false;
        }
      }
    });

    return isFormValid;
  }

  // Handle form submission
  handleSubmit(e) {
    e.preventDefault();
    
    const isFormValid = this.validateForm();
    
    if (isFormValid) {
      // Show loading state
      const submitBtn = this.form.querySelector('[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="loading-spinner"></span> Submitting...';
      }

      // Trigger custom submit event
      const event = new CustomEvent('formValidSubmit', {
        detail: { form: this.form, data: this.getFormData() }
      });
      this.form.dispatchEvent(event);
    } else {
      // Focus first error field
      const firstError = this.form.querySelector(`.${this.options.errorClass}`);
      if (firstError) {
        firstError.focus();
      }
    }
  }

  // Get form data as object
  getFormData() {
    const formData = new FormData(this.form);
    const data = {};
    formData.forEach((value, key) => {
      data[key] = value;
    });
    return data;
  }

  // Reset form
  reset() {
    this.form.reset();
    const inputs = this.form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
      input.classList.remove(this.options.errorClass, this.options.successClass);
      const formGroup = input.closest('.form-group') || input.parentElement;
      formGroup.classList.remove('has-error', 'has-success');
      const errorMessage = formGroup.querySelector('.error-message');
      if (errorMessage) {
        errorMessage.remove();
      }
    });
  }
}

// Auto-initialize forms with data-validate attribute
document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form[data-validate]');
  forms.forEach(form => {
    new FormValidator(form);
  });
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = FormValidator;
}