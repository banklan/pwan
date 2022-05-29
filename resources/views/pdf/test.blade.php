<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            width: 100vw;
        }
        .wrapper{
            margin: 5rem auto;
            width: 80%;
            background: #fff;

            /* margin: auto;
            display: table; */

            display: -webkit-box;
            display: flex;
            --webkit-box-pack: space-around;
            justify-content: space-around;


            /* gap: 2rem; */
            /* grid-template-columns: 2fr 1fr; */
        }
        .box{
            border: 1px solid #fff;
            box-shadow:  0 2px 2px rgba(0, 0, 0, 0.1);
            width: 12rem;
            height: 12rem;
            /* margin: auto; */
            align-items: center;
            color: #fff;
            font-size: 2rem;

            /* display: flex; */
            /* --webkit-box-pack: space-around; */
            /* --webkit-justify-content: space-around; */
            /* justify-content: space-around; */
        }
        .a{
            background: orange;
            text-align: center;
            /* display: table-cell; */
            -webkit-box-flex: 1;
            -webkit-flex: 2;
            flex: 2;
        }
        .b{
            background: green;
            text-align: center;
            /* display: table-cell */
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="a box">Box A</div>
        <div class="b box">Box B</div>
    </div>

</body>
</html>
