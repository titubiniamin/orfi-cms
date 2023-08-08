@extends('layouts.master')
@section('content')
    {{-- <div class="container-fluid"> --}}
    <div class="row">

        <div class="col-md-5" id="side-tool-bar">

            <a href="{{route('annotation.index')}}" class="btn btn-primary btn-block mb-3">Books List</a>

            {{-- <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Question List</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul id="questions_list" class="nav nav-pills flex-column">
                    </ul>
                </div>
            </div> --}}

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">

                        {{-- <li class="nav-item">
                            <a href="#" onclick="setAnnotationType('question',null,null)" class="nav-link annotation-type-button" data-type="question">
                                <i data-type="question" class="fas fa-question"></i> Question
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{route('bulk.store.answer',$book->id)}}" class="nav-link">
                                <i class="fas fa-upload"></i> Publish
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('annotation.index')}}" class="nav-link">
                                <i class="far fa-file-alt"></i> Drafts
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="fas fa-filter"></i> Junk
                            <span class="badge bg-warning float-right">65 pages</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-trash-alt"></i> Trash
                            </a>
                        </li> --}}
                    </ul>
                </div>

                <!-- /.card-body -->
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Group List
                    </h3>

                    <div class="card-tools">
                        {{-- data-target="#modal-lg" --}}
                        <button type="button" id="create_group_button" class="btn btn-tool text-primary"
                                data-toggle="modal">
                            Create Group
                        </button>
                        <form id="create_group_form_small" style="display: none">
                            @csrf
                            @method('post')
                            <input type="hidden" name="url" value="{{route('group.store')}}">
                            <input type="hidden" name="parent_id" value="">
                            <div class="input-group input-group-sm">
                                <input type="text" name="name" class="form-control">
                                <span class="input-group-append">
                                  <button type="submit" class="btn btn-info btn-flat">Add</button>
                                  <button type="button" id="done_creating_group_button" class="btn btn-info btn-flat">Done</button>
                                </span>
                            </div>
                        </form>
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button> --}}
                    </div>
                </div>

                <div class="card-body p-0">
                    <ul id="myUL"></ul>
                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>


        <!-- /.col -->
        <div class="col-md-7">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">
                        Annotated {{$book->name}}<br>
                    </h3>

                    <div class="card-tools">
                        @yield('toolbar')
                    </div>

                </div>

                <!-- /.card-header -->
                <div class="card-body p-0">
                    @yield('annotationsbar')
                    <div id="pdf_location" pdf_location="{{ env('AWS_CLOUD_FRONT_URL').$book->book }}"
                         class="pdfViewer"></div>
                    <div id="content-wrapper">
                        @yield('pdf')
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>

                <div class="card-footer mt-5">
                    {{-- <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                    <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button> --}}
                </div>

            </div>
            <!-- /.card -->
        </div>

    </div>

    {{-- add group form --}}
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- <div class="overlay d-flex justify-content-center align-items-center">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div> --}}
                <div class="modal-header">
                    <h4 class="modal-title" id="add_group_head">Create Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="add_group_form" novalidate="novalidate">
                        @csrf
                        @method('post')
                        <input type="hidden" name="url" value="{{route('group.store')}}">
                        <input type="hidden" name="parent_id" value="">
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

                                {{-- <div class="col-6">
                                    @include('components.form.form-selectss',[
                                        'name'=>'parent_id',
                                        'error' => null,
                                        'value'=>null,
                                        'data'=> $book->id,
                                        'url'=> route('get.groups.select')
                                    ])
                                </div> --}}

                            </div>
                        </div>

                    {{-- <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div> --}}
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- edit group form --}}
    <div class="modal fade" id="modal-edit-group">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="edit_group_name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="edit_group_form" novalidate="novalidate">
                        @csrf
                        @method('post')
                        <input type="hidden" id="edit-group-input-field" name="group_id" value="">
                        <input type="hidden" name="url" value="{{route('group.store')}}">
                        <input type="hidden" name="parent_id" value="">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">
                                    @include('components.form.form-input',[
                                        'name'=>'name_edit',
                                        'type'=>'text',
                                        'error' => null,
                                        'value'=>null
                                    ])
                                </div>

                                {{-- <div class="col-6">
                                    @include('components.form.form-selectss',[
                                        'name'=>'parent_idedit',
                                        'error' => null,
                                        'value'=>null,
                                        'data'=> $book->id,
                                        'url'=> route('get.groups.select')
                                    ])
                                </div> --}}


                            </div>
                        </div>

                    {{-- <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div> --}}


                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- delete group form --}}
    <div class="modal fade" id="modal-delete-group">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Delete Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        All the sub group,Questions and Answers selected under this group will be deleted.
                        if you delete this group. Please confirm.
                    </p>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <form id="delete-group-confirm-form">
                        @csrf
                        @method("delete")
                        <input type="hidden" id="delete-group-input-field" name="group_id" value="">
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- loading-massage --}}
    <div class="modal fade" id="loading-massage" style="z-index: 100000000!important;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body d-flex justify-content-center align-items-center" style="height: 150px;">
                    <div class="overlay d-flex justify-content-center align-items-center" style="border-radius: 3px">
                        {{-- <i class="fas fa-2x fa-sync fa-spin"></i> --}}
                        <img src="{{asset('dist/img/sourcetr.gif')}}" alt="text is being processed" style="
                            height: 200px;
                            width: 200px;
                        ">
                    </div>
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    {{-- loading-massage --}}
    <div class="modal fade" id="edit-annotation-preview" style="z-index: 100000;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Preview Text</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-preview-text-form">
                        <input type="hidden" id="annotationID" name="annotationID" value="">
                        <textarea
                            class="textarea"
                            id="show-annotation-text"
                            name="previewText"
                            placeholder="Place some text here"
                            style="
                            width: 100%;
                            height: 200px;
                            font-size: 14px;
                            line-height: 18px;
                            border: 1px solid #dddddd;
                            padding: 10px;"
                        >
                    </textarea>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    {{-- Add Question --}}
    <div class="modal fade" id="add-manual-question-modal" style="z-index: 100000;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title text-capitalize">Add new Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="from-group">
                        <label class="text-capitalize" id="radio-btn-type">Question Type</label><br>
                        <div class="form-check form-check-inline">
                            <input onclick="activeQuestionType(this.value)" class="form-check-input" type="radio"
                                   name="inlineRadioOptions" id="text-radio" value="text" checked>
                            <label class="form-check-label" for="text-radio">Text</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input onclick="activeQuestionType(this.value)" class="form-check-input" type="radio"
                                   name="inlineRadioOptions" id="image-radio" value="image">
                            <label class="form-check-label" for="image-radio">Image</label>
                        </div>
                    </div>
                    <form id="add-manual-question-answer-form" class="mt-3">
                        <div id="new-question">
                            <label class="text-capitalize" id="label-type" for="question">New Question</label>
                            <textarea
                                id="question"
                                class="w-100 p-2"
                                name="question_answer"
                                placeholder="Type here..."
                                rows="10"
                            >
                    </textarea>
                        </div>
                        <div id="upload-image" class="form-group mt-3">
                            <label for="image" class="mr-3">Upload Image or File</label>
                            <input type="file" id="image" name="image" accept="image/*"
                                   onchange="loadFile(event)"><br><br>
                            <img id="output" style="max-width: 50%"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/treeview/style.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/plugins/summernote/summernote-bs4.css')}}">
@endpush
@push('js')
    <script src="{{asset('plugins/treeview/js.js')}}"></script>
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('/plugins/annotations/js/crud1.js')}}"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const loadFile = function (event) {
            $('#output').show();
            let output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

        function activeQuestionType(value) {
            let textContent = $('#new-question');
            let imageContent = $('#upload-image');
            if (value === 'image') {
                textContent.hide();
                imageContent.show();
                $('#text-radio').prop('checked', false);
                $('#image-radio').prop('checked', true);
            } else {
                textContent.show();
                imageContent.hide();
                $('#text-radio').prop('checked', true);
                $('#image-radio').prop('checked', false);
            }
            $('#image').val('');
            $('#question').val('');
            $('#output').hide();
        }


        let questionData;

        function openAddQuestionAnswerModal(event) {
            questionData = {
                group_id: $(event).attr("data-group-id"),
                type: $(event).attr("data-annotation-type"),
                question_id: $(event).attr("data-question-id") ? $(event).attr("data-question-id") : '',
                book_id: "{{"$book->id"}}"
            }
            $('#radio-btn-type').text(`${questionData.type} Type`);
            $('#label-type').text(`New ${questionData.type}`);
            $('#modal-title').text(`Add new ${questionData.type}`);
            $('#add-manual-question-modal').modal('show')
            activeQuestionType('text')

        }

        $('#add-manual-question-answer-form').submit(function (e) {
            $("#loading-massage").modal('show');
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('group_id', questionData.group_id);
            formData.append('book_id', questionData.book_id);
            formData.append('type', questionData.type);
            formData.append('question_id', questionData.question_id);

            $.ajax({
                url: "{{route('manual-annotation.store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    $('#image').val('');
                    $('#question_answer').val('');
                    $('#add-manual-question-modal').modal('hide');
                    setTimeout(() => {
                        $("#loading-massage").modal('hide')
                    }, 500);
                    toastr.success(`Annotated & ${questionData.type} saved successfully`)
                    editPreviewText(response.annotation.id)
                    renderAnnotation()
                    renderList()
                },
                error: function (response) {
                    let error = response.responseJSON.errors;
                    if (error.image) toastr.error(error.image[0])
                    else if (error.question_answer) toastr.error(error.question_answer[0])
                    else toastr.error('Something went wrong')
                }
            })
        })

        renderList()
        let sidebarOpen = false;
        let groupAddFrom = false;
        let isFormEdit = false;

        function toggleSideBar(event) {
            sidebarOpen = !sidebarOpen
            $('#question_answer').animate({left: sidebarOpen ? '0' : '-950'});
            if (sidebarOpen) {
                renderQnA(event)
            }
        }

        // function selectQustion(event) {
        //     var group_id = $(event).attr('data-group-id');
        //     setAnnotationType('question',null,group_id);
        // }

        function renderQnA(event) {
            var book_id = "{{"$book->id"}}";
            $.ajax({
                type: "GET",
                url: "{{route('get.all.QnA')}}",
                data: {
                    group_id: $(event.target).attr('data-group-id'),
                    book_id: book_id
                },
                success: function (response) {
                    $("#accordionExample").html(response.questions)
                    var annotation_type_button = $(".annotation-type-button");
                    var edit_annotation_text_button = $(".edit-annotation-text-button");


                    edit_annotation_text_button.map((i, v) => {
                        v.addEventListener('click', handleUpdayeAnnotationText, false);
                    })

                    annotation_type_button.map((i, v) => {
                        v.addEventListener('click', handleAnnotation, false);
                    })

                    var delete_annotation_button = $(".delete-annotation-button");
                    delete_annotation_button.map((i, v) => {
                        v.addEventListener('click', handledeleteAnnotation, false);
                    })

                }
            });
        }

        function handledeleteAnnotation(event) {
            // $("#modal-delete-group").modal('show');

            var element = event.target;
            var annotation_id = $(element).attr('data-annotation-id');
            var parent_card_id = $(element).attr('data-parent-card-id');
            // console.log(parent_card_id);
            deleteAnnotation(annotation_id)
            $(`#${parent_card_id}`).remove()
        }

        let activeQuestion = null;

        function handleUpdayeAnnotationText(event) {
            annotation_id = $(event.target).attr('data-annotation-id');
            editPreviewText(annotation_id)
        }

        function handleAnnotation(event) {

            prevactiveQuestion = activeQuestion
            activeQuestion = event.target

            if (prevactiveQuestion != null) {
                $(prevactiveQuestion).css("color", "#dc3545")
            }
            $(activeQuestion).css("color", "#00ff00")

            // console.log(prevactiveQuestion,activeQuestion);

            var group_id = $(event.target).attr('data-group-id');
            var annotation_type = $(event.target).attr('data-annotation-type');
            var annotation_id = $(event.target).attr('data-annotation-id');
            var buttonType = $(event.target).attr('data-type');
            var question_id = $(event.target).attr('data-question-id');
            // console.log(question_id == undefined);
            // if(sidebarOpen){
            //     toggleSideBar(event)
            // }
            setAnnotationType(
                annotation_type,
                question_id,
                group_id,
                buttonType,
                annotation_id
            );
        }


        // $("#add_group_form").submit(function( event ) {
        //     event.preventDefault();
        //     var form = getFormElement(event.target);
        //     var data = extractValue(event.target);

        //     data.book_id = "{{"$book->id"}}";
        //     $.ajax({
        //         type: "POST",
        //         url: data.url,
        //         data:data,
        //         success: function (response) {
        //             toastr.success(response.message)
        //             renderList()
        //             // select2RenderOptions()
        //         }
        //     });

        // });

        function renderList() {
            var book_id = "{{"$book->id"}}";
            $.ajax({
                type: "POST",
                url: "{{ route('get.all.group') }}",
                data: {
                    book_id: book_id
                },
                success: function (response) {
                    $("#myUL").html(response.list);
                    var show_question_button = $(".show_question_button");
                    show_question_button.map((i, v) => {
                        v.addEventListener('click', toggleSideBar, false);
                    })

                    var annotation_type_button = $(".annotation-type-button");
                    annotation_type_button.map((i, v) => {
                        v.addEventListener('click', handleAnnotation, false);
                    })

                }
            });
        }

        // delete modal
        function changeDeleteGroupId(event) {
            // $($(this).parent()[0]).remove()
            // console.log();
            $('#modal-delete-group').modal('show')
            $("#delete-group-input-field").attr('value', $(event).attr("data-group-id"))
        }

        $("#delete-group-confirm-form").submit(function (event) {
            event.preventDefault();
            var formdata = extractValue(event.target);
            $.ajax({
                type: "DELETE",
                url: "/group/" + formdata.group_id,
                success: function (response) {
                    toastr.error(response.message)
                    $(`#li-elemtnt-${formdata.group_id}`).remove()
                    $("#modal-delete-group").modal('hide');
                    // select2RenderOptions()
                    // $(event).closest('li').remove()
                    // renderList()
                    renderAnnotation()
                }
            });
        })

        $("#create_group_button").click(function () {
            // $("#modal-lg").modal('show')
            toggleForm()
            resetCreateGroupFormValue()
            // $('#add_group_head').html(`Create Group`);
            // $("#parent_id").val(null)
        })

        $("#done_creating_group_button").click(function () {
            toggleForm()
            resetCreateGroupFormValue()
        })

        $('#create_group_form_small').submit(function (e) {
            e.preventDefault()
            var data = extractValue(e.target)
            data.book_id = "{{"$book->id"}}";
            $.ajax({
                type: data._method,
                url: data.url,
                data: data,
                success: function (response) {
                    toastr.success(response.message)
                    if (!isFormEdit) {
                        renderList()
                    }

                    if (isFormEdit) {
                        $($(`#li-elemtnt-${response.group.id}`).find('.group_name')[0]).html(response.group.name)
                        resetCreateGroupFormValue()
                        toggleForm()
                        isFormEdit = !isFormEdit
                    }

                    e.target.reset()

                }
            });

        })

        function changeEditGroupFormValue(event) {
            $.ajax({
                type: "GET",
                url: "/group/" + $(event).attr("data-group-id"),
                success: function (response) {
                    $('#edit_group_name').html(response.data.name);

                    var form = getFormElement($('#create_group_form_small'));
                    $($('#create_group_form_small')[0][5]).html('&#x2713;')
                    $(form.name).val(response.data.name)
                    $(form._method).val('PUT')
                    $(form.parent_id).val(response.data.parent_id)
                    $(form.url).val(`/group/${response.data.id}`)
                    isFormEdit = !isFormEdit
                    if (!groupAddFrom) {
                        toggleForm()
                    }

                    // var group_id = form[0][2];
                    // var name = form[0][5];
                    // var parent_id = form[0][4];

                    // $(group_id).val(response.data.id);
                    // $(name).val(response.data.name);
                    // $(parent_id).val(response.parent.id);

                    // $(select2).val(null)
                    // if(response.parent != null){
                    //     setSelect2Option(select2,response.parent.id,response.parent.name)
                    // }

                }
            });

        }

        // add child group
        function changeAddGroupFormValue(event) {
            $.ajax({
                type: "GET",
                url: "/group/" + $(event).attr("data-group-id"),
                success: function (response) {
                    // var form = $('#add_group_form');
                    // data-target='#modal-lg'
                    // $('#modal-lg').modal('show')

                    resetCreateGroupFormValue()
                    var form = getFormElement($('#create_group_form_small'));
                    $(form.parent_id).val(response.data.id)
                    $(form.name).attr("placeholder", `add group to ${response.data.name}`);
                    if (!groupAddFrom) {
                        toggleForm()
                    }
                    // $('#add_group_head').html(`Add Group under ${response.data.name}`);
                }
            });
        }

        function extractValue(form) {
            array = $(form).serializeArray();
            data = [];
            array.map((v, i) => {
                data.push([v.name, v.value])
            })
            return Object.fromEntries(data);
        }

        function setSelect2Option(select2, id, text) {
            var newOption = new Option(text, id, false, false);
            $(select2).append(newOption).trigger('change');
            $(select2).val(id);
        }

        function toggleForm() {
            $('#create_group_form_small').toggle(0,
                function () {
                    groupAddFrom = !groupAddFrom
                }
            )
            $("#create_group_button").toggle()
        }

        function getFormElement(form) {
            array = form.serializeArray();
            data = [];
            array.map((v, i) => {
                data.push([v.name, form[0][i]])
            })
            return Object.fromEntries(data);
        }

        function resetCreateGroupFormValue() {
            var form = getFormElement($('#create_group_form_small'));
            $($('#create_group_form_small')[0][5]).html('&#x2b;')
            $(form.name).val('')
            $(form._method).val('POST')
            $(form.name).attr("placeholder", "Add group");
            $(form.url).val(`${window.location.origin}/group`)
            $(form.parent_id).val('')
        }


    </script>
@endpush

