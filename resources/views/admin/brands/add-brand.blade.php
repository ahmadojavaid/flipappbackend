@extends('admin.layout.index')
@section('content')
{{ Breadcrumbs::render('add-brand') }}
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"></h4>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post" action="{{route('admin.brand.save')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name="title"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                         <textarea class="form-control" required="" name="description" id="example-textarea" rows="5"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-3">
                                <input type="file" required="" class="dropify" accept="image/*" name="image"  />
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                    </div>
                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>
<!-- container -->
@endsection
