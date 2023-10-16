@php $editing = isset($biodata) @endphp
<div class="col-md-12">
    <strong>First Name</strong>
    <input type="text"
           value="{{old('first_name', ($editing ? $biodata->first_name : ''))}}"
           name="first_name"
           class="form-control"
           minlength="3"
           maxlength="255"
           placeholder="First Name">
    @if ($errors->has('first_name'))
        <span class="text-danger">{{ $errors->first('first_name') }}</span>
    @endif
</div>
<div class="col-md-12">
    <strong>Last Name</strong>
    <input type="text"
           value="{{old('last_name', ($editing ? $biodata->last_name : ''))}}"
           name="last_name"
           class="form-control"
           minlength="3"
           maxlength="255"
           placeholder="Last Name">
    @if ($errors->has('last_name'))
        <span class="text-danger">{{ $errors->first('last_name') }}</span>
    @endif
</div>
<div class="col-md-12 mt-3 mb-3">
    <label for="">Upload Image</label>
    <input type="file"  name="image">
    @if($editing)
        <img src="{{URL::to('/')}}/images/{{$biodata->image}}" class="img-thumbnail" width="100" alt="">
        <input type="hidden" name="hidden_image" value="{{$biodata->image}}">
    @endif
    @if ($errors->has('image'))
        <span class="text-danger">{{ $errors->first('image') }}</span>
    @endif
</div>











