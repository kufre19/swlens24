@extends('platform::dashboard')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule Menu Items</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule Menu Items</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           {{$item->name}}
                            <a  href="{{url('schedule-menu/edit') ."/" .$item->id}}" class="btn btn-link">Edit</a>
                        </li>
                        @endforeach
                        
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
