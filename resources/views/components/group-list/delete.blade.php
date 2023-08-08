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
