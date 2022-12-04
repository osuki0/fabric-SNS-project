<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title')</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>
 
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @yield('header')
    
        @foreach($errors->all() as $error)
            <div class="alert alert-primary">
                <p class="error">{{ $error }}</p>
            </div>
        @endforeach

        @if (\Session::has('success'))
            <div class="alert alert-success">
                {{ \Session::get('success') }}
            </div>
        @endif
    
        @if (\Session::has('failure'))
            <div class="alert alert-success">
                {{ session()->get('failure') }}
            </div>
        @endif

    @yield('content')

    @yield('footer')

</body>
</html>
