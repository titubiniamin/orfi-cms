@extends('layouts.master')
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Create {{ $page_info['title'] }}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" method="post" enctype="multipart/form-data" action="{{ route('user.store') }}" id="quickForm" novalidate="novalidate">
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
                    @include('components.form.form-input',[
                        'name'=>'email',
                        'type'=>'email',
                        'error' => null,
                        'value'=>null
                    ])
                </div>
                <div class="col-12">
                    @include('components.form.form-input',[
                            'name'=>'password',
                            'type'=>'password',
                            'error' => null,
                            'value'=>null
                    ])
                </div>
            </div>



        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>
</div>
@endsection
