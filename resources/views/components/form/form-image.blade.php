<div class="form-group">
    <label for="{{$name}}">{{ucwords( str_replace( '_',' ',$name))}}</label><br>
    @if ($value)
        <img id="{{$name}}" style="hight:100px;width:100px" class="mb-2" src="{{$value}}" alt="your image" />
    @else
        <img id="{{$name}}" style="display: none; hight:100px;width:100px" src="#" alt="your image" />
    @endif

    <div class="input-group">
        <div class="custom-file">
            <input
                type="file"
                class="custom-file-input
                @if($error != null) is-invalid @endif"
                aria-describedby="{{$name}}-error"
                id="{{$name}}"
                name="{{$name}}"
                onchange="display(this)"
            >
            <label class="custom-file-label" for="{{$name}}">Choose file</label>
        </div>
        <div class="input-group-append">
            <span class="input-group-text" id="">Upload</span>
        </div>
    </div>
    @if($errors != null)
        <span id="{{$name}}-error" class="error text-red">
            {{$errors->first($name)}}
        </span>
    @endif
</div>

@push('js')
    <script>

        function display(input) {
            // console.log(input.name);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $(`#${input.name}`).attr('src', event.target.result);
                    $(`#${input.name}`).css('display', 'block');
                }
                reader.readAsDataURL(input.files[0]);
            }

        }

    </script>

@endpush
