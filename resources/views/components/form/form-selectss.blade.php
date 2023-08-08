<div class="form-group">
    <?php $actual_name = str_replace( ['edit'],'',$name); ?>

    <label for="{{$name}}" >{{ucwords( str_replace( ['_','id','edit'],' ',$name))}}</label>
    <select
        id="{{str_replace(' ','',$name)}}"
        @if($multiple ?? false) multiple @endif
        class="form-control select2"
        name= @if($multiple ?? false) {{$actual_name}}[] @else {{$actual_name}} @endif
        style="width: 100%;">
        @if($value != null)
            @if(is_array($value))
                @foreach ($value as $item)
                    <option selected value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
                @else
                <option selected value="{{$value->id}}">{{$value->name}}</option>
            @endif
        @endif
    </select>
    <span id="{{$name}}-error" class="error text-red">
        {{$errors->first($name)}}
    </span>
</div>

@push('js')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        select2RenderOptions()
        function select2RenderOptions() {
            var inputName = "{{"$name"}}";
            inputName = inputName.replace(" ", "")
            var urlforss = "{{"$url"}}";
            var data = "{{"$data"}}";

            $(`#${inputName}`).select2({
                placeholder: 'Select a option',
                theme: 'bootstrap4',
                ajax: {
                    url: urlforss,
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term, // search term
                            data: data
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    }
                    }
            });

        }

    </script>
@endpush
@push('css')
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
