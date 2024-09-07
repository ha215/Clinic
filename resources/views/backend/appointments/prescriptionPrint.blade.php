<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encounter Report</title>
    <style>
        

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            border: 1px solid #000; /* Outer border */
            box-sizing: border-box; /* Ensures padding and border are inside the width/height */
            width: 100%;
            max-width: 600px; /* Adjust as needed */
            margin: 0 auto;
            border: 2px solid #000; /* Border color */
            padding: 20px;
            box-sizing: border-box;
        }

        .header, .footer {
            text-align: center;
            margin: 10px 0;
        }

        .header img {
            width: 80px;
        }

        .content {
            margin: 10px;
        }

        .content .section {
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 16px;
            margin-bottom: 5px;
            border-bottom: 1px solid #333;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table, th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        .footer p {
            font-size: 10px;
        }

        .signature {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body onload="window.print();">
    <div class="header">
        <img src="{{ url('img/logo/logo.png') }}" alt="Clinic Logo">
        <h2>{{$clinic->name}}</h2>
        <p>{{$clinic->address}} | {{$clinic->contact_number}}</p>
    </div>

    <div class="content">
        <div class="section">
            <h3 class="section-title">Patient Information</h3>
            <p><strong>Name:</strong> {{ $patient->first_name }}</p>
            <p><strong>Age:</strong> {{ $age }} | <strong>Gender:</strong> {{ $patient->gender }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d-M-Y') }}</p>
        </div>

        <div class="section" style="display:none;">
            <h3 class="section-title">Diagnosis</h3>
            <p></p>
        </div>

        <div class="section">
            <h3 class="section-title">Prescription</h3>
            <table>
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Frequency</th>
                        <th>Duration</th>
                        <th>Instructions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicines as $medicine)
                        <tr>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->frequency }}</td>
                            <td>{{ $medicine->duration }}</td>
                            <td>{{ $medicine->instruction }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section" style="display:none;">
            <h3 class="section-title">Additional Instructions</h3>
            <p></p>
        </div>
    </div>

    <div class="footer">
        <p>Doctor's Signature</p>
        <div class="signature">
            <p>Dr. {{ $doctor->first_name }}</p>
        </div>
        <p>{{$clinic->name}} | {{$clinic->address}} | {{$clinic->contact_number}}</p>
    </div>
</body>
</html>
