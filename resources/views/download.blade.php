<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download</title>
    <style>
        .btn_wrap{
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        a{
            border: 1px solid #fafafa;
            border-radius: 4px;
            background: #4702ac;
            color: #fff;
            padding: 12px 18px;
            margin-top: 10rem;
            text-decoration: none;
            cursor: pointer;
            width: 20rem;
        }
    </style>
</head>
<body>
    <h1>here is a download page!! for testing snappy</h1>
    <div class="btn_wrap">
        <a href="{{ route('download-pdf') }}">Download</a>
    </div>
</body>
</html>
