@extends('layouts.sidebar')
@section('content')







<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Add New User</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user-create') }}">
                        @csrf
                        @if ($errors->has('email'))
        <div class="alert alert-danger" role="alert">
            {{ $errors->first('email') }}
        </div>
    @endif
     @if ($errors->has('api_key'))
        <div class="alert alert-danger" role="alert">
            {{ $errors->first('api_key') }}
        </div>
    @endif

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">Confirm Password:</label>
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                        </div>
                         <div class="form-group">
                            <label for="apikey">API KEY:</label>
                            <input type="text" class="form-control" id="apikey" name="api_key" required>
                        </div>

                        <button type="submit" class="btn btn-primary">User Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
