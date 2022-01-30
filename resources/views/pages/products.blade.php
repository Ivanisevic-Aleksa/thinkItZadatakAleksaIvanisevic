@extends('layouts.app')

@section('title')
    @include('components.nav')
@endsection()

@section('content')
<div class="text-center my-4">
    <h3>List of all products</h3>
</div>

@can('admin')
<div class="mb-2">
    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add product</button>
</div>
@endcan


<table id="dataTables" class="table table-striped shadow" style="width:100%">
    <thead>
        <tr>
            <th>Image</th>
            <th>Category</th>
            <th>Number</th>
            <th>Name</th>
            <th>About</th>
            <th>Price</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
  </table>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/shop/products/update" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" id="id" name="id">

            <div class="form-group">
            <label for="category" class="col-form-label">Product category:</label>
            <select type="text" class="form-select" id="category" name="category">
            <option value="none">--- Select ---</option>
                @foreach($categories as $category)
                  <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="number" class="col-form-label">Product number:</label>
            <input type="text" class="form-control" id="number" name="number" autocomplete="off" required>
            <small>Do not change this data*</small>
          </div>
          <div class="form-group">
            <label for="name" class="col-form-label">Product name:</label>
            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="about" class="col-form-label">About product:</label>
            <input type="text" class="form-control" id="about" name="about" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="price" class="col-form-label">Product price:</label>
            <input type="text" class="form-control" id="price" name="price" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="file" class="col-form-label">Product image:</label>
            <input type="file" class="form-control" id="file" name="file" accept=".png, .jpg, .jpeg" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/shop/products/add" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
            <label for="category" class="col-form-label">Product category:</label>
            <select type="text" class="form-select" id="category" name="category">
            <option value="none">--- Select ---</option>
                @foreach($categories as $category)
                  <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="number" class="col-form-label">Product number:</label>
            <input type="text" class="form-control" id="number" name="number" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="name" class="col-form-label">Product name:</label>
            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="about" class="col-form-label">About product:</label>
            <input type="text" class="form-control" id="about" name="about" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="price" class="col-form-label">Product price:</label>
            <input type="text" class="form-control" id="price" name="price" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="file" class="col-form-label">Product image:</label>
            <input type="file" class="form-control" id="file" name="file" accept=".png, .jpg, .jpeg" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@section('js-inline')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable( {
            'processing': false,
            'serverSide': false,
            'ordering': false,
            'ajax': '/shop/products/ajax',
            'columns': [
                { 'data': 'image', 'render': function(data, type, row){
                    return '<img src="{{ url('/shop/products/image') }}/'+ row.image_name +'" alt="product_image">';
                }},
                { 'data': 'category.name', 'render': function(data, type, row){
                  if(row.category === null){
                    return 'Undefined category!';
                  }else{
                    return data;
                  }
                }},
                { 'data': 'number' },
                { 'data': 'name' },
                { 'data': 'about', searchable: false},
                { 'data': 'price', searchable: false, 'render': function(data){
                  return '&#8364; ' + data;
                }},
                { 'data': 'created_at', 'searchable': false , 'render': function(data){
                     return moment(data).format('DD/MM/YYYY');
                }},
                { 'data': 'actions', 'searchable': false, 'render': function(data, type, row){
                    return '@can("admin")'+
                            '<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#exampleModal" '+
                            'data-id="'+row.id+'" data-number="'+row.number+'" data-name="'+row.name+'" data-about="'+row.about+'" data-price="'+row.price+'">Edit</button>'+
                                '<a class="btn btn-danger" href="products/'+ row.id +'/delete">Delete</a>'+
                            '@else' +
                                'No permission'+
                            '@endcan';
                }}
            ]
        } );

        $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var category = button.data('category')
        var number = button.data('number')
        var name = button.data('name')
        var about = button.data('about')
        var price = button.data('price')
        var modal = $(this)
        modal.find('.modal-body #id').val(id)
        modal.find('.modal-body #number').val(number)
        modal.find('.modal-body #name').val(name)
        modal.find('.modal-body #about').val(about)
        modal.find('.modal-body #price').val(price)
        });

    } );
</script>
@endsection