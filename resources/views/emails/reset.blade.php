<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Almarai&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Almarai';
            font-style: normal;
            src:  url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
        }
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Almarai' , sans-serif !important

        }

        body {
            font-family: 'Almarai' , sans-serif !important
        }

        .main-color {
            color: #515365
        }

        .app-color {
            color: #d5bb80
        }

        .email-container {
            background-color: #edf2f6;
            height: auto;
            margin: 60px auto
        }

        .email-logo {
            margin: 50px auto 30px
        }

        .username h4 {
            margin: 50px auto 12px;
            color: #515365;
            font-size: 30px;
            font-weight: lighter
        }

        .username strong {
            font-weight: 700
        }

        .approve p {
            font-size: 16px
        }

        .email-white-space {
            width: 90%;
            margin: auto;
            height: auto;
            background-color: #fff;
            margin-bottom: 15px
        }

        .email-img {
            width: 15%;
            margin: auto
        }

        .email-desc {
            width: 80%;
            text-align: center;
            font-weight: 300;
            margin: auto
        }

        .email-img img {
            width: 100%;
            margin: 15px auto
        }

        .code p {
            margin-bottom: 0;
            font-weight: 400;
            font-size: 30px
        }

        hr {
            width: 90%;
            background-color: #e4e4e4;
            border: 1px solid #e4e4e4;
            margin-top: 30px;
            margin-bottom: 30px
        }

        .code strong {
            font-size: 30px;
            font-weight: 400
        }

        .verify-btn a {
            background-color: #d5bb80;
            margin-bottom: 40px;
            margin-top: 10px;
            color: #fff;
            padding: 7px 50px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            text-decoration: none
        }

        .download-section h4 {
            margin-top: 26px;
            margin-bottom: 30px;
            font-size: 24px
        }

        .download-text {
            margin-bottom: 20px;
            width: 80%;
            margin: auto;
            font-weight: 300
        }

        .download-text p {
            margin-bottom: 50px
        }

        .download-links img {
            margin-bottom: 50px;
            width: auto;
            height: 60px;
        }

        .download-links a:first-of-type img {
            margin-right: 10px
        }

        .row {
            display: flex;
            width: 100%
        }

        .container {
            width: 95%;
            margin: auto;
            display: flex
        }

        .text-center {
            text-align: center
        }

        .d-flex {
            display: flex
        }

        .flex-row {
            flex-direction: row;
            -ms-flex-direction: row;
            -webkit-flex-direction: row
        }

        .justify-content-center {
            justify-content: center
        }
    </style>
    <title>Title</title>
</head>
<body>


<div class="container">
    <div class="row">
        <div class="email-container">
            <div class="row">
                {{--<img style="display: none" src="http://tamraat.com/dashboard/assets/images/logo-3.png" class="email-logo">--}}
            </div>
            <div class="row username">
                <h4>مرحبا <strong>{{$data['data']->name}}</strong></h4>
            </div>
            <div class="row approve d-flex flex-row justify-content-center">
                <div style="margin-bottom: 25px; width: 100%">
                    <p class="text-center font-weight-light main-color" style="margin: auto; font-family: 'Almarai', sans-serif;">شكرا على تسجيلك في تطبيق  <span class="app-color">همتك </span> من فضلك قم بإعادة تعيين كلمة السر </p>
                </div>
            </div>

            <div class="">
                <div class="email-white-space">
                    <div class="email-img">
                        <div class="">
                           {{-- <img src="http://tamraat.com/dashboard/assets/images/logo-3.png">--}}
                        </div>
                    </div>

                    <div class="email-desc">
                        <div class="col-md-10">
                            <p class="main-color font-weight-light text-center" style="font-family: 'Almarai', Arial, sans-serif;">
                                قم بالضغط على رابط التفعيل بالأسفل و اعد تعيين كلمة السر
                            </p>
                        </div>
                    </div>

                    @component('mail::button', ['url' => url('reset/password/' . $data['token'])])
                        اضغط هنا لإعادة التعيين
                    @endcomponent

                    <hr>
                </div>

                <div class="email-white-space">
                </div>
            </div>
        </div>
    </div>
</div>

