<div class="form-group">
    <label for="{{$name}}">{{ucwords( str_replace( ['_','edit'],' ',$name))}}</label>
    <input type="{{$type}}" value="{{$value}}" name="{{str_replace( ['_','edit'],'',$name)}}" class="form-control @if($error != null) is-invalid @endif" id="{{$name}}" placeholder="Enter {{ucwords( str_replace( ['_','edit'],' ',$name))}}" aria-describedby="{{$name}}-error" aria-invalid="{{$error != null}}">
    <span id="{{$name}}-error" class="error text-red">
        {{$errors->first($name)}}
    </span>
</div>
