<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title>APPointment login</title>
    <link href="https://fonts.googleapis.com/icon?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('assets/dist/login.css') }}" />
    <link rel="shortcut icon" type="image/png" href="/assets/img/bell.png"/>
</head>
<body>

    @yield('content')

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-88946366-1', 'auto');
        ga('send', 'pageview');
    </script>

</body>
</html>
