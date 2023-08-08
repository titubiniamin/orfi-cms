<div class="card">
    <div class="card-header">
      <h3 class="card-title">{{$page_info['title']}} List</h3>

      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a class="nav-link active" href="{{route($page_info['route'].'.create')}}">+ Add {{$page_info['title']}}</a>
          </li>
        </ul>
      </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <input type="hidden" name="table_data" id="table_data" value="{{ route($route_name)}}">
      <table id="example2" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Tags</th>
                <th>Action</th>
            </tr>
        </thead>
      </table>
    </div>
    <!-- /.card-body -->
</div>
  <!-- /.card -->
  @push('js')
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script>
        $(function () {

            var url = document.getElementById('table_data').value;

            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": url,
                "columns": [
                    {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { "data": 'id', "name": 'id' },
                    { "data": 'name', "name": 'name' },
                    { "data": 'subject', "name": 'subject' },
                    { "data": 'tags', "name": 'tags'},
                    { "data": 'action', "name": 'action', "orderable": false, "searchable": false}
                ]
            });

        });
    </script>
  @endpush
  @push('css')
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  @endpush

