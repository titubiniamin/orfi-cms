@extends('layouts.master')
@section('content')
    <div class="d-flex">
        <h5 class="text-muted mb-3 mr-4">Edit {{ $page_info['title'] }}</h5>
        <a href="{{ route( $page_info['route'].'.index') }}"> <i class="fa fa-arrow-left mr-2"></i>Back to
            all {{ $page_info['title'] }}
        </a>
    </div>
    <div class="card">
        <form role="form" method="post" enctype="multipart/form-data" action="{{ route('book.store') }}" id="quickForm"
              novalidate="novalidate">
            @csrf
            @method('post')
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        @include('components.form.form-input',[
                            'name'=>'name',
                            'type'=>'text',
                            'error' => null,
                            'value'=>null
                        ])
                    </div>
                    <div class="col-6">
                        @include('components.form.form-select',[
                            'name'=>'subject_id',
                            'label'=>'subject',
                            'error' => null,
                            'value'=> old('subject_id') ?? null,
                            'options'=>$subjects,
                        ])
                    </div>
                    {{--                <div class="col-6">--}}
                    {{--                    @include('components.form.form-selectss',[--}}
                    {{--                        'name'=>'tag',--}}
                    {{--                        'error' => null,--}}
                    {{--                        'value'=>null,--}}
                    {{--                        'multiple'=> true,--}}
                    {{--                        'data'=> null,--}}
                    {{--                        'url'=> route('get.tag.select')--}}
                    {{--                    ])--}}
                    {{--                </div>--}}

                    <div id="pdf-preview-div" class="col-12 mt-4" style="display: none">
                        <embed
                            type="application/pdf"
                            frameBorder="0"
                            scrolling="auto"
                            id="pdf-preview"
                            width="100%"
                            height="450"
                        >
                        <div class="" onclick="hidePdfPreviewDiv()" style="position: absolute; top: -26px; right : 0;cursor: pointer">
                            <span ><i class="fa fa-times-circle text-danger"></i></span>
                        </div>

                    </div>
                    <div class="col-6">
                        @include('components.form.form-file',[
                            'name'=>'book',
                            'type'=>'text',
                            'error' => null,
                            'value'=>null
                        ])
                    </div>
                    <div class="col-6">
                        @include('components.form.form-select',[
                            'name'=>'tag',
                            'label'=>'tag',
                            'value'=> old('tag') ?? null,
                            'options'=>$tags,
                            'error' => null,
                            'multiple'=> true,
                        ])
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save mr-2"></i>Save</button>
            </div>
        </form>

    </div>
    <script>
        $('#book').on('change', function () {
            $('#pdf-preview').attr('src', URL.createObjectURL(this.files[0]));
            $('#pdf-preview-div').show();
        });
        function hidePdfPreviewDiv() {
            $('#book').val('');
            $('#pdf-preview-div').hide();
        }
    </script>
@endsection
