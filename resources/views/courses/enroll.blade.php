@extends('layouts.guest')

@section('title', 'Enroll in ' . $course->title)
@php
    use Illuminate\Support\Str;
@endphp
@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Left Side - Course Information -->
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-graduation-cap"></i> Course Details</h4>
                </div>
                <div class="card-body">
                    <div class="course-image mb-4">
                        @if($course->thumbnail)
                            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="img-fluid rounded" style="width: 100%; height: 250px; object-fit: cover;">
                        @else
                            <div class="placeholder-img bg-secondary rounded d-flex align-items-center justify-content-center text-white" style="height: 250px; font-size: 3rem;">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="text-primary mb-3">{{ $course->title }}</h3>
                    <p class="text-muted mb-4" style="line-height: 1.6;">{{ $course->short_description }}</p>
                    
                    <div class="course-meta">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <span class="text-muted">Duration: 6 weeks</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <span class="text-muted">Students: 150+</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-certificate text-primary me-2"></i>
                                    <span class="text-muted">Certificate: Yes</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-play-circle text-primary me-2"></i>
                                    <span class="text-muted">Videos: 24</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Payment Information -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-credit-card"></i> Payment Details</h4>
                </div>
                <div class="card-body">
                    <!-- Price Summary -->
                    <div class="price-summary mb-4 p-3 bg-light rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Course Price:</span>
                            @if($course->offer_price && $course->offer_price < $course->price)
                                <span class="text-decoration-line-through text-muted">৳{{ number_format($course->price) }}</span>
                            @else
                                <span class="fw-bold">৳{{ number_format($course->price) }}</span>
                            @endif
                        </div>
                        
                        @if($course->offer_price && $course->offer_price < $course->price)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-success">Discount Price:</span>
                                <span class="fw-bold text-success">৳{{ number_format($course->offer_price) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-success">You Save:</span>
                                <span class="fw-bold text-success">৳{{ number_format($course->price - $course->offer_price) }}</span>
                            </div>
                        @endif
                        
                        <div id="promo-discount" class="d-flex justify-content-between align-items-center mb-2" style="display: none !important;">
                            <span class="text-success">Promo Discount:</span>
                            <span class="fw-bold text-success" id="promo-amount">-৳0</span>
                        </div>
                        
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">Total:</span>
                            <span class="h4 mb-0 text-success" id="final-total">৳{{ number_format($course->offer_price ?? $course->price) }}</span>
                        </div>
                    </div>

                    <!-- Coupon Code Section -->
                    <div class="promo-code-section mb-4">
                        <div class="d-flex gap-2">
                            <input type="text" id="promo_code" class="form-control" placeholder="Enter coupon code (e.g., M4NCQ4D8)" style="text-transform: uppercase;">
                            <button type="button" id="apply-promo" class="btn btn-outline-primary">Apply</button>
                        </div>
                        <div id="promo-message" class="mt-2" style="display: none;"></div>
                    </div>

                    <!-- Enrollment Form -->
                    <form action="{{ route('courses.enroll.store', $course->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Hidden field for coupon code -->
                        <input type="hidden" name="coupon_code" id="applied_promo_code" value="">
                        
                        <!-- Payment Method Selection -->
                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label fw-bold">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="">Select Payment Method</option>
                                <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>bKash</option>
                                <option value="nogod" {{ old('payment_method') == 'nogod' ? 'selected' : '' }}>Nogod</option>
                                <option value="rocket" {{ old('payment_method') == 'rocket' ? 'selected' : '' }}>Rocket</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Proof Section -->
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Payment Proof <span class="text-danger">*</span></label>
                            <p class="text-muted small mb-3">Provide either Transaction ID or Payment Screenshot (at least one is required for digital payments)</p>
                            
                            <!-- Transaction ID -->
                            <div class="mb-3">
                                <label for="transaction_id" class="form-label">Transaction ID</label>
                                <input type="text" name="transaction_id" id="transaction_id" 
                                       class="form-control @error('transaction_id') is-invalid @enderror" 
                                       value="{{ old('transaction_id') }}" 
                                       placeholder="Enter transaction ID (optional if screenshot provided)">
                                @error('transaction_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Screenshot -->
                            <div class="mb-3">
                                <label for="payment_screenshot" class="form-label">Payment Screenshot</label>
                                <input type="file" name="payment_screenshot" id="payment_screenshot" 
                                       class="form-control @error('payment_screenshot') is-invalid @enderror" 
                                       accept="image/jpeg,image/jpg,image/png,image/gif">
                                @error('payment_screenshot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Upload clear screenshot (JPG, PNG, GIF - Max 5MB)</small>
                            </div>
                            
                            <div id="payment-proof-error" class="text-danger small" style="display: none;">
                                Please provide either Transaction ID or Payment Screenshot for digital payments.
                            </div>
                            
                            @error('payment_proof')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Instructions -->
                        <div id="payment-instructions" class="alert alert-info d-none">
                            <h6><i class="fas fa-info-circle"></i> Payment Instructions:</h6>
                            <div id="instructions-content"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-lock"></i> Complete Enrollment
                            </button>
                            <a href="{{ route('courses') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Courses
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodSelect = document.getElementById('payment_method');
    const instructionsDiv = document.getElementById('payment-instructions');
    const instructionsContent = document.getElementById('instructions-content');
    const transactionIdField = document.getElementById('transaction_id');
    const screenshotField = document.getElementById('payment_screenshot');
    
    // Promo code functionality
    const promoCodeInput = document.getElementById('promo_code');
    const applyPromoBtn = document.getElementById('apply-promo');
    const promoMessage = document.getElementById('promo-message');
    const promoDiscount = document.getElementById('promo-discount');
    const promoAmount = document.getElementById('promo-amount');
    const finalTotal = document.getElementById('final-total');
    const appliedPromoCode = document.getElementById('applied_promo_code');
    
    // Course prices
    const originalPrice = {{ $course->offer_price ?? $course->price }};
    let currentTotal = originalPrice;
    let promoDiscountAmount = 0;
    
    
    // Apply promo code
    applyPromoBtn.addEventListener('click', function() {
        const promoCode = promoCodeInput.value.trim().toUpperCase();
        
        if (!promoCode) {
            showPromoMessage('Please enter a coupon code', 'danger');
            return;
        }
        
        // Show loading state
        applyPromoBtn.textContent = 'Applying...';
        applyPromoBtn.disabled = true;
        
        // Debug data being sent
        const requestData = {
            code: promoCode,
            course_id: {{ $course->id }},
            user_id: {{ auth()->id() ?? 'null' }},
            amount: originalPrice
        };
        console.log('Sending coupon validation request:', requestData);
        
        // Call our coupon validation API
        fetch('/api/coupon/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Apply the coupon
                promoDiscountAmount = data.discount;
                currentTotal = data.final_amount;
                
                // Update UI
                promoDiscount.style.display = 'flex';
                promoAmount.textContent = '-৳' + Math.round(promoDiscountAmount).toLocaleString();
                finalTotal.textContent = '৳' + Math.round(currentTotal).toLocaleString();
                appliedPromoCode.value = promoCode;
                
                let discountText = '';
                if (data.coupon.type === 'percentage') {
                    discountText = `${data.coupon.value}% discount applied`;
                } else {
                    discountText = `৳${data.coupon.value} discount applied`;
                }
                
                showPromoMessage(`✅ Coupon applied! ${discountText}`, 'success');
                promoCodeInput.disabled = true;
                applyPromoBtn.textContent = 'Applied';
                applyPromoBtn.classList.remove('btn-outline-primary');
                applyPromoBtn.classList.add('btn-success');
                
            } else {
                // Reset button state
                applyPromoBtn.textContent = 'Apply';
                applyPromoBtn.disabled = false;
                
                // Show detailed error message
                let errorMessage = '❌ ' + data.error;
                if (data.debug) {
                    console.log('Validation failed at step:', data.debug.step);
                    console.log('Debug info:', data.debug);
                    errorMessage += '<br><small class="text-muted">Debug: ' + data.debug.message + '</small>';
                }
                showPromoMessage(errorMessage, 'danger');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            console.log('Error details:', error.message, error.stack);
            applyPromoBtn.textContent = 'Apply';
            applyPromoBtn.disabled = false;
            showPromoMessage('❌ Error validating coupon. Please try again.', 'danger');
        });
    });
    
    function showPromoMessage(message, type) {
        promoMessage.innerHTML = `<small class="text-${type === 'success' ? 'success' : 'danger'}">${message}</small>`;
        promoMessage.style.display = 'block';
        
        if (type === 'danger') {
            setTimeout(() => {
                promoMessage.style.display = 'none';
            }, 3000);
        }
    }
    
    // Payment method functionality
    paymentMethodSelect.addEventListener('change', function() {
        const paymentMethod = this.value;
        
        if (paymentMethod && paymentMethod !== 'cash') {
            instructionsDiv.classList.remove('d-none');
            // Remove individual required attributes - we'll handle validation with custom logic
            transactionIdField.required = false;
            screenshotField.required = false;
            
            let instructions = '';
            const totalAmount = currentTotal; // Use current total including promo discount
            
            switch(paymentMethod) {
                case 'bkash':
                    instructions = `
                        <p><strong>bKash Payment Instructions:</strong></p>
                        <ol>
                            <li>Dial *247#</li>
                            <li>Select "Send Money"</li>
                            <li>Enter merchant number: 01XXXXXXXXX</li>
                            <li>Enter amount: <strong>৳${totalAmount.toLocaleString()}</strong></li>
                            <li>Enter PIN and confirm</li>
                            <li>Save the transaction ID or take screenshot</li>
                        </ol>
                    `;
                    break;
                case 'nogod':
                    instructions = `
                        <p><strong>Nogod Payment Instructions:</strong></p>
                        <ol>
                            <li>Open Nogod app</li>
                            <li>Select "Send Money"</li>
                            <li>Enter merchant number: 01XXXXXXXXX</li>
                            <li>Enter amount: <strong>৳${totalAmount.toLocaleString()}</strong></li>
                            <li>Enter PIN and confirm</li>
                            <li>Save the transaction ID or take screenshot</li>
                        </ol>
                    `;
                    break;
                case 'rocket':
                    instructions = `
                        <p><strong>Rocket Payment Instructions:</strong></p>
                        <ol>
                            <li>Dial *322#</li>
                            <li>Select "Send Money"</li>
                            <li>Enter merchant number: 01XXXXXXXXX</li>
                            <li>Enter amount: <strong>৳${totalAmount.toLocaleString()}</strong></li>
                            <li>Enter PIN and confirm</li>
                            <li>Save the transaction ID or take screenshot</li>
                        </ol>
                    `;
                    break;
            }
            instructionsContent.innerHTML = instructions;
        } else if (paymentMethod === 'cash') {
            instructionsDiv.classList.remove('d-none');
            transactionIdField.required = false;
            screenshotField.required = false;
            instructionsContent.innerHTML = `
                <p><strong>Cash Payment Instructions:</strong></p>
                <p>Please contact the instructor directly for cash payment arrangements. Total amount: <strong>৳${currentTotal.toLocaleString()}</strong></p>
                <p>Your enrollment will be pending until payment is verified.</p>
            `;
        } else {
            instructionsDiv.classList.add('d-none');
            transactionIdField.required = false;
            screenshotField.required = false;
        }
    });
    
    // Custom form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const paymentMethod = paymentMethodSelect.value;
        const transactionId = transactionIdField.value.trim();
        const screenshot = screenshotField.files.length > 0;
        const paymentProofError = document.getElementById('payment-proof-error');
        
        // Hide previous error
        paymentProofError.style.display = 'none';
        
        // Check if digital payment method is selected
        if (paymentMethod && paymentMethod !== 'cash') {
            // For digital payments, require either transaction ID or screenshot
            if (!transactionId && !screenshot) {
                e.preventDefault();
                paymentProofError.style.display = 'block';
                paymentProofError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }
        }
        
        // Validate file size if screenshot is provided
        if (screenshot) {
            const file = screenshotField.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (file.size > maxSize) {
                e.preventDefault();
                alert('Payment screenshot must be less than 5MB');
                return false;
            }
        }
        
        return true;
    });
    
    // Allow enter key on promo code input
    promoCodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            applyPromoBtn.click();
        }
    });
});
</script>
@endsection