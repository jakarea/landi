<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI for Advertising Bootcamp 2025 - Rouf Razu</title>
    <meta name="description" content="এডভার্টাইজিংয়ের পুরোনো বইয়ের পাতা উল্টাও। নতুন যুগ শুরুর সময় এখন। Rouf Razu এর সাথে AI শিখুন।">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Kalpurush&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #f59e0b;
            --dark-bg: #0f0f23;
            --card-bg: rgba(255, 255, 255, 0.1);
            --text-light: #e2e8f0;
            --text-dark: #1e293b;
            --gradient-primary: linear-gradient(135deg, #6366f1, #8b5cf6);
            --gradient-secondary: linear-gradient(135deg, #f59e0b, #ef4444);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Kalpurush', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        .bangla-text {
            font-family: 'Kalpurush', sans-serif;
        }

        .hero-section {
            background: var(--dark-bg);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

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

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 100px 0;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: #cbd5e1;
            margin-bottom: 2.5rem;
            line-height: 1.5;
        }

        .cta-button {
            background: var(--gradient-primary);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .mentor-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            text-align: center;
        }

        .shift-section {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
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
        }

        .community-section {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
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

        .final-cta {
            background: var(--dark-bg);
            color: var(--text-light);
            text-align: center;
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

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .split-container {
                grid-template-columns: 1fr;
            }
            
            .hero-content {
                padding: 50px 0;
            }
            
            .section-padding {
                padding: 50px 0;
            }
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
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="particles"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="hero-title bangla-text">
                        এডভার্টাইজিংয়ের পুরোনো বইয়ের পাতা উল্টাও। নতুন যুগ শুরুর সময় এখন।
                    </h1>
                    <p class="hero-subtitle bangla-text">
                        যেখানে AI না জানাটাই হবে তোমার সবচেয়ে বড় weakness, সেখানে Rouf Razu এর হাত ধরে AI তোমাকে করবে industry-এর সবচেয়ে valuable player।
                    </p>
                    <a href="#enroll" class="cta-button bangla-text">
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

    <!-- The Shift Section -->
    <section class="shift-section section-padding">
        <div class="container">
            <h2 class="section-title bangla-text">
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
                    <h3 class="bangla-text mb-4">এখন</h3>
                    <p class="bangla-text">
                        <strong>আজকে, AI তোমার হয়ে করতে পারে ১০০ ad copy, ৫০টা image idea, আর ১০টা video script... সময় নিতে পারে মাত্র ১০ minute!</strong>
                    </p>
                    <p class="bangla-text mt-3">
                        যে এই technology harness করতে পারছে, সে-ই দিচ্ছে industry-তে domination pack। আর যে পারছে না, সে slowly কিন্তু surely becoming irrelevant।
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mentor Section -->
    <section class="mentor-section section-padding">
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
            <h2 class="section-title bangla-text">
                ৪টি Live Session, ১টি Transformed You
            </h2>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="session-card">
                        <div class="session-icon">
                            🥷
                        </div>
                        <h4 class="bangla-text">সেশন ১: Prompt Ninja হওয়ার প্রতারণা!</h4>
                        <p class="bangla-text">Text & Image AI-র fullest utilization</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="session-card">
                        <div class="session-icon">
                            🎬
                        </div>
                        <h4 class="bangla-text">সেশন ২: AI দিয়ে Viral Video Content বানানো</h4>
                        <p class="bangla-text">Idea থেকে Final Cut পর্যন্ত</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="session-card">
                        <div class="session-icon">
                            🤝
                        </div>
                        <h4 class="bangla-text">সেশন ৩: Real-World Campaign</h4>
                        <p class="bangla-text">Strategy, Execution, এবং Client Presentation</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="session-card">
                        <div class="session-icon">
                            ⛰️
                        </div>
                        <h4 class="bangla-text">সেশন ৪: ক্যারিয়ার কিকস্টার্ট</h4>
                        <p class="bangla-text">Freelancing, Agency Job, কিংবা Own Agency খোলা</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section class="community-section section-padding">
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
            <h2 class="section-title bangla-text">
                AI না শিখে যে Marketers, তারা আগামী ২ বছরেই হবে outdated
            </h2>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="opportunity-ladder">
                        <div class="ladder-item">
                            <h5>Head of Marketing</h5>
                            <p>AI-Powered Strategy Leader</p>
                        </div>
                        <div class="ladder-item">
                            <h5>Campaign Manager</h5>
                            <p>Multi-Platform AI Expert</p>
                        </div>
                        <div class="ladder-item">
                            <h5>AI Specialist</h5>
                            <p>Content & Automation Pro</p>
                        </div>
                        <div class="ladder-item">
                            <h5>Junior Marketer</h5>
                            <p>You Are Here 👆</p>
                        </div>
                        
                        <div class="mt-4">
                            <p class="bangla-text">
                                Companies aggressively খুঁজছে ঐগুলো marketers আমরা যারা AI-কে leverage করতে পারে। এই skillটা এখনই learn করা মানেই হল নিজের market value-কে ২x, ৩x এমনকি ৫x করে নেওয়া।
                            </p>
                            <p class="bangla-text">
                                <strong>এই বুটক্যাম্প তোমাকে দিয়ে দিবে সেই lethal weapon, যা দিয়ে তুমি demand করতে পারবে higher salary, land করতে পারবে better clients, এবং build করতে পারবে future-proof career।</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="final-cta section-padding" id="enroll">
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
                    
                    <a href="#" class="cta-button bangla-text mb-4">
                        🔥 আমি Creator হতেই Ready!
                    </a>
                    
                    <p class="bangla-text mt-3">
                        <small>এনরোল করতেই পারবে সহজে। bKash, Nagad, বা Rocket - যেভাবে ইচ্ছা payment done!</small>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scrolling -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all sections for animation
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });

        // Hero section should be visible immediately
        document.querySelector('.hero-section').style.opacity = '1';
        document.querySelector('.hero-section').style.transform = 'translateY(0)';
    </script>
</body>
</html>