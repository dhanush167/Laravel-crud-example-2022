@extends('layouts.app')
@section('title','Show All User')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10">
                <h3>List of Bio Data</h3>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-sm btn-success" href="{{route('biodata.create')}}">Create New</a>
            </div>
        </div>
        @if($message=Session::get('success'))
            <div class="alert alert-success">
                <p>{{$message}}</p>
            </div>
        @endif
        <table class="table table-hover table-sm">
            <tr>
                <th width="50px">Id</th>
                <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Age Group</th>
                <th>Action</th>
                @isset($biodatas)
                  @if($biodatas->count() > 0)
                     @foreach($biodatas as $biodata)
                            <tr>
                                <td><b>{{$biodata->id}}</b></td>
                                <td><img src="{{URL::to('/')}}/images/{{$biodata->image}}" class="img-thumbnail" width="75" alt=""></td>
                                <td>{{$biodata->first_name}}</td>
                                <td>{{$biodata->last_name}}</td>
                                <td>{{$biodata->age}}</td>
                                <td>{{$biodata->category}}</td>
                                <td>
                                    <form action="{{route('biodata.destroy',$biodata->id)}}" method="post"  onsubmit="return confirm('{{ __('Are you sure') }}')">
                                        <a class="btn btn-sm btn-warning" href="{{route('biodata.edit',$biodata->id)}}">Update</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                     @endforeach
                  @endif
                @endisset
        </table>
        @isset($biodatas)
        <div class="d-flex justify-content-center">
        {!! $biodatas->links('vendor.pagination.bootstrap-4') !!}
        </div>
        @endisset
    </div>
@endsection
