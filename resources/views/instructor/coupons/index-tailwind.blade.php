@extends('layouts.instructor-tailwind')
@section('title', 'কুপন ব্যবস্থাপনা')
@section('header-title', 'কুপন ব্যবস্থাপনা')
@section('header-subtitle', 'আপনার কোর্সের জন্য ডিসকাউন্ট কুপন তৈরি এবং পরিচালনা করুন')

@section('style')
<style>
/* Coupon type badges */
.type-percentage {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
}

.type-fixed {
    background: linear-gradient(135deg, #FF9800, #F57700);
    color: white;
}

/* Status badges */
.status-active {
    background: linear-gradient(135deg, #4CAF50, #388E3C);
    color: white;
}

.status-inactive {
    background: linear-gradient(135deg, #9E9E9E, #757575);
    color: white;
}

/* Usage progress bar */
.usage-progress {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    height: 6px;
    overflow: hidden;
}

:root.light-theme .usage-progress {
    background: #E5E7EB;
}

.usage-progress-bar {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    height: 100%;
    transition: width 0.3s ease;
}

:root.light-theme .usage-progress-bar {
    background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
}

/* Coupon row hover effects */
.coupon-row {
    transition: all 0.3s ease;
}

.coupon-row:hover {
    transform: translateY(-1px);
}

:root.light-theme .coupon-row:hover {
    background-color: #F9FAFB;
}

/* Animation for table rows */
.animate-in {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.animate-in.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Action buttons */
.action-btn {
    border-radius: 8px;
    padding: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn-view {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
}

.action-btn-view:hover {
    background: linear-gradient(135deg, #1976D2, #1565C0);
    transform: translateY(-1px);
}

.action-btn-edit {
    background: linear-gradient(135deg, #FF9800, #F57700);
    color: white;
}

.action-btn-edit:hover {
    background: linear-gradient(135deg, #F57700, #EF6C00);
    transform: translateY(-1px);
}

.action-btn-delete {
    background: linear-gradient(135deg, #F44336, #D32F2F);
    color: white;
}

.action-btn-delete:hover {
    background: linear-gradient(135deg, #D32F2F, #C62828);
    transform: translateY(-1px);
}

.action-btn-copy {
    background: linear-gradient(135deg, #9C27B0, #7B1FA2);
    color: white;
}

.action-btn-copy:hover {
    background: linear-gradient(135deg, #7B1FA2, #6A1B9A);
    transform: translateY(-1px);
}

/* Toggle switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #9E9E9E;
    transition: 0.4s;
    border-radius: 34px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .toggle-slider {
    background: linear-gradient(135deg, #4CAF50, #388E3C);
}

input:checked + .toggle-slider:before {
    transform: translateX(26px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .responsive-table {
        font-size: 0.875rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .coupon-code {
        font-size: 0.75rem;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-white theme-text-primary font-bold text-2xl mb-2">কুপন ব্যবস্থাপনা</h1>
                <p class="text-secondary-200">আপনার কোর্সের জন্য ডিসকাউন্ট কুপন তৈরি এবং পরিচালনা করুন</p>
            </div>
            
            <a href="{{ route('instructor.coupons.create') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-lime to-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:shadow-1">
                <i class="fas fa-plus"></i>
                নতুন কুপন তৈরি করুন
            </a>
        </div>
    </div>

    <!-- Coupons Table -->
    @if($coupons->count() > 0)
    <div class="bg-card rounded-xl shadow-2 theme-shadow overflow-hidden">
        <div class="p-6 border-b border-[#fff]/20 theme-border">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-white theme-text-primary font-semibold text-lg mb-1">কুপন তালিকা</h2>
                    <p class="text-secondary-200 text-sm">{{ $coupons->total() }} টি কুপন পাওয়া গেছে</p>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full responsive-table">
                <thead>
                    <tr class="bg-gradient-to-r from-primary to-card border-b border-[#fff]/20 theme-border">
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">কোড</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">নাম</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">ধরন</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">মান</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">ব্যবহার</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">বৈধতা</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">স্ট্যাটাস</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $index => $coupon)
                    <tr class="coupon-row animate-in border-b border-[#fff]/10 theme-border hover:bg-card theme-hover" 
                        style="animation-delay: {{ $index * 0.1 }}s">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <code class="bg-body px-3 py-2 rounded-lg text-blue font-mono font-bold text-lg coupon-code">
                                    {{ $coupon->code }}
                                </code>
                                <button type="button" 
                                        onclick="copyCode('{{ $coupon->code }}')"
                                        class="action-btn action-btn-copy"
                                        title="কপি করুন">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-white theme-text-primary font-medium">{{ $coupon->name }}</div>
                            @if($coupon->description)
                                <div class="text-secondary-200 text-sm mt-1">{{ Str::limit($coupon->description, 40) }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $typeClass = $coupon->type === 'percentage' ? 'type-percentage' : 'type-fixed';
                                $typeName = $coupon->type === 'percentage' ? 'শতাংশ' : 'নির্দিষ্ট';
                                $typeIcon = $coupon->type === 'percentage' ? 'fas fa-percent' : 'fas fa-taka-sign';
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $typeClass }}">
                                <i class="{{ $typeIcon }}"></i>
                                {{ $typeName }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-white theme-text-primary font-bold">
                                @if($coupon->type === 'percentage')
                                    {{ $coupon->value }}%
                                @else
                                    ৳{{ number_format($coupon->value) }}
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                <div class="text-white theme-text-primary font-medium text-sm">
                                    {{ $coupon->used_count }} / {{ $coupon->usage_limit }}
                                </div>
                                <div class="usage-progress">
                                    <div class="usage-progress-bar" 
                                         style="width: {{ $coupon->usage_limit > 0 ? ($coupon->used_count / $coupon->usage_limit) * 100 : 0 }}%"></div>
                                </div>
                                <div class="text-secondary-200 text-xs">
                                    {{ $coupon->usage_limit > 0 ? round(($coupon->used_count / $coupon->usage_limit) * 100) : 0 }}% ব্যবহৃত
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-white theme-text-primary font-medium text-sm">
                                {{ $coupon->valid_from->format('d M Y') }}
                            </div>
                            <div class="text-secondary-200 text-xs">
                                {{ $coupon->valid_until->format('d M Y') }} পর্যন্ত
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <label class="toggle-switch">
                                <input type="checkbox" 
                                       {{ $coupon->is_active ? 'checked' : '' }}
                                       onchange="toggleStatus({{ $coupon->id }}, this)">
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 action-buttons">
                                <a href="{{ route('instructor.coupons.show', $coupon) }}" 
                                   class="action-btn action-btn-view"
                                   title="দেখুন">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('instructor.coupons.edit', $coupon) }}" 
                                   class="action-btn action-btn-edit"
                                   title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        onclick="showDeleteModal({{ $coupon->id }})"
                                        class="action-btn action-btn-delete"
                                        title="মুছে ফেলুন">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($coupons->hasPages())
        <div class="px-6 py-4 border-t border-[#fff]/20 theme-border">
            <div class="flex justify-center">
                <div class="pagination-wrapper">
                    {{ $coupons->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-card rounded-xl p-12 text-center shadow-2 theme-shadow">
        <div class="w-20 h-20 bg-orange/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-tags text-orange text-3xl"></i>
        </div>
        <h3 class="text-white theme-text-primary font-semibold text-xl mb-3">কোন কুপন তৈরি করা হয়নি</h3>
        <p class="text-secondary-200 mb-6 max-w-md mx-auto">
            আপনার কোর্সের জন্য ডিসকাউন্ট কুপন তৈরি করুন এবং শিক্ষার্থীদের আকৃষ্ট করুন।
        </p>
        
        <a href="{{ route('instructor.coupons.create') }}" 
           class="inline-flex items-center gap-2 bg-gradient-to-r from-lime to-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:shadow-1">
            <i class="fas fa-plus"></i>
            প্রথম কুপন তৈরি করুন
        </a>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-card rounded-xl max-w-lg w-full shadow-1 anim transform scale-95 opacity-0" id="deleteModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-[#fff]/20 theme-border">
            <h5 class="text-white theme-text-primary font-semibold text-xl">
                <i class="fas fa-trash mr-2"></i>কুপন মুছে ফেলার নিশ্চিতকরণ
            </h5>
            <button type="button" id="closeDeleteModal" class="p-2 text-secondary-200 hover:text-orange anim">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-orange/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-orange text-lg"></i>
                </div>
                <div>
                    <p class="text-white theme-text-primary font-medium">আপনি কি নিশ্চিত?</p>
                    <p class="text-secondary-200 text-sm">এই কুপনটি মুছে ফেলা হলে তা আর ফেরত পাওয়া যাবে না।</p>
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="flex items-center justify-end gap-4 p-6 border-t border-[#fff]/20 theme-border">
            <button type="button" 
                    id="cancelDeleteBtn"
                    class="px-6 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-secondary-200 hover:text-white">
                বাতিল
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-orange to-red text-primary rounded-lg font-semibold anim hover:shadow-1">
                    <i class="fas fa-trash mr-2"></i>
                    মুছে ফেলুন
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate table rows on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all coupon rows
    document.querySelectorAll('.animate-in').forEach(row => {
        observer.observe(row);
    });

    // Enhanced table row hover effects
    document.querySelectorAll('.coupon-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Copy code functionality
    window.copyCode = function(code) {
        navigator.clipboard.writeText(code).then(function() {
            // Show success notification
            showNotification('কুপন কোড কপি করা হয়েছে!', 'success');
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = code;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showNotification('কুপন কোড কপি করা হয়েছে!', 'success');
        });
    };

    // Toggle status functionality
    window.toggleStatus = function(couponId, checkbox) {
        const isActive = checkbox.checked;
        
        fetch(`/instructor/coupons/${couponId}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ is_active: isActive })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(
                    isActive ? 'কুপন সক্রিয় করা হয়েছে!' : 'কুপন নিষ্ক্রিয় করা হয়েছে!', 
                    'success'
                );
            } else {
                checkbox.checked = !isActive; // Revert checkbox
                showNotification('কুপন স্ট্যাটাস আপডেট করতে সমস্যা হয়েছে।', 'error');
            }
        })
        .catch(error => {
            checkbox.checked = !isActive; // Revert checkbox
            showNotification('কুপন স্ট্যাটাস আপডেট করতে সমস্যা হয়েছে।', 'error');
        });
    };

    // Delete Modal functionality
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

    function openDeleteModal() {
        deleteModal.classList.remove('hidden');
        setTimeout(() => {
            deleteModalContent.classList.remove('scale-95', 'opacity-0');
            deleteModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModalFn() {
        deleteModalContent.classList.remove('scale-100', 'opacity-100');
        deleteModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Event listeners for delete modal
    if (closeDeleteModal) {
        closeDeleteModal.addEventListener('click', closeDeleteModalFn);
    }
    
    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', closeDeleteModalFn);
    }

    // Close modal when clicking outside
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            closeDeleteModalFn();
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            closeDeleteModalFn();
        }
    });

    // Show delete modal
    window.showDeleteModal = function(couponId) {
        document.getElementById('deleteForm').action = `/instructor/coupons/${couponId}`;
        openDeleteModal();
    };

    // Simple notification system
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg anim transform translate-x-full opacity-0 ${
            type === 'success' ? 'bg-lime text-primary' : 'bg-orange text-primary'
        }`;
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'}"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 100);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('translate-x-0', 'opacity-100');
            notification.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Form submission loading states
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>প্রক্রিয়াকরণ...';
                submitBtn.disabled = true;
            }
        });
    });
});
</script>
@endsection