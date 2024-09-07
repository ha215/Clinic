<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Requisition</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            align-items: center;
            justify-content: center;

        }

        .container {
            width: 8.5in;
            height: 11in;
            padding: 1in;
            border: 2px solid #00b3b3;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #00b3b3;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .doctor-info {
            width: 70%;
        }

        .header .doctor-info h2 {
            margin: 0;
            font-size: 24px;
            color: #00b3b3;
        }

        .header .doctor-info p {
            margin: 2px 0;
            font-size: 14px;
            color: #333;
        }

        .header .doctor-logo img {
            width: 100px;
        }

        .patient-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .patient-info .left {
            width: 60%;
        }

        .patient-info .right {
            width: 35%;
            text-align: right;
        }

        .patient-info .right p {
            margin: 5px 0;
        }

        .test-details {
            margin-bottom: 20px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            position: absolute;
            bottom: 1in;
            width: calc(100% - 2in);
            padding-top: 10px;
            border-top: 2px solid #00b3b3;
        }

        .footer .contact-info {
            font-size: 12px;
        }

        .footer .timing-info {
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="doctor-info">
                <h2>{{$clinic->name}}</h2>
                <p>{{$clinic->address}} | {{$clinic->contact_number}}</p>
               
            </div>
            <div class="doctor-logo">
                <img src="{{ url('img/logo/logo.png') }}" alt="Doctor Logo">
            </div>
        </div>

        <div class="patient-info">
            <div class="left">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d-M-Y') }}</p>
            </div>
            <div class="right">
                <p><strong>Name:</strong>{{ $patient->first_name }}</p>
                <p><strong>Age:</strong> {{ $age }}</p>
                <p><strong>Gender:</strong> {{ $patient->gender }}</p>
               
            </div>
        </div>

        <div class="test-details">
            <p><strong>Test(s) Requested:</strong></p>
            <h2>{{$test->name}}</h2>
            <p></p>
            <p></p>
        </div>

        <div class="footer">
            <p>Doctor's Signature</p>
            <div class="contact-info">
              <p><b>Dr. {{ $doctor->first_name }}</b></p>
            </div>
            <div class="timing-info">
               <p>{{$clinic->name}} | {{$clinic->address}} | {{$clinic->contact_number}}</p>
            </div>
        </div>
    </div>
</body>
</html>
