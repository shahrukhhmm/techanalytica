<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.8em;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        h1 {
            color: #566a7f;
        }
    </style>
</head>

<body>
    <div class="container">
        @yield('content')
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
