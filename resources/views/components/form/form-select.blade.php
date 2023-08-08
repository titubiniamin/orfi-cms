<div class="form-group">

    <label for="{{$label}}">{{ucwords( str_replace( '_',' ',$label))}}</label>
    <select id="{{$label}}" @if($multiple ?? false) multiple @endif class="form-control select2 w-100"
            name="{{($multiple ?? false) ? $name.'[]' : $name}}">
        @if(!($multiple ?? false))
            <option value="" selected disabled>Select a option...</option>
        @endif
        @foreach ($options as $option)
            @if(is_array($value))
                <option @if(array_filter($value,fn ($item) => $item == $option['id'])) selected
                        @endif value="{{$option['id']}}">{{$option['name']}}</option>
            @else
                <option @if( $value == $option['id'] ) selected
                        @endif value="{{$option['id']}}">{{$option['name']}}</option>
            @endif
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
            theme: 'bootstrap4',
            placeholder: "Select option...",
        })

    </script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
