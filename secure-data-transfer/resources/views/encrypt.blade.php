@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Encrypt Message</div>
    <div class="card-body">
        <form action="{{ route('encrypt') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="message">Message:</label>
                <input type="text" id="message" name="message" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mobile_number">Mobile Number:</label>
                <input type="text" id="mobile_number" name="mobile_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Encrypt</button>
        </form>

        @if(isset($encryptedMessage))
            <div class="mt-3">
                <h5>Encrypted Message:</h5>
                <p>{{ $encryptedMessage }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
