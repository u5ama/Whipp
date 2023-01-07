@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">View Passenger Verify Email Template</h4>
                <span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <meta name="x-apple-disable-message-reformatting" />
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <meta name="color-scheme" content="light dark" />
                        <meta name="supported-color-schemes" content="light dark" />
                        <title></title>
                        <style type="text/css" rel="stylesheet" media="all">
                            /* Base ------------------------------ */

                            @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
                            body {
                                width: 100% !important;
                                height: 100%;
                                margin: 0;
                                -webkit-text-size-adjust: none;
                            }

                            a {
                                color: #3869D4;
                            }

                            a img {
                                border: none;
                            }

                            td {
                                word-break: break-word;
                            }

                            .preheader {
                                display: none !important;
                                visibility: hidden;
                                mso-hide: all;
                                font-size: 1px;
                                line-height: 1px;
                                max-height: 0;
                                max-width: 0;
                                opacity: 0;
                                overflow: hidden;
                            }
                            /* Type ------------------------------ */

                            body,
                            td,
                            th {
                                font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
                            }

                            h1 {
                                margin-top: 0;
                                color: #333333;
                                font-size: 22px;
                                font-weight: bold;
                                text-align: left;
                            }

                            h2 {
                                margin-top: 0;
                                color: #333333;
                                font-size: 16px;
                                font-weight: bold;
                                text-align: left;
                            }

                            h3 {
                                margin-top: 0;
                                color: #333333;
                                font-size: 14px;
                                font-weight: bold;
                                text-align: left;
                            }

                            td,
                            th {
                                font-size: 16px;
                            }

                            p,
                            ul,
                            ol,
                            blockquote {
                                margin: .4em 0 1.1875em;
                                font-size: 16px;
                                line-height: 1.625;
                            }

                            p.sub {
                                font-size: 13px;
                            }
                            /* Utilities ------------------------------ */

                            .align-right {
                                text-align: right;
                            }

                            .align-left {
                                text-align: left;
                            }

                            .align-center {
                                text-align: center;
                            }
                            /* Buttons ------------------------------ */

                            .button {
                                background-color: #3869D4;
                                border-top: 10px solid #3869D4;
                                border-right: 18px solid #3869D4;
                                border-bottom: 10px solid #3869D4;
                                border-left: 18px solid #3869D4;
                                display: inline-block;
                                color: #FFF;
                                text-decoration: none;
                                border-radius: 3px;
                                box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                                -webkit-text-size-adjust: none;
                                box-sizing: border-box;
                            }

                            .button--green {
                                background-color: #22BC66;
                                border-top: 10px solid #22BC66;
                                border-right: 18px solid #22BC66;
                                border-bottom: 10px solid #22BC66;
                                border-left: 18px solid #22BC66;
                            }

                            .button--red {
                                background-color: #FF6136;
                                border-top: 10px solid #FF6136;
                                border-right: 18px solid #FF6136;
                                border-bottom: 10px solid #FF6136;
                                border-left: 18px solid #FF6136;
                            }

                            @media only screen and (max-width: 500px) {
                                .button {
                                    width: 100% !important;
                                    text-align: center !important;
                                }
                            }
                            /* Attribute list ------------------------------ */

                            .attributes {
                                margin: 0 0 21px;
                            }

                            .attributes_content {
                                background-color: #F4F4F7;
                                padding: 16px;
                            }

                            .attributes_item {
                                padding: 0;
                            }

                            .social td {
                                padding: 0;
                                width: auto;
                            }


                            .purchase_heading p {
                                margin: 0;
                                color: #85878E;
                                font-size: 12px;
                            }

                            body {
                                background-color: #F4F4F7;
                                color: #51545E;
                            }

                            p {
                                color: #51545E;
                            }

                            p.sub {
                                color: #6B6E76;
                            }

                            .email-wrapper {
                                width: 100%;
                                margin: 0;
                                padding: 0;
                                -premailer-width: 100%;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                /*background-color: #F4F4F7;*/
                                background-color: #773DBD !important;
                                color: #EBE538 !important;
                            }

                            .email-content {
                                width: 100%;
                                margin: 0;
                                padding: 0;
                                -premailer-width: 100%;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                            }
                            /* Masthead ----------------------- */

                            .email-masthead {
                                padding: 25px 0;
                                text-align: center;
                            }

                            .email-masthead_logo {
                                width: 94px;
                            }

                            .email-masthead_name {
                                font-size: 16px;
                                font-weight: bold;
                                color: #A8AAAF;
                                text-decoration: none;
                                text-shadow: 0 1px 0 white;
                            }
                            /* Body ------------------------------ */

                            .email-body {
                                width: 100%;
                                margin: 0;
                                padding: 0;
                                -premailer-width: 100%;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                background-color: #FFFFFF;
                            }

                            .email-body_inner {
                                width: 570px;
                                margin: 0 auto;
                                padding: 0;
                                -premailer-width: 570px;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                background-color: #FFFFFF;
                            }

                            .email-footer {
                                width: 570px;
                                margin: 0 auto;
                                padding: 0;
                                -premailer-width: 570px;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                text-align: center;
                            }

                            .email-footer p {
                                color: #EBE538 !important;
                            }

                            .body-action {
                                width: 100%;
                                margin: 30px auto;
                                padding: 0;
                                -premailer-width: 100%;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                text-align: center;
                            }

                            .body-sub {
                                margin-top: 25px;
                                padding-top: 25px;
                                border-top: 1px solid #EAEAEC;
                            }

                            .content-cell {
                                padding: 35px;
                            }
                            /*Media Queries ------------------------------ */

                            @media only screen and (max-width: 600px) {
                                .email-body_inner,
                                .email-footer {
                                    width: 100% !important;
                                }
                            }

                            @media (prefers-color-scheme: dark) {
                                body,
                                .email-body,
                                .email-body_inner,
                                .email-content,
                                .email-wrapper,
                                .email-masthead,
                                .email-footer {
                                    background-color: #773DBD !important;
                                    color: #FFF !important;
                                }
                                p,
                                ul,
                                ol,
                                blockquote,
                                h1,
                                h2,
                                h3 {
                                    color: #FFF !important;
                                }
                                .attributes_content,
                                .discount {
                                    background-color: #222 !important;
                                }
                                .email-masthead_name {
                                    text-shadow: none !important;
                                }
                            }

                            :root {
                                color-scheme: light dark;
                                supported-color-schemes: light dark;
                            }
                        </style>
                        <!--[if mso]>
                        <style type="text/css">
                            .f-fallback  {
                                font-family: Arial, sans-serif;
                            }
                        </style>
                        <![endif]-->
                    </head>
                    <body>

                    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <td align="center">
                                <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td class="email-masthead">
                                            <a href="https://example.com" class="f-fallback email-masthead_name">
                                                <img src="{{URL::asset($header->emh_logo)}}" alt="" height="70px">
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Email Body -->
                                    <tr>
                                        <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                                            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                                <!-- Body content -->
                                                <tr>
                                                    <td class="content-cell">
                                                        <div class="f-fallback">
                                                            <p style="font-size: 24px;"><b>{{$bodyTrans->emb_title_text_bf_name}}, Tester!</b></p>
                                                            <p>{{$bodyTrans->emb_title_text_after_name}}</p>
                                                            <!-- Action -->
                                                            <p>{{$bodyTrans->emb_body_text_after_button	}}</p>
{{--                                                            <p>Thanks For joining Whipp. Your request for approval of account is <b>Approved.</b> You can login and check the services of Whipp.</p>--}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td class="content-cell" align="center">
                                                        <p class="f-fallback sub align-center">&copy; 2020 {{$footerTrans->emf_company_name}}. All rights reserved.</p>
                                                        <p class="f-fallback sub align-center">
                                                            {{$footerTrans->emf_company_name}}
                                                            <br>{{$footerTrans->emf_company_address}}.
                                                            <br>{{$footerTrans->emf_company_contacts}}.
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-cell-social" align="center">
                                                        <p class="f-fallback sub align-center">
                                                            @if(isset($socialLinks))
                                                                @foreach($socialLinks as $link)
                                                                    <a href="{{$link->basl_url}}" target="_blank"><img src="{{asset($link->basl_image)}}" alt="" width="30px"></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    </body>
                    </html>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection
