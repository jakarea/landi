{{-- Coupon Application Form Component --}}
<div class="coupon-form-container" id="couponFormContainer">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-tag"></i> Apply Coupon Code
            </h5>
        </div>
        <div class="card-body">
            <form id="couponForm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="coupon_code" class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code" 
                                   placeholder="Enter coupon code" style="text-transform: uppercase;">
                            <div class="invalid-feedback" id="coupon_error"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-primary d-block w-100" id="applyCouponBtn">
                            <i class="fas fa-check"></i> Apply Coupon
                        </button>
                    </div>
                </div>
            </form>
            
            {{-- Coupon Success Display --}}
            <div id="couponSuccess" class="alert alert-success" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-check-circle"></i>
                        <strong>Coupon Applied!</strong>
                        <span id="couponSuccessText"></span>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success" id="removeCouponBtn">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Price Summary Component --}}
<div class="price-summary" id="priceSummary">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Price Summary</h5>
        </div>
        <div class="card-body">
            <div class="price-row">
                <span>Original Price:</span>
                <span id="originalPrice">৳0.00</span>
            </div>
            
            <div class="price-row coupon-discount" id="couponDiscountRow" style="display: none;">
                <span class="text-success">
                    <i class="fas fa-tag"></i> Coupon Discount:
                </span>
                <span class="text-success" id="couponDiscount">-৳0.00</span>
            </div>
            
            <hr>
            
            <div class="price-row total-price">
                <strong>
                    <span>Total:</span>
                    <span id="finalPrice">৳0.00</span>
                </strong>
            </div>
        </div>
    </div>
</div>

<script>
class CouponManager {
    constructor(config = {}) {
        this.config = {
            courseId: config.courseId || null,
            userId: config.userId || null,
            originalAmount: config.originalAmount || 0,
            validateUrl: config.validateUrl || '/api/coupon/validate',
            applyUrl: config.applyUrl || '/api/coupon/apply',
            ...config
        };
        
        this.appliedCoupon = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.updatePriceSummary();
        
        // Auto-apply coupon from URL if present
        const urlParams = new URLSearchParams(window.location.search);
        const couponCode = urlParams.get('coupon');
        if (couponCode) {
            $('#coupon_code').val(couponCode);
            setTimeout(() => this.applyCoupon(), 500);
        }
    }

    bindEvents() {
        $('#applyCouponBtn').on('click', () => this.applyCoupon());
        $('#removeCouponBtn').on('click', () => this.removeCoupon());
        
        $('#coupon_code').on('keypress', (e) => {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                this.applyCoupon();
            }
        });

        // Convert to uppercase
        $('#coupon_code').on('input', (e) => {
            e.target.value = e.target.value.toUpperCase();
        });
    }

    async applyCoupon() {
        const couponCode = $('#coupon_code').val().trim();
        
        if (!couponCode) {
            this.showError('Please enter a coupon code');
            return;
        }

        if (!this.config.courseId) {
            this.showError('Course ID is required');
            return;
        }

        this.setLoading(true);
        this.clearMessages();

        try {
            const response = await fetch(this.config.validateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    code: couponCode,
                    course_id: this.config.courseId,
                    user_id: this.config.userId,
                    amount: this.config.originalAmount
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.appliedCoupon = {
                    code: couponCode,
                    discount: data.discount,
                    final_amount: data.final_amount,
                    coupon: data.coupon
                };
                
                this.showSuccess(data.coupon);
                this.updatePriceSummary();
                this.hideCouponForm();
                
                // Trigger custom event
                $(document).trigger('couponApplied', [this.appliedCoupon]);
            } else {
                this.showError(data.error || 'Invalid coupon code');
            }
        } catch (error) {
            console.error('Coupon validation error:', error);
            this.showError('Failed to validate coupon. Please try again.');
        } finally {
            this.setLoading(false);
        }
    }

    removeCoupon() {
        this.appliedCoupon = null;
        this.updatePriceSummary();
        this.showCouponForm();
        this.clearMessages();
        $('#coupon_code').val('');
        
        // Trigger custom event
        $(document).trigger('couponRemoved');
    }

    showSuccess(coupon) {
        const discountText = coupon.type === 'percentage' 
            ? `${coupon.value}% discount applied`
            : `৳${parseFloat(coupon.value).toFixed(2)} discount applied`;
            
        $('#couponSuccessText').text(discountText);
        $('#couponSuccess').show();
        $('#coupon_code').removeClass('is-invalid');
    }

    showError(message) {
        $('#coupon_error').text(message);
        $('#coupon_code').addClass('is-invalid');
        $('#couponSuccess').hide();
    }

    clearMessages() {
        $('#coupon_error').text('');
        $('#coupon_code').removeClass('is-invalid');
        $('#couponSuccess').hide();
    }

    setLoading(loading) {
        const btn = $('#applyCouponBtn');
        if (loading) {
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Applying...');
        } else {
            btn.prop('disabled', false).html('<i class="fas fa-check"></i> Apply Coupon');
        }
    }

    hideCouponForm() {
        $('#couponForm').hide();
    }

    showCouponForm() {
        $('#couponForm').show();
    }

    updatePriceSummary() {
        const originalPrice = this.config.originalAmount;
        let discount = 0;
        let finalPrice = originalPrice;

        if (this.appliedCoupon) {
            discount = this.appliedCoupon.discount;
            finalPrice = this.appliedCoupon.final_amount;
            $('#couponDiscountRow').show();
            $('#couponDiscount').text(`-৳${discount.toFixed(2)}`);
        } else {
            $('#couponDiscountRow').hide();
        }

        $('#originalPrice').text(`৳${originalPrice.toFixed(2)}`);
        $('#finalPrice').text(`৳${finalPrice.toFixed(2)}`);
    }

    // Public methods
    getAppliedCoupon() {
        return this.appliedCoupon;
    }

    setOriginalAmount(amount) {
        this.config.originalAmount = amount;
        this.updatePriceSummary();
    }

    setCourseId(courseId) {
        this.config.courseId = courseId;
    }

    setUserId(userId) {
        this.config.userId = userId;
    }
}

// Make it globally available
window.CouponManager = CouponManager;
</script>

<style>
.price-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.price-row.total-price {
    font-size: 1.1rem;
    border-top: 1px solid #dee2e6;
    padding-top: 0.5rem;
    margin-top: 0.5rem;
}

.coupon-form-container .card {
    border: 1px solid #e3f2fd;
    background-color: #fafafa;
}

.coupon-form-container .card-header {
    background-color: #e3f2fd;
    border-bottom: 1px solid #bbdefb;
}

#coupon_code {
    font-family: 'Courier New', monospace;
    font-weight: bold;
}

.alert.alert-success {
    border-left: 4px solid #28a745;
}
</style>