<div class="form-group">
    <label for="{{$name}}">{{ucwords( str_replace( '_',' ',$name))}}</label><br>
    <div class="input-group">
        <div class="custom-file">
            <input
                type="file"
                class="custom-file-input
                @if($error != null) is-invalid @endif"
                aria-describedby="{{$name}}-error"
                id="{{$name}}"
                name="{{$name}}"
                accept="application/pdf, application/vnd.ms-excel"
            >
            <label class="custom-file-label" for="{{$name}}">Choose file</label>
        </div>
        <div class="input-group-append">
            <span class="input-group-text" id="">Upload</span>
        </div>
    </div>
    @if($errors != null)
    <span id="terms-error" class="error text-red" style="display: inline;">
        {{$errors->first($name)}}
    </span>
    @endif
</div>

