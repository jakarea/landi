@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - ধাপ ৩')
@section('header-title', 'কোর্সের মূল্য নির্ধারণ')
@section('header-subtitle', 'আপনার কোর্সের জন্য উপযুক্ত মূল্য নির্ধারণ করুন')

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

/* Pricing card styles */
.pricing-card {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 1px solid rgba(90, 234, 244, 0.3);
    border-radius: 1rem;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.pricing-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
}

.free-toggle-card {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(203, 251, 144, 0.3);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.free-toggle-card.active {
    border-color: #CBFB90;
    box-shadow: 0 0 20px rgba(203, 251, 144, 0.2);
}

/* Toggle switch styling */
.toggle-switch {
    position: relative;
    width: 60px;
    height: 32px;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.toggle-switch.active {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
}

.toggle-slider {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 28px;
    height: 28px;
    background-color: #FFFFFF;
    border-radius: 50%;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    color: #091D3D;
}

.toggle-switch.active .toggle-slider {
    transform: translateX(28px);
}

/* Form styling */
.form-group-pricing {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-input-pricing {
    width: 100%;
    padding: 1rem 3rem 1rem 1rem;
    background-color: #091D3D;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    color: #FFFFFF;
    font-size: 1.125rem;
    font-weight: 600;
    transition: all 0.3s ease;
    outline: none;
}

.form-input-pricing:focus {
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.form-input-pricing:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: rgba(9, 29, 61, 0.5);
}

.currency-symbol {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #5AEAF4;
    font-size: 1.25rem;
    font-weight: 700;
    pointer-events: none;
}

.form-label-pricing {
    display: block;
    color: #FFFFFF;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Price calculator display */
.price-summary {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 1px solid rgba(90, 234, 244, 0.2);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.price-row:last-child {
    border-bottom: none;
    margin-top: 0.5rem;
    padding-top: 1rem;
    border-top: 2px solid rgba(90, 234, 244, 0.3);
}

.price-label {
    color: #C7C7C7;
    font-size: 0.875rem;
}

.price-value {
    color: #FFFFFF;
    font-weight: 600;
    font-size: 1rem;
}

.price-final {
    color: #5AEAF4 !important;
    font-size: 1.25rem !important;
    font-weight: 700 !important;
}

.discount-badge {
    background: linear-gradient(135deg, #10B981, #34D399);
    color: #FFFFFF;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
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

.btn-next {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border: none;
    color: #091D3D;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.btn-next:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Error styling */
.error-alert {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 2rem;
}

.error-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-list li {
    color: #FCA5A5;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.error-list li::before {
    content: '•';
    color: #EF4444;
    font-weight: bold;
    display: inline-block;
    width: 1rem;
}

/* Section titles */
.section-title {
    color: #FFFFFF;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #5AEAF4;
    font-size: 2rem;
}

/* Pricing options */
.pricing-options {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.pricing-option {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.pricing-option:hover {
    border-color: rgba(90, 234, 244, 0.3);
    box-shadow: 0 4px 12px rgba(90, 234, 244, 0.1);
}

.pricing-option.selected {
    border-color: #5AEAF4;
    box-shadow: 0 0 20px rgba(90, 234, 244, 0.2);
}

.pricing-option-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.pricing-option-title {
    color: #FFFFFF;
    font-size: 1.125rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pricing-option-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #091D3D;
    font-size: 0.875rem;
}

.pricing-option-description {
    color: #C7C7C7;
    font-size: 0.875rem;
    line-height: 1.5;
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
    .btn-next {
        width: 100%;
        justify-content: center;
    }
    
    .pricing-card {
        padding: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
    }
    
    .form-input-pricing {
        font-size: 1rem;
    }
}

/* Animation for price changes */
@keyframes priceUpdate {
    0% { opacity: 0.7; transform: scale(0.98); }
    50% { opacity: 0.9; transform: scale(1.02); }
    100% { opacity: 1; transform: scale(1); }
}

.price-animated {
    animation: priceUpdate 0.3s ease;
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
                    <a href="{{ route('instructor.courses.create.facts', ['id' => $course->id]) }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">2</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.objectives', ['id' => $course->id]) }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item current">
                <div class="step-circle">3</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.pricing', ['id' => $course->id]) }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">4</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.design', ['id' => $course->id]) }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">5</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.content', ['id' => $course->id]) }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.certificate', ['id' => $course->id]) }}">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">7</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.visibility', ['id' => $course->id]) }}">দৃশ্যমানতা</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">8</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.publish', ['id' => $course->id]) }}">প্রকাশ</a>
                </div>
            </div>
        </div>

        @if ( session()->has('course_id') )
            <div class="text-center mt-6 pt-6 border-t border-[#fff]/20">
                <a href="{{ url('instructor/finish/edit') }}" 
                   class="inline-flex items-center gap-2 bg-lime text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-orange hover:text-primary">
                    <i class="fas fa-save"></i>
                    সংরক্ষণ করুন এবং সমাপ্ত করুন
                </a>
            </div>
        @endif
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="error-alert">
        <ul class="error-list">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Pricing Form -->
    <form action="" method="POST" id="pricingForm">
        @csrf
        
        <!-- Pricing Header -->
        <div class="bg-card rounded-xl shadow-2">
            <div class="p-8">
                <h2 class="section-title">
                    <i class="fas fa-tag"></i>
                    কোর্সের মূল্য নির্ধারণ করুন
                </h2>

                <!-- Free Course Toggle -->
                <div class="free-toggle-card {{ (old('is_free') || $course->price == 0) ? 'active' : '' }}" id="freeToggleCard">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-lime to-green-400 flex items-center justify-center">
                                    <i class="fas fa-gift text-primary text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg">বিনামূল্যে কোর্স</h3>
                                    <p class="text-secondary-200 text-sm">এই কোর্সটি সবার জন্য বিনামূল্যে উপলব্ধ করুন</p>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="toggle-switch {{ (old('is_free') || $course->price == 0) ? 'active' : '' }}" id="toggleSwitch">
                                <div class="toggle-slider">
                                    <i class="fas fa-gift"></i>
                                </div>
                            </div>
                            <input type="checkbox" name="is_free" id="freeCourseSwitch" class="hidden" {{ (old('is_free') || $course->price == 0) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <!-- Pricing Options -->
                <div class="pricing-options mt-6" id="pricingOptions" style="{{ (old('is_free') || $course->price == 0) ? 'display: none;' : '' }}">
                    <!-- Regular Pricing -->
                    <div class="pricing-card">
                        <div class="form-group-pricing">
                            <label for="price" class="form-label-pricing">
                                <i class="fas fa-money-bill-wave text-blue mr-2"></i>
                                নিয়মিত মূল্য
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    id="price" 
                                    name="price"
                                    class="form-input-pricing" 
                                    placeholder="০"
                                    value="{{ $course->price ? $course->price : old('price') }}"
                                    min="0"
                                    step="0.01">
                                <span class="currency-symbol">৳</span>
                            </div>
                            @error('price')
                                <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div class="text-secondary-200 text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                আপনার কোর্সের মূল মূল্য নির্ধারণ করুন
                            </div>
                        </div>

                        <div class="form-group-pricing">
                            <label for="offer_price" class="form-label-pricing">
                                <i class="fas fa-percent text-orange mr-2"></i>
                                বিশেষ ছাড়ের মূল্য (ঐচ্ছিক)
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    id="offer_price" 
                                    name="offer_price"
                                    class="form-input-pricing" 
                                    placeholder="০"
                                    value="{{ $course->offer_price ? $course->offer_price : old('offer_price') }}"
                                    min="0"
                                    step="0.01">
                                <span class="currency-symbol">৳</span>
                            </div>
                            @error('offer_price')
                                <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div class="text-secondary-200 text-sm mt-2">
                                <i class="fas fa-lightbulb mr-1"></i>
                                বিশেষ ছাড়ের মূল্য নিয়মিত মূল্যের চেয়ে কম হতে হবে
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="price-summary" id="priceSummary" style="{{ (old('is_free') || $course->price == 0) ? 'display: none;' : '' }}">
                    <h4 class="text-white font-semibold mb-4">
                        <i class="fas fa-calculator text-blue mr-2"></i>
                        মূল্য সারাংশ
                    </h4>
                    
                    <div class="price-row">
                        <span class="price-label">নিয়মিত মূল্য</span>
                        <span class="price-value" id="regularPriceDisplay">৳০</span>
                    </div>
                    
                    <div class="price-row" id="discountRow" style="display: none;">
                        <span class="price-label">বিশেষ ছাড়ের মূল্য</span>
                        <span class="price-value" id="offerPriceDisplay">৳০</span>
                    </div>
                    
                    <div class="price-row" id="savingsRow" style="display: none;">
                        <span class="price-label">সাশ্রয়</span>
                        <div class="flex items-center gap-2">
                            <span class="discount-badge" id="savingsAmount">৳০</span>
                            <span class="price-value" id="savingsPercentage">০%</span>
                        </div>
                    </div>
                    
                    <div class="price-row">
                        <span class="price-label text-lg">শিক্ষার্থীরা পরিশোধ করবে</span>
                        <span class="price-value price-final" id="finalPriceDisplay">৳০</span>
                    </div>
                </div>

                <!-- Free Course Message -->
                <div class="price-summary" id="freeCourseSummary" style="{{ (old('is_free') || $course->price == 0) ? '' : 'display: none;' }}">
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-gradient-to-r from-lime to-green-400 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-gift text-primary text-3xl"></i>
                        </div>
                        <h4 class="text-white font-semibold text-xl mb-2">বিনামূল্যে কোর্স</h4>
                        <p class="text-secondary-200">এই কোর্সটি সবার জন্য সম্পূর্ণ বিনামূল্যে উপলব্ধ থাকবে</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="action-buttons">
            <a href="{{ route('instructor.courses.create.objectives', ['id' => $course->id]) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                পূর্ববর্তী ধাপ
            </a>
            
            <button type="submit" class="btn-next" id="submitBtn">
                পরবর্তী ধাপ
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const freeCourseSwitch = document.getElementById('freeCourseSwitch');
    const toggleSwitch = document.getElementById('toggleSwitch');
    const freeToggleCard = document.getElementById('freeToggleCard');
    const pricingOptions = document.getElementById('pricingOptions');
    const priceSummary = document.getElementById('priceSummary');
    const freeCourseSummary = document.getElementById('freeCourseSummary');
    
    const priceInput = document.getElementById('price');
    const offerPriceInput = document.getElementById('offer_price');
    
    // Display elements
    const regularPriceDisplay = document.getElementById('regularPriceDisplay');
    const offerPriceDisplay = document.getElementById('offerPriceDisplay');
    const finalPriceDisplay = document.getElementById('finalPriceDisplay');
    const discountRow = document.getElementById('discountRow');
    const savingsRow = document.getElementById('savingsRow');
    const savingsAmount = document.getElementById('savingsAmount');
    const savingsPercentage = document.getElementById('savingsPercentage');
    
    const submitBtn = document.getElementById('submitBtn');

    // Toggle free course
    function toggleFreeMode(isFree) {
        freeCourseSwitch.checked = isFree;
        
        if (isFree) {
            toggleSwitch.classList.add('active');
            freeToggleCard.classList.add('active');
            pricingOptions.style.display = 'none';
            priceSummary.style.display = 'none';
            freeCourseSummary.style.display = 'block';
            
            // Reset price values
            priceInput.value = '0';
            offerPriceInput.value = '';
            
            // Add animation
            freeCourseSummary.style.opacity = '0';
            setTimeout(() => {
                freeCourseSummary.style.opacity = '1';
                freeCourseSummary.style.transition = 'opacity 0.3s ease';
            }, 100);
        } else {
            toggleSwitch.classList.remove('active');
            freeToggleCard.classList.remove('active');
            pricingOptions.style.display = 'block';
            priceSummary.style.display = 'block';
            freeCourseSummary.style.display = 'none';
            
            // Reset price if it was 0
            if (priceInput.value === '0') {
                priceInput.value = '';
            }
            
            updatePriceSummary();
        }
    }

    // Update price summary
    function updatePriceSummary() {
        const regularPrice = parseFloat(priceInput.value) || 0;
        const offerPrice = parseFloat(offerPriceInput.value) || 0;
        
        // Format currency
        const formatCurrency = (amount) => {
            return '৳' + amount.toLocaleString('bn-BD', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        };
        
        // Update regular price display
        regularPriceDisplay.textContent = formatCurrency(regularPrice);
        regularPriceDisplay.classList.add('price-animated');
        setTimeout(() => regularPriceDisplay.classList.remove('price-animated'), 300);
        
        if (offerPrice > 0 && offerPrice < regularPrice) {
            // Show discount information
            discountRow.style.display = 'flex';
            savingsRow.style.display = 'flex';
            
            offerPriceDisplay.textContent = formatCurrency(offerPrice);
            finalPriceDisplay.textContent = formatCurrency(offerPrice);
            
            const savings = regularPrice - offerPrice;
            const savingsPercent = Math.round((savings / regularPrice) * 100);
            
            savingsAmount.textContent = formatCurrency(savings);
            savingsPercentage.textContent = savingsPercent + '%';
            
            // Add animations
            offerPriceDisplay.classList.add('price-animated');
            finalPriceDisplay.classList.add('price-animated');
            setTimeout(() => {
                offerPriceDisplay.classList.remove('price-animated');
                finalPriceDisplay.classList.remove('price-animated');
            }, 300);
            
        } else {
            // Hide discount information
            discountRow.style.display = 'none';
            savingsRow.style.display = 'none';
            finalPriceDisplay.textContent = formatCurrency(regularPrice);
            
            // Add animation
            finalPriceDisplay.classList.add('price-animated');
            setTimeout(() => finalPriceDisplay.classList.remove('price-animated'), 300);
        }
        
        // Validate offer price
        if (offerPrice >= regularPrice && offerPrice > 0) {
            offerPriceInput.style.borderColor = '#EF4444';
            showValidationMessage(offerPriceInput, 'বিশেষ ছাড়ের মূল্য নিয়মিত মূল্যের চেয়ে কম হতে হবে', 'error');
        } else {
            offerPriceInput.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            hideValidationMessage(offerPriceInput);
        }
    }

    // Show validation message
    function showValidationMessage(input, message, type) {
        hideValidationMessage(input);
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `text-${type === 'error' ? 'red' : 'blue'}-400 text-sm mt-1 validation-message`;
        messageDiv.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-1"></i>${message}`;
        
        input.parentNode.parentNode.appendChild(messageDiv);
    }

    // Hide validation message
    function hideValidationMessage(input) {
        const existingMessage = input.parentNode.parentNode.querySelector('.validation-message');
        if (existingMessage) {
            existingMessage.remove();
        }
    }

    // Form validation
    function validateForm() {
        const isFree = freeCourseSwitch.checked;
        const regularPrice = parseFloat(priceInput.value) || 0;
        const offerPrice = parseFloat(offerPriceInput.value) || 0;
        
        let isValid = true;
        
        if (!isFree) {
            if (regularPrice <= 0) {
                isValid = false;
                priceInput.style.borderColor = '#EF4444';
                showValidationMessage(priceInput, 'নিয়মিত মূল্য ০ এর চেয়ে বেশি হতে হবে', 'error');
            } else {
                priceInput.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                hideValidationMessage(priceInput);
            }
            
            if (offerPrice >= regularPrice && offerPrice > 0) {
                isValid = false;
            }
        }
        
        submitBtn.disabled = !isValid;
        
        if (isValid) {
            submitBtn.classList.remove('opacity-50');
        } else {
            submitBtn.classList.add('opacity-50');
        }
        
        return isValid;
    }

    // Event listeners
    toggleSwitch.addEventListener('click', function() {
        toggleFreeMode(!freeCourseSwitch.checked);
    });

    freeToggleCard.addEventListener('click', function(e) {
        if (e.target !== toggleSwitch && !toggleSwitch.contains(e.target)) {
            toggleFreeMode(!freeCourseSwitch.checked);
        }
    });

    priceInput.addEventListener('input', function() {
        if (!freeCourseSwitch.checked) {
            updatePriceSummary();
        }
        validateForm();
    });

    offerPriceInput.addEventListener('input', function() {
        if (!freeCourseSwitch.checked) {
            updatePriceSummary();
        }
        validateForm();
    });

    // Form submission
    document.getElementById('pricingForm').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            
            // Show error notification
            showNotification('অনুগ্রহ করে সব ক্ষেত্র সঠিকভাবে পূরণ করুন', 'error');
            return;
        }
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>প্রক্রিয়াকরণ...';
        submitBtn.disabled = true;
        
        // Reset after potential redirect failure
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });

    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        if (type === 'success') {
            notification.classList.add('bg-green-600', 'text-white');
            notification.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        } else if (type === 'error') {
            notification.classList.add('bg-red-600', 'text-white');
            notification.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
        }
        
        document.body.appendChild(notification);
        
        // Slide in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Slide out and remove
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }

    // Initialize
    if (!freeCourseSwitch.checked) {
        updatePriceSummary();
    }
    validateForm();
});
</script>
@endsection