<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .album-card {
            margin-bottom: 20px;
            cursor: pointer; 
        }
        .album-image {
            width: 100%;
            height: auto;
        }
        .album-details {
            text-align: center;
        }
        .album-title {
            display: inline-block;
            margin-right: 5px;
        }
        .heart-icon {
            color: #ccc; 
            font-size: 20px;
            cursor: pointer;
        }

        .heart-button:hover .heart-icon,
        .heart-icon.favorited { 
            color: #ff0000; 
        }

        .heart-button {
            background: none;
            border: none;
            padding: 0;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
