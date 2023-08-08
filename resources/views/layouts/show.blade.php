@extends('layouts.master')
@section('content')
 <div class="pl-md-4">
     <div class="d-flex">
         <h5 class="text-muted mb-3 mr-4">Preview {{ $page_info['title'] }}</h5>
         <a href="{{ url()->previous() }}"> <i class="fa fa-arrow-left mr-2"></i>Back to all {{ $page_info['title'] }}
         </a>
     </div>
     <div class="row">
         <div class="card col-8 p-0">
             <table class="table table-striped m-0">
                 <tbody>
                 @foreach($items->toArray() as $key => $item)
                     <tr>
                         @php $title = str_replace('_', ' ', $key); @endphp
                         <th class="w-25 text-capitalize">{{  $title }} :</th>
                         <td class="w-75">{{ $item ?? '-' }}</td>
                     </tr>
                 @endforeach
                 <tr>
                     <td class="w-25"><strong>Actions :</strong></td>
                     <td class="w-75">
                         <div class="d-flex">
                             <a href="{{ $edit_route }}" class=""><i
                                     class="fas fa-pencil-alt mr-1"></i> Edit</a>
                             <form id="delete-item" method="POST" action="{{ $delete_route }}">
                                 @csrf
                                 @method('DELETE')
                                 <a href="#" onclick="document.getElementById('delete-item').submit();" class="ml-5"><i
                                         class="fas fa-trash-alt mr-1"></i> Delete</a>
                             </form>

                         </div>
                     </td>
                 </tr>
                 </tbody>
             </table>
             @yield('data')
         </div>
     </div>
 </div>
@endsection
