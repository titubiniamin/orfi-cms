@extends('layouts.master')
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit {{ $page_info['title'] }}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" enctype="multipart/form-data" method="post" action="{{ route('user.update',$user->id) }}" id="quickForm" novalidate="novalidate">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    @include('components.form.form-input',[
                        'name'=>'name',
                        'type'=>'text',
                        'error' => null,
                        'value'=> $user->name
                    ])
                </div>
                <div class="col-6">
                    @include('components.form.form-input',[
                        'name'=>'email',
                        'type'=>'email',
                        'error' => null,
                        'value'=> $user->email
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
