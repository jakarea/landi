@extends('layouts.guest')
@section('title', 'AI for Advertising Bootcamp \'25 - Rouf Razu এর সাথে Future-Proof Your Career')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Kalpurush&display=swap" rel="stylesheet">
<style>
/* AI for Advertising Bootcamp '25 Brand Styles */
:root {
    --primary-color: #6366f1;
    --secondary-color: #f59e0b;
    --dark-bg: #0f0f23;
    --card-bg: rgba(255, 255, 255, 0.1);
    --text-light: #e2e8f0;
    --text-dark: #1e293b;
    --gradient-primary: linear-gradient(135deg, #6366f1, #8b5cf6);
    --gradient-secondary: linear-gradient(135deg, #f59e0b, #ef4444);
    --primary-navy: #0F172A;
    --primary-text: #FFFFFF;
    --accent-cyan: #00D4FF;
    --accent-teal: #2DD4BF;
    --secondary-bg: #F1F5F9;
    --glass-bg: rgba(255, 255, 255, 0.15);
    --glass-border: rgba(255, 255, 255, 0.2);
    --shadow: 0 8px 32px rgba(0, 212, 255, 0.3);
}

* {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

.bangla-text {
    font-family: 'Kalpurush', sans-serif;
}

body {
    background: var(--dark-bg);
    color: var(--primary-text);
    overflow-x: hidden;
    margin: 0;
    padding: 0;
}

/* Particles Animation */
.particles {
    position: absolute;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="80" cy="40" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="40" cy="80" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="70" cy="70" r="1" fill="%236366f1" opacity="0.2"/></svg>') repeat;
    animation: float 20s linear infinite;
}

@keyframes float {
    0% { transform: translateY(0px) translateX(0px); }
    50% { transform: translateY(-10px) translateX(5px); }
    100% { transform: translateY(0px) translateX(0px); }
}

/* Hero Section */
.hero-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    padding: 120px 0;
    background: var(--dark-bg);
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 50%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(45, 212, 191, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

.ai-badge {
    display: inline-block;
    background: var(--gradient-primary);
    color: var(--primary-navy);
    padding: 8px 24px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
    margin-bottom: 2rem;
    text-transform: uppercase;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    color: var(--primary-text);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-title .gradient-text {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: var(--primary-text);
    margin-bottom: 1rem;
    line-height: 1.6;
    opacity: 0.9;
}

.hero-tagline {
    font-size: 1.1rem;
    color: var(--accent-cyan);
    margin-bottom: 3rem;
    font-weight: 600;
}

.cta-button-primary {
    background: var(--accent-cyan);
    border: none;
    border-radius: 8px;
    padding: 18px 36px;
    color: var(--primary-navy);
    font-size: 1.1rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    margin-right: 1rem;
    margin-bottom: 1rem;
}

.cta-button-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
    color: var(--primary-navy);
}

.cta-button-secondary {
    background: transparent;
    border: 2px solid var(--accent-teal);
    border-radius: 8px;
    padding: 16px 34px;
    color: var(--accent-teal);
    font-size: 1.1rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.cta-button-secondary:hover {
    background: var(--accent-teal);
    color: var(--primary-navy);
    transform: translateY(-2px);
}

/* Features Section */
.features-section {
    padding: 120px 0;
    position: relative;
}

.section-header {
    text-align: center;
    margin-bottom: 5rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-text);
    margin-bottom: 1.5rem;
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--primary-text);
    opacity: 0.8;
    max-width: 600px;
    margin: 0 auto;
}

.feature-card {
    background: var(--secondary-bg);
    border-radius: 12px;
    padding: 2.5rem;
    height: 100%;
    transition: all 0.3s ease;
    text-align: left;
    border: 1px solid rgba(0, 212, 255, 0.1);
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 212, 255, 0.2);
    border-color: var(--accent-cyan);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: var(--gradient-primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    color: var(--primary-navy);
    font-size: 1.5rem;
}

.feature-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--primary-navy);
    margin-bottom: 1rem;
}

.feature-description {
    color: var(--primary-navy);
    line-height: 1.6;
    opacity: 0.8;
}

/* Value Proposition Section */
.value-section {
    padding: 120px 0;
    background: rgba(0, 212, 255, 0.05);
    text-align: center;
}

.value-card {
    background: var(--secondary-bg);
    border-radius: 16px;
    padding: 3rem;
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid var(--accent-cyan);
}

.value-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-navy);
    margin-bottom: 2rem;
}

.value-highlight {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}

/* CTA Section */
.cta-section {
    padding: 120px 0;
    text-align: center;
    background: var(--primary-navy);
}

.cta-card {
    background: var(--secondary-bg);
    border-radius: 20px;
    padding: 4rem 2rem;
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid var(--accent-teal);
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-navy);
    margin-bottom: 1.5rem;
}

.cta-subtitle {
    font-size: 1.2rem;
    color: var(--primary-navy);
    margin-bottom: 3rem;
    opacity: 0.8;
}

/* Key Messaging */
.buzzwords {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin: 2rem 0;
}

.buzzword {
    background: var(--gradient-primary);
    color: var(--primary-navy);
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .feature-card {
        padding: 2rem;
    }
    
    .value-card, .cta-card {
        padding: 2rem;
        margin: 0 1rem;
    }
}

/* Animation */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.floating {
    animation: float 6s ease-in-out infinite;
}

/* Additional styles for merged content */
.mentor-image {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
}

.shift-section {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    padding: 100px 0;
}

.split-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    min-height: 500px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.split-left {
    background: linear-gradient(45deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800') center/cover;
    padding: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white;
    position: relative;
}

.split-right {
    background: linear-gradient(45deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)),
                url('https://images.unsplash.com/photo-1551650975-87deedd944c3?w=800') center/cover;
    padding: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.session-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    margin: 20px 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.session-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
    border-color: var(--primary-color);
}

.session-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-bottom: 20px;
}

.mentor-section {
    background: var(--dark-bg);
    color: var(--text-light);
    padding: 100px 0;
}

.community-section {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    padding: 100px 0;
}

.opportunity-ladder {
    background: white;
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.ladder-item {
    padding: 20px;
    margin: 20px 0;
    background: var(--gradient-primary);
    color: white;
    border-radius: 15px;
    position: relative;
    transform: scale(1);
    transition: all 0.3s ease;
}

.ladder-item:hover {
    transform: scale(1.05);
}

.ladder-item:first-child {
    background: var(--gradient-secondary);
}

.final-cta-section {
    background: var(--dark-bg);
    color: var(--text-light);
    text-align: center;
    padding: 100px 0;
}

.price-highlight {
    font-size: 3rem;
    font-weight: 800;
    color: var(--secondary-color);
    margin: 20px 0;
}

.feature-list {
    list-style: none;
    padding: 0;
}

.feature-list li {
    padding: 15px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    padding-left: 40px;
}

.feature-list li:before {
    content: "✨";
    position: absolute;
    left: 0;
    top: 15px;
}

.testimonial-quote {
    font-size: 1.5rem;
    font-style: italic;
    text-align: center;
    margin: 40px 0;
    padding: 30px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
}

@media (max-width: 768px) {
    .split-container {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="particles"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="ai-badge">Rouf Razu</div>
                <h1 class="hero-title bangla-text">
                    এডভার্টাইজিংয়ের পুরোনো বইয়ের পাতা উল্টাও। <span class="gradient-text">নতুন যুগ</span> শুরুর সময় এখন।
                </h1>
                <p class="hero-subtitle bangla-text">
                    যেখানে AI না জানাটাই হবে তোমার সবচেয়ে বড় weakness, সেখানে Rouf Razu এর হাত ধরে AI তোমাকে করবে industry-এর সবচেয়ে valuable player।
                </p>
                
                <div class="buzzwords">
                    <span class="buzzword bangla-text">৪টি Live Session</span>
                    <span class="buzzword bangla-text">Lifetime Access</span>
                    <span class="buzzword bangla-text">Community Access</span>
                    <span class="buzzword bangla-text">Prompt Library</span>
                    <span class="buzzword bangla-text">Certificate</span>
                </div>

                <div class="mt-4">
                    @guest
                        <a href="#enroll" class="cta-button-primary bangla-text">
                            🚀 ফিউচারের এজেন্ট হওয়ার জার্নি শুরু কর!
                        </a>
                        <a href="{{ route('login') }}" class="cta-button-secondary bangla-text">
                            আরো জানুন
                        </a>
                    @else
                        @if(auth()->user()->user_role === 'student')
                            <a href="{{ route('students.dashboard') }}" class="cta-button-primary">
                                My Dashboard
                            </a>
                        @else
                            <a href="{{ route('instructor.dashboard') }}" class="cta-button-primary">
                                Instructor Dashboard
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
            <div class="col-lg-5">
                <div class="mentor-image">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=600&fit=crop&crop=face" 
                         alt="Rouf Razu" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Shift Section -->
<section class="shift-section">
    <div class="container">
        <h2 class="section-title bangla-text text-dark text-center">
            সেই সময় গেছে যখন একটা ad copy লিখতে ৩ দিন সময় দিতে হত।
        </h2>
        
        <div class="split-container">
            <div class="split-left">
                <h3 class="bangla-text mb-4">তখন</h3>
                <p class="bangla-text">
                    একটা সময় ছিল যখন "Creativity" মানে ছিল ঘণ্টার পর ঘণ্টা brain storming, client-এর endless feedback আর campaign launch করতে করতে weeks পার হয়ে যাওয়া।
                </p>
            </div>
            <div class="split-right">
                <h3 class="bangla-text mb-4" style="color: #1e293b;">এখন</h3>
                <p class="bangla-text" style="color: #1e293b;">
                    <strong>আজকে, AI তোমার হয়ে করতে পারে ১০০ ad copy, ৫০টা image idea, আর ১০টা video script... সময় নিতে পারে মাত্র ১০ minute!</strong>
                </p>
                <p class="bangla-text mt-3" style="color: #1e293b;">
                    যে এই technology harness করতে পারছে, সে-ই দিচ্ছে industry-তে domination pack। আর যে পারছে না, সে slowly কিন্তু surely becoming irrelevant।
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Mentor Section -->
<section class="mentor-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title bangla-text text-start">
                    কোনো theoretical guru নন, তোমার mentor হবেন Rouf Razu
                </h2>
                <p class="bangla-text mb-4">
                    তিনি কেবল theory পড়ান না। তিনি battlefield-এর soldier। তিনি নিজের হাতে তৈরি করেছেন AI content, যা জয় করেছে million+ views। তিনি GP, Samsung, Daraz-এর মতো giants brands-কে AI-powered campaign দিয়ে সাহায্য করেছেন their competition থেকে miles ahead থাকতে।
                </p>
                <p class="bangla-text">
                    <strong>এই বুটক্যাম্পে তিনি শেখাবেন তাঁর ৭+ বছরের যুদ্ধ experience-এর condensed version। শেখাবেন real client-এর জন্য কাজে লাগানোর magic formula।</strong>
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=300&h=200&fit=crop" 
                             alt="Campaign Success" class="img-fluid rounded-3">
                    </div>
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=300&h=200&fit=crop" 
                             alt="Speaking Engagement" class="img-fluid rounded-3">
                    </div>
                    <div class="col-12">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=200&fit=crop" 
                             alt="Workshop" class="img-fluid rounded-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blueprint Section -->
<section class="section-padding">
    <div class="container">
        <h2 class="section-title bangla-text text-center" style="color: #1e293b;">
            ৪টি Live Session, ১টি Transformed You
        </h2>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        🥷
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ১: Prompt Ninja হওয়ার প্রতারণা!</h4>
                    <p class="bangla-text" style="color: #64748b;">Text & Image AI-র fullest utilization</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        🎬
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ২: AI দিয়ে Viral Video Content বানানো</h4>
                    <p class="bangla-text" style="color: #64748b;">Idea থেকে Final Cut পর্যন্ত</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        🤝
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ৩: Real-World Campaign</h4>
                    <p class="bangla-text" style="color: #64748b;">Strategy, Execution, এবং Client Presentation</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        ⛰️
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ৪: ক্যারিয়ার কিকস্টার্ট</h4>
                    <p class="bangla-text" style="color: #64748b;">Freelancing, Agency Job, কিংবা Own Agency খোলা</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community Section -->
<section class="community-section">
    <div class="container text-center">
        <h2 class="section-title bangla-text">
            তুমি শুধু একটা course করছ না, join করছ একটা movement
        </h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=400&fit=crop" 
                     alt="Community" class="img-fluid rounded-3 mb-4">
                <p class="bangla-text lead">
                    এই বুটক্যাম্পের সবচেয়ে powerful জিনিসটা হচ্ছে community। এখানে তোমার মতোই future-focused marketers-দের সাথে connect করতে পারবে। পারবে collaboration করতে, idea share করতে, job opportunity পেতে।
                </p>
                <p class="bangla-text">
                    <strong>এই network তোমার ক্যারিয়ারে priceless value দিবে, আজীবন।</strong>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Opportunity Section -->
<section class="section-padding">
    <div class="container">
        <h2 class="section-title bangla-text text-center" style="color: #1e293b;">
            AI না শিখে যে Marketers, তারা আগামী ২ বছরেই হবে outdated
        </h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="opportunity-ladder">
                    <div class="ladder-item">
                        <h5 class="bangla-text">Head of Marketing</h5>
                        <p>AI-Powered Strategy Leader</p>
                    </div>
                    <div class="ladder-item">
                        <h5 class="bangla-text">Campaign Manager</h5>
                        <p>Multi-Platform AI Expert</p>
                    </div>
                    <div class="ladder-item">
                        <h5 class="bangla-text">AI Specialist</h5>
                        <p>Content & Automation Pro</p>
                    </div>
                    <div class="ladder-item">
                        <h5 class="bangla-text">Junior Marketer</h5>
                        <p>You Are Here 👆</p>
                    </div>
                    
                    <div class="mt-4">
                        <p class="bangla-text" style="color: #1e293b;">
                            Companies aggressively খুঁজছে ঐগুলো marketers আমরা যারা AI-কে leverage করতে পারে। এই skillটা এখনই learn করা মানেই হল নিজের market value-কে ২x, ৩x এমনকি ৫x করে নেওয়া।
                        </p>
                        <p class="bangla-text" style="color: #1e293b;">
                            <strong>এই বুটক্যাম্প তোমাকে দিয়ে দিবে সেই lethal weapon, যা দিয়ে তুমি demand করতে পারবে higher salary, land করতে পারবে better clients, এবং build করতে পারবে future-proof career।</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="final-cta-section" id="enroll">
    <div class="container text-center">
        <div class="testimonial-quote bangla-text">
            "তোমার হাতেই এখন choice টা: Spectator হও, নাকি Creator?"
        </div>
        
        <h2 class="section-title bangla-text">
            তোমার হাতেই এখন choiceটা: Spectator হও, নাকি Creator?
        </h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <ul class="feature-list bangla-text text-start">
                    <li>৪টি Power-Packed Live Session</li>
                    <li>Lifetime Access to Recordings</li>
                    <li>Exclusive Community Access</li>
                    <li>Personal Prompt Library & Certificate</li>
                </ul>
                
                <div class="price-highlight bangla-text">
                    এক্সclusive Early Bird Prize: <span style="color: var(--secondary-color);">৳ ৩,০০০ টাকা</span>
                </div>
                <p class="bangla-text mb-4">(সীমিত সিট)</p>
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="cta-button-primary bangla-text">
                            🔥 আমি Creator হতেই Ready!
                        </a>
                        <a href="{{ route('login') }}" class="cta-button-secondary bangla-text">
                            আরো জানুন
                        </a>
                    @else
                        @if(auth()->user()->user_role === 'student')
                            <a href="{{ route('students.dashboard') }}" class="cta-button-primary bangla-text">
                                🔥 আমি Creator হতেই Ready!
                            </a>
                        @else
                            <a href="{{ route('instructor.dashboard') }}" class="cta-button-primary bangla-text">
                                Instructor Dashboard
                            </a>
                        @endif
                    @endguest
                </div>
                
                <p class="bangla-text mt-3">
                    <small>এনরোল করতেই পারবে সহজে। bKash, Nagad, বা Rocket - যেভাবে ইচ্ছা payment done!</small>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Additional AI Bootcamp Specific Sections -->

<!-- Rouf Razu Hero Section -->
<section class="hero-section">
    <div class="particles"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title bangla-text">
                    এডভার্টাইজিংয়ের পুরোনো বইয়ের পাতা উল্টাও। নতুন যুগ শুরুর সময় এখন।
                </h1>
                <p class="hero-subtitle bangla-text">
                    যেখানে AI না জানাটাই হবে তোমার সবচেয়ে বড় weakness, সেখানে Rouf Razu এর হাত ধরে AI তোমাকে করবে industry-এর সবচেয়ে valuable player।
                </p>
                <a href="#rouf-enroll" class="cta-button-primary bangla-text">
                    🚀 ফিউচারের এজেন্ট হওয়ার জার্নি শুরু কর!
                </a>
            </div>
            <div class="col-lg-5">
                <div class="mentor-image">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=600&fit=crop&crop=face" 
                         alt="Rouf Razu" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Shift: Then vs Now Section -->
<section class="shift-section section-padding">
    <div class="container">
        <h2 class="section-title bangla-text" style="color: var(--text-dark);">
            সেই সময় গেছে যখন একটা ad copy লিখতে ৩ দিন সময় দিতে হত।
        </h2>
        
        <div class="split-container">
            <div class="split-left">
                <h3 class="bangla-text mb-4">তখন</h3>
                <p class="bangla-text">
                    একটা সময় ছিল যখন "Creativity" মানে ছিল ঘণ্টার পর ঘণ্টা brain storming, client-এর endless feedback আর campaign launch করতে করতে weeks পার হয়ে যাওয়া।
                </p>
            </div>
            <div class="split-right">
                <h3 class="bangla-text mb-4" style="color: #1e293b;">এখন</h3>
                <p class="bangla-text" style="color: #1e293b;">
                    <strong>আজকে, AI তোমার হয়ে করতে পারে ১০০ ad copy, ৫০টা image idea, আর ১০টা video script... সময় নিতে পারে মাত্র ১০ minute!</strong>
                </p>
                <p class="bangla-text mt-3" style="color: #1e293b;">
                    যে এই technology harness করতে পারছে, সে-ই দিচ্ছে industry-তে domination pack। আর যে পারছে না, সে slowly কিন্তু surely becoming irrelevant।
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Rouf Razu Mentor Credibility Section -->
<section class="mentor-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title bangla-text text-start">
                    কোনো theoretical guru নন, তোমার mentor হবেন Rouf Razu
                </h2>
                <p class="bangla-text mb-4">
                    তিনি কেবল theory পড়ান না। তিনি battlefield-এর soldier। তিনি নিজের হাতে তৈরি করেছেন AI content, যা জয় করেছে million+ views। তিনি GP, Samsung, Daraz-এর মতো giants brands-কে AI-powered campaign দিয়ে সাহায্য করেছেন their competition থেকে miles ahead থাকতে।
                </p>
                <p class="bangla-text">
                    <strong>এই বুটক্যাম্পে তিনি শেখাবেন তাঁর ৭+ বছরের যুদ্ধ experience-এর condensed version। শেখাবেন real client-এর জন্য কাজে লাগানোর magic formula।</strong>
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=300&h=200&fit=crop" 
                             alt="Campaign Success" class="img-fluid rounded-3">
                    </div>
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=300&h=200&fit=crop" 
                             alt="Speaking Engagement" class="img-fluid rounded-3">
                    </div>
                    <div class="col-12">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=200&fit=crop" 
                             alt="Workshop" class="img-fluid rounded-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4 Live Sessions Blueprint -->
<section class="section-padding" style="background: #f8fafc;">
    <div class="container">
        <h2 class="section-title bangla-text" style="color: var(--text-dark);">
            ৪টি Live Session, ১টি Transformed You
        </h2>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        🥷
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ১: Prompt Ninja হওয়ার প্রতারণা!</h4>
                    <p class="bangla-text" style="color: #64748b;">Text & Image AI-র fullest utilization</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        🎬
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ২: AI দিয়ে Viral Video Content বানানো</h4>
                    <p class="bangla-text" style="color: #64748b;">Idea থেকে Final Cut পর্যন্ত</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        🤝
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ৩: Real-World Campaign</h4>
                    <p class="bangla-text" style="color: #64748b;">Strategy, Execution, এবং Client Presentation</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="session-card">
                    <div class="session-icon">
                        ⛰️
                    </div>
                    <h4 class="bangla-text" style="color: #1e293b;">সেশন ৪: ক্যারিয়ার কিকস্টার্ট</h4>
                    <p class="bangla-text" style="color: #64748b;">Freelancing, Agency Job, কিংবা Own Agency খোলা</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community Movement Section -->
<section class="community-section">
    <div class="container text-center">
        <h2 class="section-title bangla-text">
            তুমি শুধু একটা course করছ না, join করছ একটা movement
        </h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=400&fit=crop" 
                     alt="Community" class="img-fluid rounded-3 mb-4">
                <p class="bangla-text lead">
                    এই বুটক্যাম্পের সবচেয়ে powerful জিনিসটা হচ্ছে community। এখানে তোমার মতোই future-focused marketers-দের সাথে connect করতে পারবে। পারবে collaboration করতে, idea share করতে, job opportunity পেতে।
                </p>
                <p class="bangla-text">
                    <strong>এই network তোমার ক্যারিয়ারে priceless value দিবে, আজীবন।</strong>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Career Opportunity Ladder -->
<section class="section-padding" style="background: #f1f5f9;">
    <div class="container">
        <h2 class="section-title bangla-text" style="color: var(--text-dark);">
            AI না শিখে যে Marketers, তারা আগামী ২ বছরেই হবে outdated
        </h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="opportunity-ladder">
                    <div class="ladder-item">
                        <h5 class="bangla-text">Head of Marketing</h5>
                        <p>AI-Powered Strategy Leader</p>
                    </div>
                    <div class="ladder-item">
                        <h5 class="bangla-text">Campaign Manager</h5>
                        <p>Multi-Platform AI Expert</p>
                    </div>
                    <div class="ladder-item">
                        <h5 class="bangla-text">AI Specialist</h5>
                        <p>Content & Automation Pro</p>
                    </div>
                    <div class="ladder-item">
                        <h5 class="bangla-text">Junior Marketer</h5>
                        <p>You Are Here 👆</p>
                    </div>
                    
                    <div class="mt-4">
                        <p class="bangla-text" style="color: #1e293b;">
                            Companies aggressively খুঁজছে ঐগুলো marketers আমরা যারা AI-কে leverage করতে পারে। এই skillটা এখনই learn করা মানেই হল নিজের market value-কে ২x, ৩x এমনকি ৫x করে নেওয়া।
                        </p>
                        <p class="bangla-text" style="color: #1e293b;">
                            <strong>এই বুটক্যাম্প তোমাকে দিয়ে দিবে সেই lethal weapon, যা দিয়ে তুমি demand করতে পারবে higher salary, land করতে পারবে better clients, এবং build করতে পারবে future-proof career।</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rouf Razu Final CTA with Pricing -->
<section class="final-cta-section" id="rouf-enroll">
    <div class="container text-center">
        <div class="testimonial-quote bangla-text">
            "তোমার হাতেই এখন choice টা: Spectator হও, নাকি Creator?"
        </div>
        
        <h2 class="section-title bangla-text">
            Ready to Transform with Rouf Razu's AI Bootcamp?
        </h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <ul class="feature-list bangla-text text-start">
                    <li>৪টি Power-Packed Live Session with Rouf Razu</li>
                    <li>Lifetime Access to All Recordings</li>
                    <li>Exclusive Community Access</li>
                    <li>Personal AI Prompt Library</li>
                    <li>Certificate of Completion</li>
                </ul>
                
                <div class="price-highlight bangla-text">
                    এক্সclusive Early Bird Prize: <span style="color: var(--secondary-color);">৳ ৩,০০০ টাকা</span>
                </div>
                <p class="bangla-text mb-4">(সীমিত সিট - Limited Seats)</p>
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="cta-button-primary bangla-text">
                            🔥 আমি Creator হতেই Ready!
                        </a>
                        <a href="{{ route('login') }}" class="cta-button-secondary bangla-text">
                            আরো জানুন
                        </a>
                    @else
                        @if(auth()->user()->user_role === 'student')
                            <a href="{{ route('students.dashboard') }}" class="cta-button-primary bangla-text">
                                🔥 Enroll in Bootcamp!
                            </a>
                        @else
                            <a href="{{ route('instructor.dashboard') }}" class="cta-button-primary bangla-text">
                                Instructor Dashboard
                            </a>
                        @endif
                    @endguest
                </div>
                
                <p class="bangla-text mt-3">
                    <small>এনরোল করতেই পারবে সহজে। bKash, Nagad, বা Rocket - যেভাবে ইচ্ছা payment done!</small>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
// AI for Advertising Bootcamp '25 - Modern interactions
document.addEventListener('DOMContentLoaded', function() {
    // Animate feature cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, observerOptions);

    // Observe all feature cards with stagger effect
    document.querySelectorAll('.feature-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(card);
    });

    // Animate value card
    const valueCard = document.querySelector('.value-card');
    if (valueCard) {
        valueCard.style.opacity = '0';
        valueCard.style.transform = 'scale(0.95)';
        valueCard.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        
        const valueObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'scale(1)';
                }
            });
        }, { threshold: 0.2 });
        
        valueObserver.observe(valueCard);
    }

    // Add hover effects for CTA buttons
    document.querySelectorAll('.cta-button-primary, .cta-button-secondary').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add subtle parallax effect to hero background
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            const speed = scrolled * 0.5;
            heroSection.style.transform = `translateY(${speed}px)`;
        }
    });

    // Animate buzzwords on load
    const buzzwords = document.querySelectorAll('.buzzword');
    buzzwords.forEach((word, index) => {
        word.style.opacity = '0';
        word.style.transform = 'translateX(-20px)';
        word.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
        
        setTimeout(() => {
            word.style.opacity = '1';
            word.style.transform = 'translateX(0)';
        }, 500 + (index * 100));
    });

    // Add gradient animation to AI badge
    const aiBadge = document.querySelector('.ai-badge');
    if (aiBadge) {
        setInterval(() => {
            aiBadge.style.backgroundPosition = aiBadge.style.backgroundPosition === '100% 0' ? '0% 0' : '100% 0';
        }, 3000);
    }
});
</script>
@endsection