@extends('layouts.master')
@section('content')
    <div class="d-flex">
        <h5 class="text-muted mb-3 mr-4">Create {{ $page_info['title'] }}</h5>
        <a href="{{ route( $page_info['route'].'.index') }}"> <i class="fa fa-arrow-left mr-2"></i>Back to all {{ $page_info['title'] }}
        </a>
    </div>
    <div class="row">
        <div class="col-md-8 p-0">
            <div class="card">
                <form role="form" method="post" enctype="multipart/form-data" action="{{ route('subject.store') }}"
                      id="quickForm" novalidate="novalidate">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @include('components.form.form-input',[
                                    'name'=>'name',
                                    'type'=>'text',
                                    'error' => null,
                                    'value'=>null
                                ])
                            </div>
                        </div>


                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info px-3"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
