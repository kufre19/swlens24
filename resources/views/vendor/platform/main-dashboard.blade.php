@extends('platform::dashboard')

@section('content')
    {{-- <x-alert type="info" :title="__('Welcome to the Dashboard!')" class="mb-3"></x-alert> --}}

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Download User Data</h4>
                </div>
                <div class="card-body text-center">
                    <a href="#" class="btn btn-success btn-sm px-4 py-2"><i class="icon-download"></i> Download</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">BroadCast An Event</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf

                        <div class="form-group">
                            <label for="textarea">Event Info:</label>
                            <textarea class="form-control form-control-lg" name="textarea" id="textarea" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="country">Country:</label>
                            <select class="form-control form-control-lg" name="country" id="country">
                                <option value="USA">USA</option>
                                <option value="Canada">Canada</option>
                                <option value="Mexico">Mexico</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="city">City:</label>
                            <select class="form-control form-control-lg" name="city" id="city">
                                <option value="New York">New York</option>
                                <option value="Los Angeles">Los Angeles</option>
                                <option value="Toronto">Toronto</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
