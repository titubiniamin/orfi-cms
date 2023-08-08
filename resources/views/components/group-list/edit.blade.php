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
                            @include('components.form.form-selectss',[
                                'name'=>'parent_idedit',
                                'error' => null,
                                'value'=>null,
                                'data'=> $book->id,
                                'url'=> route('get.groups.select')
                            ])
                        </div>


                    </div>
                </div>

                {{-- <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div> --}}


        </div>
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
@push('js')
    <script>
        $("#edit_group_form").submit( function (event){
            event.preventDefault();
            var formdata = extractValue(event.target);

            $.ajax({
                type: "PUT",
                url: "/group/"+formdata.group_id,
                success: function (response) {
                    $("#modal-delete-group").modal('hide');
                    select2RenderOptions()
                    renderList()
                }
            });
        })
    </script>
@endpush
