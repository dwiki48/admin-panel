@extends('layouts.app')

@section('content')
<div class="container">
    <h2 style="margin-top: 12px;" class="alert alert-success">Company Page
    </h2><br>
    <div class="row">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addPost()">Add Company</a>
        </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
            <table id="laravel_crud" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Website</th>
                        <th>Logo</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($company as $val => $post)
                    <tr id="row_{{$post->id}}">
                        <td>{{ $post->id  }}</td>
                        <td>{{ $post->name }}</td>
                        <td>{{ $post->website }}</td>
                        <td><img width="100px" src="{{ url('/logo/'.$post->logo) }}"></td>
                        <td><a href="javascript:void(0)" data-id="{{ $post->id }}" onclick="editPost(event.target)" class="btn btn-info">Edit</a></td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{ $post->id }}" class="btn btn-danger" onclick="deletePost(event.target)">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>

<div class="modal fade" id="post-modal" aria-hidden="true" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form name="userForm" class="form-horizontal" enctype="multipart/form-data" id="laravel-file-upload" action="javascript:void(0)">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2">Email</label>
                        <div class="col-sm-12">
                            <input type="mail" class="form-control" id="email" name="email" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="website" class="col-sm-2">Website</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="website" name="website" placeholder="Enter Website Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="logo" class="col-sm-2">Logo</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/gif, image/jpeg">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</html>


@endsection
@section('script')

<script type="text/javascript">
    $('#laravel_crud').DataTable();

    function addPost() {
        $("#id").val('');
        $('#post-modal').modal('show');
    }

    function editPost(event) {
        var id = $(event).data("id");
        let _url = `/company/${id}`;

        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if (response) {
                    $("#id").val(response.id);
                    $("#name").val(response.name);
                    $("#email").val(response.email);
                    $("#website").val(response.website);
                    $('#post-modal').modal('show');
                }
            }
        });
    }

    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#laravel-file-upload').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('id', $('#id').val());
            formData.append('name', $('#name').val());
            formData.append('email', $('#email').val());
            formData.append('website', $('#website').val());
            $.ajax({
                type: 'POST',
                url: "/company",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    location.reload(true);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });

    function deletePost(event) {
        var id = $(event).data("id");
        let _url = `/company/${id}`;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
        });
        location.reload(true);
    }
</script>
@endsection
