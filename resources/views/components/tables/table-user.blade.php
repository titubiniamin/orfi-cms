<div class="card">
    <div class="card-header">
      <h3 class="card-title">{{$page_info['title']}} List</h3>

      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a class="nav-link active" href="{{route($page_info['route'].'.create')}}">Add {{$page_info['title']}}</a>
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
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
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
                "lengthMenu": [[3,5,10, 25, 50, -1], [3,5,10, 25, 50, "All"]],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": url,
                "columns": [
                    { "data": 'id', "name": 'id' },
                    { "data": 'name', "name": 'name' },
                    { "data": 'email', "name": 'email' },
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

  {{-- <tbody>

    <tr>
        <td>Image</td>
        <td>Name</td>
        <td>email@email.com</td>
        <td>
            <div class="btn-group">
                <a href="{{route($page_info['breadCrumb'][1].'.edit',1)}}" role="button" type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i></a>
                <a href="{{route($page_info['breadCrumb'][1].'.show',1)}}" role="button" type="button" class="btn btn-default"><i class="fas fa-eye"></i></a>
                <a href="{{route($page_info['breadCrumb'][1].'.destroy',1)}}" role="button" type="button" class="btn btn-default"><i class="fas fa-trash-alt"></i></a>
            </div>
        </td>
    </tr>

</tbody> --}}
