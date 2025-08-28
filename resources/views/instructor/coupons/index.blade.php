@extends('layouts.latest.instructor')

@section('title', 'Manage Coupons')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manage Coupons</h4>
                    <a href="{{ route('instructor.coupons.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Coupon
                    </a>
                </div>
                <div class="card-body">
                    @if($coupons->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Usage</th>
                                        <th>Valid From</th>
                                        <th>Valid Until</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $coupon)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $coupon->code }}</strong>
                                                <button class="btn btn-sm btn-outline-secondary copy-code" 
                                                        data-code="{{ $coupon->code }}" 
                                                        title="Copy to clipboard">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </td>
                                            <td>{{ $coupon->name }}</td>
                                            <td>
                                                <span class="badge badge-{{ $coupon->type === 'percentage' ? 'info' : 'warning' }}">
                                                    {{ ucfirst($coupon->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($coupon->type === 'percentage')
                                                    {{ $coupon->value }}%
                                                @else
                                                    ${{ number_format($coupon->value, 2) }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $coupon->used_count }} / {{ $coupon->usage_limit }}
                                                <div class="progress" style="height: 4px;">
                                                    <div class="progress-bar" 
                                                         style="width: {{ ($coupon->used_count / $coupon->usage_limit) * 100 }}%"></div>
                                                </div>
                                            </td>
                                            <td>{{ $coupon->valid_from->format('M d, Y') }}</td>
                                            <td>{{ $coupon->valid_until->format('M d, Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm toggle-status 
                                                       {{ $coupon->is_active ? 'btn-success' : 'btn-secondary' }}"
                                                        data-id="{{ $coupon->id }}">
                                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('instructor.coupons.show', $coupon) }}" 
                                                       class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('instructor.coupons.edit', $coupon) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-coupon" 
                                                            data-id="{{ $coupon->id }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $coupons->links() }}
                    @else
                        @include('partials.no-data', [
                            'message' => 'No coupons created yet.',
                            'action_text' => 'Create Your First Coupon',
                            'action_url' => route('instructor.coupons.create')
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this coupon? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Copy code to clipboard
    $('.copy-code').click(function() {
        const code = $(this).data('code');
        navigator.clipboard.writeText(code).then(function() {
            toastr.success('Coupon code copied to clipboard!');
        });
    });

    // Toggle status
    $('.toggle-status').click(function() {
        const button = $(this);
        const couponId = button.data('id');
        
        $.ajax({
            url: `/instructor/coupons/${couponId}/toggle-status`,
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    if (response.is_active) {
                        button.removeClass('btn-secondary').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-secondary').text('Inactive');
                    }
                    toastr.success('Coupon status updated successfully!');
                }
            },
            error: function() {
                toastr.error('Error updating coupon status.');
            }
        });
    });

    // Delete coupon
    $('.delete-coupon').click(function() {
        const couponId = $(this).data('id');
        $('#deleteForm').attr('action', `/instructor/coupons/${couponId}`);
        $('#deleteModal').modal('show');
    });
});
</script>
@endsection