@extends('layouts.master')
@section('content')
<div id="products" class="container pt-7">

    <div class="table-responsive">
        <table id="productable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Images</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stocks</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productbody">
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ProductModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create new customer</h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="pform" method="#" action="#" enctype="multipart/form-data">

            <div class="form-group">
              <label for="product_name" class="control-label">Product Name</label>
              <input type="text" class="form-control " id="product_name" name="product_name">
            </div>
            <div class="form-group">
              <label for="description" class="control-label">description</label>
              <input type="text" class="form-control " id="description" name="description">
            </div>
            <div class="form-group">
              <label for="price" class="control-label">price</label>
              <input type="text" class="form-control " id="price" name="price">
            </div>
            
            <div class="form-group">
              <label for="stocks" class="control-label">stocks</label>
              <input type="text" class="form-control " id="stocks" name="stocks">
            </div>
            <div class="form-group">
              <label for="category" class="control-label">category</label>
              <input type="text" class="form-control " id="category" name="category">
            </div>
            <div class="form-group">
              <label for="brand" class="control-label">brand</label>
              <select class="form-control" id="brand_id" name="brand_id" required>
                <option value="">Select Brand</option>
            </select>
            </div>
            <div class="form-group">
                <label for="image" class="control-label">Images</label>
                <input type="file" class="form-control" id="image" name="uploads[]" multiple>
            </div>   
          </form>
        </div>
        <div class="modal-footer" id="footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="ProductSubmit" type="submit" class="btn btn-primary" value="Submit">Save</button>
          <button id="ProductUpdate" type="submit" class="btn btn-primary" value="Submit">update</button>
        </div>
  
      </div>
    </div>
  </div>

@endsection