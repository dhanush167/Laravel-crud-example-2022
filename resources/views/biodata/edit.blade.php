@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h3>Edit Biodata </h3>
            </div>
        </div>



        @if($errors->any())
            <div class="alert alert-danger">

                <strong>Whoops !</strong> There where some problem with Your input <br>
                <ul>
                    @foreach($errors as $error)

                        <li>{{$error}}</li>

                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('biodata.update',$biodata->id)}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <strong>First Name</strong>
                    <input type="text" value="{{$biodata->first_name}}" name="first_name" class="form-control" placeholder="First Name">
                </div>

                <div class="col-md-12">
                    <strong>Last Name</strong>
                    <input type="text" value="{{$biodata->last_name}}" name="last_name" class="form-control" placeholder="Last Name">
                </div>


                <div class="col-md-12 mt-3 mb-3">
                    <label for="">Upload Image</label>
                    <input type="file"  name="image">
                    <img src="{{URL::to('/')}}/images/{{$biodata->image}}" class="img-thumbnail" width="100" alt="">
                    <input type="hidden" name="hidden_image" value="{{$biodata->image}}">
                </div>

                <div class="col-md-12">
                    <a href="{{route('biodata.index')}}" class="btn btn-sm btn-success"> Back</a>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </form>


    </div>
@endsection
