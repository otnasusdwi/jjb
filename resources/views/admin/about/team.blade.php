@extends('layouts.admin')

@section('title', 'Team Members')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Team Members</h4>
                    <a href="{{ route('admin.about.team.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Team Member
                    </a>
                </div>
                <div class="card-body">
                    @if($teamMembers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Email</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                    <tbody id="team-members-list">
                                    @foreach($teamMembers as $teamMember)
                                        <tr data-id="{{ $teamMember->id }}">
                                            <td>
                                                @if($teamMember->image)
                                                    <img src="{{ asset('storage/' . $teamMember->image) }}" alt="{{ $teamMember->name }}" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                                @else
                                                    <div class="bg-light d-inline-block text-center align-middle" style="width: 50px; height: 50px; line-height: 50px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $teamMember->name }}</td>
                                            <td>{{ $teamMember->position }}</td>
                                            <td>{{ $teamMember->email ?? '-' }}</td>
                                            <td>{{ $teamMember->order }}</td>
                                            <td>
                                                <span class="badge bg-{{ $teamMember->is_active ? 'success' : 'danger' }}">
                                                    {{ $teamMember->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.about.team.edit', $teamMember) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.about.team.destroy', $teamMember) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5>No team members found</h5>
                            <p class="text-muted">Add your first team member to get started.</p>
                            <a href="{{ route('admin.about.team.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Team Member
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make table rows sortable
    $('#team-members-list').sortable({
        handle: 'td:first-child',
        helper: 'clone',
        placeholder: 'sortable-placeholder',
        start: function(e, ui) {
            ui.placeholder.height(ui.item.height());
        },
        update: function(e, ui) {
            var order = [];
            $('#team-members-list tr').each(function() {
                order.push($(this).data('id'));
            });
            
            $.post('{{ route("admin.about.team.reorder") }}', {
                _token: '{{ csrf_token() }}',
                order: order
            }).done(function(response) {
                // Update order numbers in table
                $('#team-members-list tr').each(function(index) {
                    $(this).find('td:nth-child(5)').text(index);
                });
            });
        }
    });
});
</script>

<style>
.sortable-placeholder {
    background: #f0f0f0;
    border: 2px dashed #ccc;
}
</style>
@endpush
