@extends('admin.layout.index')
@section('content')
{{ Breadcrumbs::render('edit-brand',request()->id) }}
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
                <form method="post" action="{{route('admin.brand.update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name="title" value="{{$brand->brand_name}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                         <textarea class="form-control" required="" name="description" id="example-textarea" rows="5">{{$brand->description}}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-3">
                                <input type="file"  class="dropify" accept="image/*" name="image"  />
                                <input type="hidden" name="id" value="{{request()->id}}">
                            </div>
                            <input type="hidden" name="img_del" class="img_delete" value="0">

                            <div class="">
                                <div class="card-box product-box">
                                    <div class="product-action">
                                        <a href="javascript: void(0);" class="btn btn-danger btn-xs waves-effect waves-light del_img"><i class="mdi mdi-close"></i></a>
                                    </div>
                                    <div>
                                        <img src="{{asset($brand->brand_image)}}" alt="product-pic" class="img-fluid set_width" />
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->

                        </div>
                    </div>
                    <div class="m-t-20">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>
<!-- container -->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.img_delete').val(0);
            $('.del_img').click(function(){
                $('.img_delete').val(1);
                $(this).parent().parent().remove();
            });
        });
    </script>
@endsection
