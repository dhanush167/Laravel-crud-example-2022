@extends('layouts.app')
@section('title','Create New User')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h3>New Bio Data </h3>
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
        <form action="{{route('biodata.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('POST')
            <div class="row">
                @include('biodata.form')
                <div class="col-md-12 mt-2">
                    <a href="{{route('biodata.index')}}" class="btn btn-sm btn-success"> Back</a>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
