@extends('layouts.latest.auth')
@section('title','Verify Email')

@section('style')
<style>
    .verify-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-navy);
        padding: 2rem 1rem;
    }

    .verify-card {
        background: var(--secondary-bg);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        box-shadow: 0 25px 80px rgba(0, 212, 255, 0.15);
        border: 1px solid rgba(0, 212, 255, 0.1);
        max-width: 500px;
        width: 100%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .verify-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .verify-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--primary-navy);
        position: relative;
        overflow: hidden;
    }

    .verify-icon::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shine 2s infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .verify-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .verify-subtitle {
        color: var(--primary-navy);
        opacity: 0.7;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
        line-height: 1.5;
    }

    .email-display {
        background: rgba(0, 212, 255, 0.1);
        border: 2px solid rgba(0, 212, 255, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 2rem;
        font-weight: 600;
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .success-alert {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .resend-btn {
        background: var(--gradient-primary);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        color: var(--primary-navy);
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .resend-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
    }

    .resend-btn:active {
        transform: translateY(0);
    }

    .resend-btn.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .resend-btn .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid var(--primary-navy);
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: none;
    }

    .resend-btn.loading .spinner {
        display: block;
    }

    .resend-btn.loading .btn-text {
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .verify-steps {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .step {
        flex: 1;
        max-width: 60px;
        text-align: center;
        position: relative;
    }

    .step::after {
        content: '';
        position: absolute;
        top: 20px;
        left: calc(100% + 0.5rem);
        width: 1rem;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
    }

    .step:last-child::after {
        display: none;
    }

    .step.active::after {
        background: var(--accent-cyan);
    }

    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin: 0 auto 0.5rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .step.active .step-circle {
        background: var(--gradient-primary);
        color: var(--primary-navy);
        box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
    }

    .step-label {
        font-size: 0.8rem;
        color: var(--primary-navy);
        opacity: 0.6;
        font-weight: 500;
    }

    .step.active .step-label {
        opacity: 1;
        font-weight: 600;
    }

    .logout-option {
        padding-top: 1.5rem;
        border-top: 1px solid rgba(0, 212, 255, 0.1);
        color: var(--primary-navy);
        opacity: 0.7;
    }

    .logout-option a {
        color: var(--accent-cyan);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .logout-option a:hover {
        color: var(--accent-teal);
        text-decoration: underline;
    }

    .instructions {
        background: rgba(0, 212, 255, 0.05);
        border-left: 4px solid var(--accent-cyan);
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border-radius: 0 12px 12px 0;
        text-align: left;
    }

    .instructions h6 {
        color: var(--primary-navy);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .instructions ul {
        color: var(--primary-navy);
        opacity: 0.8;
        margin: 0;
        padding-left: 1.2rem;
    }

    .instructions li {
        margin-bottom: 0.3rem;
    }

    @media (max-width: 768px) {
        .verify-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .verify-title {
            font-size: 1.8rem;
        }

        .verify-steps {
            gap: 0.5rem;
            padding: 0;
        }

        .step {
            max-width: 50px;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="verify-container">
    <div class="verify-card">
        <div class="verify-icon">
            <i class="fas fa-envelope"></i>
        </div>

        <h1 class="verify-title">Check Your Email</h1>
        <p class="verify-subtitle">We've sent a verification link to your email address</p>

        <div class="email-display">
            <i class="fas fa-at"></i>
            {{ Auth::user()->email ?? 'your email address' }}
        </div>

        <div class="verify-steps">
            <div class="step active">
                <div class="step-circle">1</div>
                <div class="step-label">Register</div>
            </div>
            <div class="step active">
                <div class="step-circle">2</div>
                <div class="step-label">Verify</div>
            </div>
            <div class="step">
                <div class="step-circle">3</div>
                <div class="step-label">Complete</div>
            </div>
        </div>

        @if (session('resent'))
        <div class="success-alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ __('A fresh verification link has been sent to your email address.') }}</span>
        </div>
        @endif

        <div class="instructions">
            <h6><i class="fas fa-info-circle"></i> What to do next:</h6>
            <ul>
                <li>Check your email inbox (and spam folder)</li>
                <li>Click the verification link in the email</li>
                <li>Return here to continue your registration</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('verification.resend') }}" id="resend-form">
            @csrf
            <button class="resend-btn" type="submit" id="resend-button">
                <div class="spinner"></div>
                <span class="btn-text">
                    <i class="fas fa-paper-plane"></i>
                    Resend Verification Email
                </span>
            </button>
        </form>

        <div class="logout-option">
            <p>Need to use a different email address?
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout and register again
                </a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resendForm = document.getElementById('resend-form');
    const resendButton = document.getElementById('resend-button');

    resendForm.addEventListener('submit', function() {
        resendButton.classList.add('loading');

        setTimeout(function() {
            resendButton.classList.remove('loading');
        }, 3000);
    });
});
</script>
@endsection