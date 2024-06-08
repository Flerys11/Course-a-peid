<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pdf Certificate</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page{
            size : landscape;
        }
    </style>

    <style>
        .main-background{
            background: linear-gradient(#f2d0e6, #f6dae9);
            z-index: 1000;
        }
        .gradient{
            background-image:url('https://i.postimg.cc/W3dQnpdz/Design-sans-titre-1.png');
            background-repeat: no-repeat;
            background-position-x: 50px;
            background-position-y: 50px;
        }

    </style>


</head>
<body>


@php
    use Carbon\Carbon;
    $dateToday = Carbon::now('Indian/Antananarivo')->format('Y-m-d');
@endphp

@foreach($equipe as $datas)
<div class="container">
    <div class="container">
        <div class="row" >
            <div class="vh-100 overflow-y-none d-flex justify-content-center align-items-center">
                <div class="row main-background">
                    <div class="row card py-4 gradient" style="border-color: #f6dae9;">
                        <div class="card-header bg-transparent border-0">
                            <h1 class="text-center text-decoration-underline">
                                <i>
                                    Winner Certification
                                </i>
                            </h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row my-2">
                                    <p class="text-center">
                                        Félicitation !
                                        Nous vous attribuons ce certificat pour votre première place à notre course.
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="row">


                                        <div class="col-5 offset-1">
                                            <div class="row py-3">
                                                <table class="table p-4">
                                                    <tbody>
                                                    <tr class="p-2">
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">Rang :</td>
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">1</td>
                                                    </tr>
                                                    <tr class="p-2">
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">Pour l'équipe :</td>
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">{{ $datas->nom_equipe }}</td>
                                                    </tr>
                                                    <tr class="p-2">
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">Distance Parcourue :</td>
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">{{ $distance }} Km</td>
                                                    </tr>
                                                    <tr class="p-2">
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">Le :</td>
                                                        <td class="border-0 text-center" style="height: 60px; line-height: 50px;">{{ $dateToday }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
{{--                                        <div class="col-3 offset-2 p-3">--}}
{{--                                            <img src="https://i.postimg.cc/LhKsnv2v/one.png" width="100" alt="" srcset="">--}}
{{--                                        </div>--}}

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endforeach

</body>
</html>
