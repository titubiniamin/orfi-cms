<div class="form-group mb-0">
    <div class="">
    <label class="" for="{{$name}}">{{ucwords( str_replace( '_',' ',$name))}}</label><br>
    <input id="{{$name}}" type="checkbox" name="{{$name}}"
        @if($value) checked @endif
        data-bootstrap-switch
        data-off-text="No"
        data-on-text="Yes"
    >
    </div>
    @if($errors != null)
        <span id="terms-error" class="error text-red" style="display: inline;">
            {{$errors->first($name)}}
        </span>
    @endif
</div>

@push('js')
    <script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    </script>
@endpush
