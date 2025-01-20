<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h2>{{ $data['title'] }}</h2>
    <p>{{ $data['content'] }}</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <x-primary-button>
            {{ __('Send Verification Email') }}
        </x-primary-button>
    </form>
</body>
</html>