@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-lock"></i> Encrypt Message
    </div>
    <div class="card-body">
        <form action="{{ route('encrypt') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="message"><i class="fas fa-comment"></i> Message:</label>
                <input type="text" id="message" name="message" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mobile_number"><i class="fas fa-phone"></i> Mobile Number (in E.164 format, e.g., +1234567890):</label>
                <input type="text" id="mobile_number" name="mobile_number" class="form-control" placeholder="+1234567890" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Encrypt
            </button>
        </form>

        @if(isset($encryptedMessage))
            <div class="mt-3">
                <h5><i class="fas fa-shield-alt"></i> Encrypted Message:</h5>
                <p>{ $encryptedMessage = encrypt($message )}</p>
            </div>
        @endif
    </div>
</div>
@endsection
