<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- google font cdn -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- bootstrap cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        body{
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
            text-decoration: none !important;
            border: 0 !important;
            list-style: none !important;
            outline: 0 !important;
            width: 100vw !important;
            font-family:'Montserrat', sans-serif !important;
            background: #fff;
            color: #3e3e3e;
            font-size: 1.1rem !important;
        }

        table tbody tr{
            height: 3rem;
        }
        .form{
            margin: 5rem auto;
        }
        .containerr{
            width: 94%;
            margin: 3rem auto 1.5rem;
        }
        .pg_header{
            width: 100%;
            background: #001659;
            padding: 1rem;
            color: white;
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            text-align: center;
        }
        .section{
            width: 100%;
            padding: 1.4rem 2rem;
            overflow: hidden;
        }
        .section .sub_detail{
            display: -webkit-box;
            display: flex;
            --webkit-box-pack: space-around;
            justify-content: space-around;
        }
        .section .sub_detail .det_table{
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }
        .section .passport_wrap{
            width: 100%;
            border: 1px solid #fff;
            height: 14rem;
            background: #fff;
            overflow: hidden;
            position: relative;

            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }
        .section .passport_wrap .pspt{
            height: 14rem;
            position: absolute;
            right: 0;
        }
        .section .passport_wrap .pspt img{
            height: 14rem;
            width: max-content;
            border: 1px solid #fff;
        }
        table thead th{
            font-size: 1.3rem;
        }
        table tbody tr th, table tbody tr td{
            vertical-align: middle !important;
            /* white-space: nowrap !important; */
        }
        table tbody tr td{
            margin-left: 10px !important;
        }

        table td:first-child, table th:first-child {
            border-left: 0 !important;
            border-right: 0 !important;
        }
        table thead th{
            border: 0 !important;
        }


        /* media queries */
        @media screen and (max-width: 992px){
            .form{
                margin: 1.5rem auto;
            }
            .containerr{
                width: 94%;
                margin: 1.5rem auto;
            }
        }
        @media screen and (max-width: 768px){
            .containerr{
                width: 96%;
                font-size: 1rem;
            }
            .containerr .pg_header{
                font-size: 1.2rem;
            }
            .section{
                padding: 1.4rem 1rem;
            }
        }
        @media screen and (max-width: 600px){
            .section .sub_detail{
                grid-template-columns: 1fr;
            }
            .section .sub_detail table{
                order: 2;
            }
            .section .sub_detail .passport_wrap{
                order: 1;
                width: 80%;
                margin: auto;
            }
        }
    </style>
</head>
<body>
    <div class="form">
        <div class="containerr">
            <div class="pg_header">Subscription Form</div>
            <article class="section">
                <div class="section_body sub_detail">
                    <div class="det_table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2" style="border: none">Subscriber's Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="25%">Surname:</th>
                                    <td>{{ $sub->surname }}</td>
                                </tr>
                                <tr>
                                    <th>Other Names:</th>
                                    <td>{{ $sub->other_names }}</td>
                                </tr>
                                <tr>
                                    <th>Spouse Surname:</th>
                                    <td>{{ $sub->spouse_surname }}</td>
                                </tr>
                                <tr>
                                    <th>Spouse Other Names:</th>
                                    <td>{{ $sub->spouse_names }}</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ $sub->gender }}</td>
                                </tr>
                                <tr>
                                    <th>Date Of Birth:</th>
                                    <td>{{ $sub->date_of_bt }}</td>
                                </tr>
                                <tr>
                                    <th>Marital Status:</th>
                                    <td>{{ $sub->mar_status }}</td>
                                </tr>
                                <tr>
                                    <th>Nationality:</th>
                                    <td>{{ $sub->nationality }}</td>
                                </tr>
                                <tr>
                                    <th>Residential Country:</th>
                                    <td>{{ $sub->res_country }}</td>
                                </tr>
                                <tr>
                                    <th>Occupation:</th>
                                    <td>{{ $sub->occupation }}</td>
                                </tr>
                                <tr>
                                    <th>Employer:</th>
                                    <td>{{ $sub->employer }}</td>
                                </tr>
                                <tr>
                                    <th>Phone No:</th>
                                    <td>{{ $sub->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile No:</th>
                                    <td>{{ $sub->mobile }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $sub->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="passport_wrap">
                        <div class="pspt">
                            <img src="{{ public_path('images/subscriptions/'.$sub->picture) }}" alt="Subscriber's Passport">
                        </div>
                    </div>
                </div>
            </article>
            <article class="section">
                <div class="section_body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="2">Next Of Kin Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="28%">Next of kin's Name:</th>
                                <td>{{ $sub->kin_name }}</td>
                            </tr>
                            <tr>
                                <th>Next of kin's Phone No:</th>
                                <td>{{ $sub->kin_phone }}</td>
                            </tr>
                            <tr>
                                <th>Next of kin's Email:</th>
                                <td>{{ $sub->kin_email }}</td>
                            </tr>
                            <tr>
                                <th>Next of kin's Phone:</th>
                                <td>{{ $sub->kin_address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
            <article class="section">
                <div class="section_body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="2">Other Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="28%">Plot Type:</th>
                                <td>{{ $sub->plot_type}}</td>
                            </tr>
                            <tr>
                                <th>Payment Plan:</th>
                                <td>{{ $sub->pay_plans }}</td>
                            </tr>
                            <tr>
                                <th>Plot Size:</th>
                                <td>{{ $sub->plot_size }}</td>
                            </tr>
                            <tr>
                                <th>Date Submitted:</th>
                                <td>{{ $sub->created }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </div>
    <!-- bootstrap cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
