@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')

    <!-- Main Content -->
    <div class="col-md-10">
        <div id="orders" class="container pt-7">
            <div class="table-responsive">
                <table id="orderTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Courier</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Date Ordered</th>
                            <th>Change Status</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="orderbody">
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
                        <label for="orderName" class="form-label">Order ID</label>
                        <input type="text" class="form-control" id="orderName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="statusDropdown" class="form-label">Status</label>
                        <select class="form-select" id="statusDropdown">
                            <option value="processing">Processing</option>
                            <option value="to deliver">To Deliver</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <input type="hidden" id="orderId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
