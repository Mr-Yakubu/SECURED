@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-unlock"></i> Decrypt Message
    </div>
    <div class="card-body">
        <form action="{{ route('decrypt') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="encrypted_message"><i class="fas fa-lock"></i> Encrypted Message:</label>
                <input type="text" id="encrypted_message" name="encrypted_message" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="otp"><i class="fas fa-key"></i> OTP:</label>
                <input type="text" id="otp" name="otp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-unlock"></i> Decrypt
            </button>
        </form>

        @if(isset($decryptedMessage))
            <div class="mt-3">
                <h5><i class="fas fa-envelope-open-text"></i> Decrypted Message:</h5>
                <p>{{ $decryptedMessage = decrypt($encryptedMessage); }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
