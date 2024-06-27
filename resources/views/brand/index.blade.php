@extends('layouts.master')
@section('content')
<div id="brands" class="container">
    <div class="card-body" style="height: 210px;">
        <input type="text" id='brandSearch' placeholder="--search--">
    </div>
    <div class="table-responsive">
        <table id="brandtable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Brand ID</th>
                    <th>Brand Name</th>
                    <th>Logo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="brandbody">
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="brandModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Brand</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="brandform" method="#" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="brand_name" class="control-label">brand Name</label>
                        <input type="text" class="form-control" id="brand_id" name="brand_name">
                    </div>
                    <div class="form-group">
                      <label for="image" class="control-label">Logo</label>
                      <input type="file" class="form-control" id="image" name="uploads[]" multiple>
                  </div>              
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="brandSubmit" type="submit" class="btn btn-primary">Save</button>
                <button id="brandUpdate" type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection