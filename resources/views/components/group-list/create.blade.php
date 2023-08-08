{{-- add group form --}}
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
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
                                'name'=>'parent_id',
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
    $("#add_group_form").submit(function( event ) {
        event.preventDefault();
        var data = extractValue(event.target);
        data.book_id = "{{"$book->id"}}";
        $.ajax({
            type: "POST",
            url: data.url,
            data:data,
            success: function (response) {
                renderList()
                select2RenderOptions()
            }
        });

    });
</script>
@endpush
