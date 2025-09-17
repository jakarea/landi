@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - শেয়ার')
@section('header-title', 'কোর্স শেয়ার করুন')
@section('header-subtitle', 'আপনার কোর্সটি সোশ্যাল মিডিয়ায় শেয়ার করুন এবং আরও মানুষের কাছে পৌঁছান')
@section('style')
<style>
/* Progress steps styling */
.step-progress {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-x: auto;
    padding: 1rem 0;
    gap: 0.5rem;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 80px;
    position: relative;
    flex-shrink: 0;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: 2px solid;
}

.step-item.current .step-circle {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-color: #5AEAF4;
    color: #091D3D;
    transform: scale(1.1);
}

.step-item.completed .step-circle {
    background-color: #10B981;
    border-color: #10B981;
    color: #FFFFFF;
}

.step-item.completed .step-circle i {
    font-size: 1rem;
}

.step-item:not(.current):not(.completed) .step-circle {
    background-color: transparent;
    border-color: rgba(255, 255, 255, 0.3);
    color: #9CA3AF;
}

.step-title {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
}

.step-item.current .step-title {
    color: #5AEAF4;
}

.step-item.completed .step-title {
    color: #10B981;
}

.step-item:not(.current):not(.completed) .step-title {
    color: #9CA3AF;
}

.step-title a {
    text-decoration: none;
    color: inherit;
}

.step-title a.disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Connection lines between steps */
.step-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    left: calc(100% + 0.25rem);
    width: calc(100% - 40px);
    height: 2px;
    background: rgba(255, 255, 255, 0.2);
    z-index: -1;
}

.step-item.completed:not(:last-child)::after {
    background: #10B981;
}

/* Social share button styling */
.social-share-btn {
    display: flex;
    align-items: center;
    text-decoration: none;
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
    font-weight: 500;
    min-width: 160px;
}

.social-share-btn:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
    border-color: rgba(255, 255, 255, 0.3);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.1));
}

.social-share-btn i {
    font-size: 1.5rem;
    margin-right: 0.75rem;
    width: 24px;
    text-align: center;
    transition: all 0.3s ease;
}

.social-share-btn span {
    font-size: 1rem;
}

.social-share-btn:hover i {
    transform: scale(1.1);
}

/* Platform specific colors */
.facebook-btn {
    background: linear-gradient(135deg, #1877f2, #0d5dbf);
    border-color: #1877f2;
}

.facebook-btn:hover {
    background: linear-gradient(135deg, #2b88ff, #1877f2);
    box-shadow: 0 12px 25px rgba(24, 119, 242, 0.4);
}

.linkedin-btn {
    background: linear-gradient(135deg, #0077b5, #005885);
    border-color: #0077b5;
}

.linkedin-btn:hover {
    background: linear-gradient(135deg, #0e8bd9, #0077b5);
    box-shadow: 0 12px 25px rgba(0, 119, 181, 0.4);
}

.twitter-btn {
    background: linear-gradient(135deg, #1da1f2, #0d8bd9);
    border-color: #1da1f2;
}

.twitter-btn:hover {
    background: linear-gradient(135deg, #4ab3f4, #1da1f2);
    box-shadow: 0 12px 25px rgba(29, 161, 242, 0.4);
}

.messenger-btn {
    background: linear-gradient(135deg, #0084ff, #0066cc);
    border-color: #0084ff;
}

.messenger-btn:hover {
    background: linear-gradient(135deg, #339cff, #0084ff);
    box-shadow: 0 12px 25px rgba(0, 132, 255, 0.4);
}

.whatsapp-btn {
    background: linear-gradient(135deg, #25d366, #1da851);
    border-color: #25d366;
}

.whatsapp-btn:hover {
    background: linear-gradient(135deg, #4cdd7a, #25d366);
    box-shadow: 0 12px 25px rgba(37, 211, 102, 0.4);
}

.telegram-btn {
    background: linear-gradient(135deg, #0088cc, #006699);
    border-color: #0088cc;
}

.telegram-btn:hover {
    background: linear-gradient(135deg, #339edb, #0088cc);
    box-shadow: 0 12px 25px rgba(0, 136, 204, 0.4);
}

/* Share sections */
.share-section {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.share-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

/* Section titles */
.section-title {
    color: #FFFFFF;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #5AEAF4;
    font-size: 1.5rem;
}

.section-subtitle {
    color: #C7C7C7;
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-subtitle i {
    color: #5AEAF4;
    font-size: 1rem;
}

/* Copy link styling */
.copy-link-container {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 1px solid rgba(90, 234, 244, 0.3);
    border-radius: 0.75rem;
    padding: 1rem;
    margin-top: 1rem;
}

.copy-link-input {
    flex: 1;
    background: transparent;
    border: none;
    color: #FFFFFF;
    font-size: 0.95rem;
    outline: none;
    padding: 0.5rem;
}

.copy-link-input::placeholder {
    color: #9CA3AF;
}

.copy-btn {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    color: #091D3D;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.copy-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.copy-notification {
    position: absolute;
    top: -2.5rem;
    right: 1rem;
    background: linear-gradient(135deg, #10B981, #34D399);
    color: #FFFFFF;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
    pointer-events: none;
}

.copy-notification.show {
    opacity: 1;
    transform: translateY(0);
}

/* Action buttons */
.action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: transparent;
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #C7C7C7;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    border-color: #F97316;
    color: #F97316;
    background-color: rgba(249, 115, 22, 0.1);
}

.btn-finish {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #10B981, #34D399);
    border: none;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-finish:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

/* Responsive design */
@media (max-width: 768px) {
    .step-progress {
        padding: 0.5rem;
    }
    
    .step-item {
        min-width: 60px;
    }
    
    .step-circle {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
    
    .step-title {
        font-size: 0.6875rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-back,
    .btn-finish {
        width: 100%;
        justify-content: center;
    }
    
    .share-section {
        padding: 1.5rem;
    }
    
    .share-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .social-share-btn {
        min-width: auto;
        justify-content: center;
    }
    
    .copy-link-container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .copy-btn {
        margin-top: 0.5rem;
        align-self: stretch;
    }
    
    .copy-notification {
        position: static;
        margin-top: 0.5rem;
        text-align: center;
    }
}

/* Success animation */
@keyframes successPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.success-animation {
    animation: successPulse 0.6s ease-in-out;
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="bg-card rounded-xl p-6 shadow-2">
        <div class="step-progress">
            <div class="step-item completed">
                <div class="step-circle">1</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/facts' }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">2</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/objects' }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">3</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/price' }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">4</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/design' }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">5</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/certificate' }}">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">7</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/visibility' }}">দৃশ্যমানতা</a>
                </div>
            </div>
            <div class="step-item current">
                <div class="step-circle">8</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/share' }}">শেয়ার</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Share Section -->
    <div class="bg-card rounded-xl shadow-2">
        <div class="p-8">
            <h2 class="section-title">
                <i class="fas fa-share-alt"></i>
                আপনার কোর্স শেয়ার করুন
            </h2>

            <!-- Social Media Share -->
            <div class="share-section">
                <h3 class="section-subtitle">
                    <i class="fas fa-bullhorn"></i>
                    পোস্ট হিসেবে শেয়ার করুন
                </h3>
                
                <div class="share-grid">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('courses', $course->slug) }}"
                       target="_blank" 
                       class="social-share-btn facebook-btn">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                    
                    <a href="https://www.linkedin.com/shareArticle?url={{ url('courses', $course->slug) }}" 
                       target="_blank" 
                       class="social-share-btn linkedin-btn">
                        <i class="fab fa-linkedin-in"></i>
                        <span>LinkedIn</span>
                    </a>
                    
                    <a href="https://twitter.com/intent/tweet?url={{ url('courses', $course->slug) }}&text={{ urlencode($course->title) }}"
                       target="_blank" 
                       class="social-share-btn twitter-btn">
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </a>
                </div>
                
                <h3 class="section-subtitle">
                    <i class="fas fa-comments"></i>
                    মেসেজ হিসেবে শেয়ার করুন
                </h3>
                
                <div class="share-grid">
                    <a href="https://www.messenger.com/share.php?text={{ url('courses', $course->slug) }}"
                       target="_blank" 
                       class="social-share-btn messenger-btn">
                        <i class="fab fa-facebook-messenger"></i>
                        <span>Messenger</span>
                    </a>
                    
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('আমার নতুন কোর্স দেখুন: ' . $course->title . ' - ' . url('courses', $course->slug)) }}"
                       target="_blank" 
                       class="social-share-btn whatsapp-btn">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    
                    <a href="https://telegram.me/share/url?url={{ url('courses', $course->slug) }}"
                       target="_blank" 
                       class="social-share-btn telegram-btn">
                        <i class="fab fa-telegram-plane"></i>
                        <span>Telegram</span>
                    </a>
                </div>
                
                <!-- Copy Link Section -->
                <div class="mt-8">
                    <h3 class="section-subtitle">
                        <i class="fas fa-link"></i>
                        অথবা লিংক কপি করুন
                    </h3>
                    
                    <div class="copy-link-container">
                        <input 
                            type="text" 
                            value="{{ url('courses', $course->slug) }}"
                            class="copy-link-input" 
                            id="linkToCopy"
                            readonly
                        >
                        <button type="button" class="copy-btn" id="copyButton">
                            <i class="fas fa-copy mr-2"></i>
                            কপি করুন
                        </button>
                        <div class="copy-notification" id="copyNotification">
                            <i class="fas fa-check mr-2"></i>
                            কপি হয়েছে!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Completion Message -->
    <div class="bg-gradient-to-r from-green-500/10 to-blue-500/10 rounded-xl p-6 border border-green-500/20">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-green-400 rounded-full mb-4 success-animation">
                <i class="fas fa-trophy text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">অভিনন্দন! 🎉</h3>
            <p class="text-gray-300 mb-4">আপনার কোর্স "{{ $course->title }}" সফলভাবে তৈরি হয়েছে। এখন এটি শেয়ার করে আরও মানুষের কাছে পৌঁছান।</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="action-buttons">
        <a href="{{ url('instructor/courses/create/'.$course->id.'/visibility') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            পূর্ববর্তী ধাপ
        </a>
        
        <a href="{{ url('instructor/courses/create/'.$course->id.'/finish') }}" class="btn-finish">
            <i class="fas fa-flag-checkered"></i>
            সমাপ্ত করুন
        </a>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const copyButton = document.getElementById('copyButton');
    const linkToCopy = document.getElementById('linkToCopy');
    const copyNotification = document.getElementById('copyNotification');
    const socialButtons = document.querySelectorAll('.social-share-btn');
    
    // Enhanced copy functionality
    copyButton.addEventListener('click', async function(e) {
        e.preventDefault();
        
        try {
            // Modern clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(linkToCopy.value);
            } else {
                // Fallback for older browsers
                linkToCopy.select();
                linkToCopy.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');
            }
            
            // Show success feedback
            showCopySuccess();
            
            // Analytics tracking (if needed)
            
        } catch (err) {
            console.error('Failed to copy text: ', err);
            // Fallback method
            linkToCopy.select();
            document.execCommand('copy');
            showCopySuccess();
        }
    });
    
    // Show copy success notification
    function showCopySuccess() {
        // Update button text temporarily
        const originalHTML = copyButton.innerHTML;
        copyButton.innerHTML = '<i class="fas fa-check mr-2"></i>কপি হয়েছে!';
        copyButton.classList.add('success-animation');
        
        // Show floating notification
        copyNotification.classList.add('show');
        
        // Reset after delay
        setTimeout(() => {
            copyButton.innerHTML = originalHTML;
            copyButton.classList.remove('success-animation');
            copyNotification.classList.remove('show');
        }, 2000);
    }
    
    // Social media button click tracking
    socialButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const platform = this.classList.contains('facebook-btn') ? 'Facebook' :
                           this.classList.contains('linkedin-btn') ? 'LinkedIn' :
                           this.classList.contains('twitter-btn') ? 'Twitter' :
                           this.classList.contains('messenger-btn') ? 'Messenger' :
                           this.classList.contains('whatsapp-btn') ? 'WhatsApp' :
                           this.classList.contains('telegram-btn') ? 'Telegram' : 'Unknown';
            
            
            // Add success animation
            this.classList.add('success-animation');
            setTimeout(() => {
                this.classList.remove('success-animation');
            }, 600);
            
            // Show notification
            showNotification(`কোর্সটি ${platform} এ শেয়ার করা হচ্ছে...`, 'info');
        });
    });
    
    // Auto-select link on focus
    linkToCopy.addEventListener('focus', function() {
        this.select();
    });
    
    // Prevent manual editing of the link
    linkToCopy.addEventListener('keydown', function(e) {
        // Allow Ctrl+A, Ctrl+C, but prevent other modifications
        if (!((e.ctrlKey || e.metaKey) && (e.key === 'a' || e.key === 'c' || e.key === 'A' || e.key === 'C'))) {
            if (e.key !== 'Tab' && e.key !== 'Escape') {
                e.preventDefault();
            }
        }
    });
    
    // Page completion celebration
    setTimeout(() => {
        const completionMessage = document.querySelector('.success-animation');
        if (completionMessage) {
            completionMessage.style.animationDelay = '0.5s';
        }
    }, 1000);
    
    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg text-white font-medium shadow-lg transform translate-x-full transition-transform duration-300`;
        
        // Set background based on type
        const backgrounds = {
            success: 'bg-gradient-to-r from-green-500 to-green-400',
            error: 'bg-gradient-to-r from-red-500 to-red-400', 
            info: 'bg-gradient-to-r from-blue-500 to-blue-400'
        };
        
        notification.classList.add(backgrounds[type] || backgrounds.info);
        
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            info: 'info-circle'
        };
        
        const icon = icons[type] || icons.info;
        notification.innerHTML = `<i class="fas fa-${icon} mr-2"></i>${message}`;
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        
        // Hide and remove notification
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
    
    // Show completion message
    showNotification('অভিনন্দন! আপনার কোর্স তৈরি সম্পন্ন হয়েছে!', 'success');
    
});
</script>
@endsection
