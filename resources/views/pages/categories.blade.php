@extends('layouts.app')

@section('title')
    @include('components.nav')
@endsection()

@section('content')
<div class="text-center my-4">
    <h3>List of all categories</h3>
</div>

@can('admin')
<div class="mb-2">
    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add category</button>
</div>
@endcan


<table id="dataTables" class="table table-striped shadow" style="width:100%">
    <thead>
        <tr>
            <th class="col-md-4">Categories</th>
            <th class="col-md-4">Created At</th>
            <th class="col-md-4">Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/shop/categories/update">
            @csrf
            <input type="hidden" class="form-control" id="id" name="id">
          <div class="form-group">
            <label for="name" class="col-form-label">Category name:</label>
            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
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
        <h5 class="modal-title" id="addModalLabel">Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/shop/categories/add">
            @csrf
          <div class="form-group">
            <label for="name" class="col-form-label">Category name:</label>
            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
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
            'ajax': '/shop/categories/ajax',
            'columns': [
                { 'data': 'name' },
                { 'data': 'created_at', 'searchable': false , 'render': function(data){
                     return moment(data).format('DD/MM/YYYY');
                }},
                { 'data': 'actions', 'searchable': false, 'render': function(data, type, row){
                    return '@can("admin")'+
                            '<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#exampleModal" data-id="'+row.id+'" data-name="'+row.name+'">Edit</button>'+
                                '<a class="btn btn-danger" href="categories/'+ row.id +'/delete">Delete</a>'+
                            '@else' +
                                'No permission'+
                            '@endcan';
                }}
            ]
        } );

        $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id)
        modal.find('.modal-body #name').val(name)
        });


    } );
</script>
@endsection