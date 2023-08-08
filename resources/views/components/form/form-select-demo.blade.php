<div class="form-group">
    <label for="{{$name}}" >{{ucwords( str_replace( '_',' ',$name))}}</label>
    <select id="{{$name}}" class="form-control select2" name="{{$name}}" style="width: 100%;">
        @foreach ($options as $option)
            <option @if( $value == $option['value'] ) selected  @endif value="{{$option['value']}}">{{$option['name']}}</option>
        @endforeach
    </select>
    <span id="{{$name}}-error" class="error text-red">
        {{$errors->first($name)}}
    </span>
</div>

@push('js')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4'
        }).data("select2").dropdown.$search.val()

    </script>
@endpush
@push('css')
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
