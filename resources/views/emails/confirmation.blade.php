<style>
    * {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
</style>

<div style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;">
    <p>
        <strong>
            Hello {{ $first_name }},
        </strong>
    </p>
    <p>
        Please confirm your email address for your account by clicking
        <a href="{{ route('confirmEmail', ['confirmation_code' => $confirmation_code]) }}">here.</a>
    </p>
    <p>
        You can also copy the link below, and paste it in your browser:
    </p>
    <p style="text-align: center; font-weight: bold; font-size: larger;">
        <a href="{{ route('confirmEmail', ['confirmation_code' => $confirmation_code]) }}">{{ route('confirmEmail', ['confirmation_code' => $confirmation_code]) }}</a>
    </p>
</div>