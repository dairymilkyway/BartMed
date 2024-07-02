@extends('layouts.master')
@section('content')
<div id="brands" class="container">
    <div class="card-body" style="height: 210px;">
        <input type="text" id='brandSearch' placeholder="--search--">
    </div>
    <form action="{{ route('brand.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label for="importFile" class="block text-sm font-medium text-gray-700">Import Excel</label>
            <input type="file" id="importFile" name="importFile" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Import</button>
    </form>
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