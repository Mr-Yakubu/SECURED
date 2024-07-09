@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Decrypt Message</div>
    <div class="card-body">
        <form action="{{ route('decrypt') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="encrypted_message">Encrypted Message:</label>
                <input type="text" id="encrypted_message" name="encrypted_message" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="otp">OTP:</label>
                <input type="text" id="otp" name="otp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Decrypt</button>
        </form>

        @if(isset($decryptedMessage))
            <div class="mt-3">
                <h5>Decrypted Message:</h5>
                <p>{{ $decryptedMessage }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
