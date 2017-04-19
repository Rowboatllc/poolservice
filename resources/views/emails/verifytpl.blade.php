<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Please verify your email address</h2>

        <div>
            Thanks for creating an account with the verification app. Please follow the link below to verify your email
            address <a href="{{ route('confirm-by-email', ['email' => $email, 'code'=> $confirmation_code]) }}" target="_blank">{{ route('confirm-by-email', ['email' => $email, 'code'=> $confirmation_code]) }}</a>.<br/>

            If you have problems, please paste the above URL into your web browser.

        </div>

    </body>
</html>