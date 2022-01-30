@extends('layouts.app')

@section('title')
    @include('components.nav')
@endsection()

@section('content')
<div class="text-center my-4">
    <h3>List of all users</h3>
</div>
<table id="dataTables" class="table table-striped shadow" style="width:100%">
    <thead>
        <tr>
            <th class="col-md-3">Username</th>
            <th class="col-md-3">Email</th>
            <th class="col-md-3">Status</th>
            <th class="col-md-3">Created At</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('js-inline')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable( {
            'processing': false,
            'serverSide': false,
            'ordering': false,
            'ajax': '/shop/users/ajax',
            'columns': [
                { 'data': 'name' },
                { 'data': 'email' },
                { 'data': 'status', 'render': function(data){
                    if(data === 1){
                        return 'Admin'
                    }else{
                        return 'Worker'
                    }
                }},
                { 'data': 'created_at', 'searchable': false , 'render': function(data){
                     return moment(data).format('DD/MM/YYYY');
                }},
            ]
        } );
    } );
</script>
@endsection