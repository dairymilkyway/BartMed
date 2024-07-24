@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')

    <!-- Main Content -->
    <div class="col-md-9">
        <div id="customers" class="container pt-7">
            <div class="table-responsive">
                <table id="customerTable" class="table table-striped table-hover">
                    <thead class="thead-primary">
                        <tr>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Number</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Change Status</th>
                            <th>Change Role</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="customerbody" class="table-info">
                    </tbody>
                </table>
            </div>
        </div> 
    </div> 
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeStatusForm">
                    <div class="mb-3">
                        <label for="statusName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="statusName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="statusDropdown" class="form-label">Status</label>
                        <select class="form-select" id="statusDropdown">
                            <option value="verified">Verified</option>
                            <option value="deactivated">Deactivated</option>
                        </select>
                    </div>
                    <input type="hidden" id="statusUserId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div class="modal fade" id="changeRoleModal" tabindex="-1" aria-labelledby="changeRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeRoleModalLabel">Change Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeRoleForm">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="roleName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="roleDropdown" class="form-label">Role</label>
                        <select class="form-select" id="roleDropdown">
                            <option value="admin">Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <input type="hidden" id="roleUserId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveRoleBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection