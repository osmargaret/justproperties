<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-weight: 500; font-size: 0.875rem; color: #374151; margin-bottom: 0.5rem; }
    .form-label i { color: #059669; margin-right: 0.25rem; }
    .input-group { position: relative; display: flex; align-items: center; }
    .input-icon { position: absolute; left: 1rem; color: #9ca3af; z-index: 1; }
    .form-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #059669;
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    }
    .password-toggle {
        position: absolute;
        right: 1rem;
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 1.25rem;
    }
    .password-toggle:hover { color: #059669; }
    .submit-btn {
        width: 100%;
        padding: 1rem;
        background: #059669;
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .submit-btn:hover { background: #047857; }
    .submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .auth-link { color: #059669; font-weight: 600; text-decoration: none; }
    .auth-link:hover { text-decoration: underline; }
    .success-message {
        background: #dcfce7;
        color: #059669;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    [x-cloak] { display: none !important; }
</style>
