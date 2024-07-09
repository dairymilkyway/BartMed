@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')
    <!-- Main Content -->
    <div class="col-md-10">
        <div id="brands" class="container pt-7">
            <div class="mb-4">
                <button id="addBrandBtn" class="btn btn-primary">Add Brand</button>
                <button id="importExcelBtn" class="btn btn-secondary">Import Excel</button>
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

        <!-- Brand Modal -->
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
                                <label for="brand_name" class="control-label">Brand Name</label>
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

        <!-- Import Excel Modal -->
        <div class="modal fade" id="importExcelModal" role="dialog" style="display:none">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import Excel</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" class="space-y-4" id="ExcelBform">
                            @csrf
                            <div>
                                <label for="importFile" class="block text-sm font-medium text-gray-700">Import Excel</label>
                                <input type="file" id="importFile" name="importFile" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <button id="BexcelSubmit" type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Import</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
