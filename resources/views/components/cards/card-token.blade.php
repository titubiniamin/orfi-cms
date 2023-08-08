<div class="card">
    <div class="card-header">
      <h3 class="card-title"></h3>

      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('token.create') }}">Generate {{$page_info['title']}}</a>
          </li>
        </ul>
      </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <div class="bg-dark p-3">
            <b>Token : </b>{{$page_info['token']}}<br>
            <b>Links : </b>http://api.mp3fy.com/{{$page_info['token']}}
        </div>

    </div>
    <!-- /.card-body -->
</div>
