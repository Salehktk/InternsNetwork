<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Submission</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            padding: 10px;
            text-align: left;
        }
        .container {
            padding: 0;
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 16px; /* Added border radius for the container */
            overflow: hidden; /* Ensures the border radius is applied to children elements */
        }
        .main {
            background: #ffffff;
            border: 1px solid #eaebed;
            border-radius: 16px;
            width: 100%;
        }
        .logo {
            height: 100px;
            width: 100%;
            border: 2px;
            background: #3550a0;
            border-radius: 10px;
        }

        .logo img {
            padding-top: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .footer{
         clear: both;
         padding-top: 24px;
         text-align: center;
         width: 100%;
         }

        /* .footer {
          margin-top: 10px;;
            text-align: center;
            padding: 10px;
            background-color: #f8f8f8; 
            color: #777;
           
            font-size: 12px;
        } */
        .content-block {
            padding: 20px;
        }
        .content-block p {
            margin: 0 0 10px;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="container main mt-3">

            <div class="logo">
                <img src="{{ asset('images/harrison.png') }}" alt="Harrison Careers">
            </div>


        <div class="content-block">
          <P>New Coach <strong class="text-danger">"{{ $FullName ?? '' }}"</strong> submitted details. He needs to be processed now so he can start coaching</P>
           
        </div>
    </div>
   

  <div class="footer">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
            <td class="content-block">
                <span class="apple-link">Copyright © 2024 Harrison Careers LLC All rights reserved</span>

            </td>
        </tr>

    </tbody></table>
</div>
</body>
</html>