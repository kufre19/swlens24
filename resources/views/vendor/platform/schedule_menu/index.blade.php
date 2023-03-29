@extends('platform::dashboard')

@section('content')
    {{-- <x-alert type="info" :title="__('Welcome to the Dashboard!')" class="mb-3"></x-alert> --}}

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule Menu</h4>
                </div>
                <div class="card-body text-center">
                    <a href="{{url('schedule-menu/list')}}" class="btn btn-success btn-sm px-4 py-2"><i class="icon-download"></i> Update Schedule Menu</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule Menu Title</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{url('schedule-menu/save')}}">
                        @csrf

                        <div class="form-group">
                            <label for="textarea">Enter a schedule menu item:</label>
                          <input type="text" name="schedule" id="" class="form-control form-control-lg">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
