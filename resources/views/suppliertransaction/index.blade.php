@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')
    <!-- Main Content -->
    <div class="col-md-9">
        <div id="SupplierTransaction" class="container pt-7">
            <div class="mb-4">
                <button id="addSupplierTransactionBtn" class="btn btn-info">Add Supplier Transaction</button>
            </div>

            <div class="table-responsive">
                <table id="STtable" class="table table-hover">
                    <thead class="thead-primary">
                        <tr>
                            <th>Supplier Transaction ID</th>
                            <th>Supplier Name</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="STbody" class="table-info"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Supplier Transaction Modal -->
<div class="modal fade" id="SupplierTransactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="SupplierTransactionForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="supplier_id">Supplier</label>
                        <select id="supplier_id" name="supplier_id" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select id="product_id" name="product_id" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input id="quantity" name="quantity" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="img_path">Image</label>
                        <input type="file" id="img_path" name="img_path" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="SupplierTransactionSubmit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
