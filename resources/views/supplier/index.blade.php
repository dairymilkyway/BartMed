@extends('layouts.master')
@section('content')
<div id="Suppliers" class="container pt-7">

    <div class="table-responsive">
        <table id="stable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Logo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="sbody">
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="SupplierModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Supplier</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="Supplierform" method="#" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="supplier_name" class="control-label">Supplier Name</label>
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                    </div>
                    <div class="form-group">
                      <label for="image" class="control-label">Logo</label>
                      <input type="file" class="form-control" id="image" name="uploads[]" multiple>
                  </div>              
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="SupplierSubmit" type="submit" class="btn btn-primary">Save</button>
                <button id="SupplierUpdate" type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection
