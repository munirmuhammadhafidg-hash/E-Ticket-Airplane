<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>E-Tiket - {{ $order->kode_pemesanan }}</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Header Card */
        .card-header {
            background-color: #5850ec;
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            position: relative;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Main Container */
        .container {
            border: 1px solid #f0f0f0;
            border-radius: 15px;
            background: #fff;
        }

        .content {
            padding: 25px;
        }

        /* Booking Info */
        .booking-row {
            margin-bottom: 20px;
        }

        .label {
            color: #9ca3af;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .booking-id {
            color: #5850ec;
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
        }

        .status-badge {
            background-color: #ecfdf5;
            color: #10b981;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            float: right;
            border: 1px solid #10b981;
        }

        .date {
            color: #9ca3af;
            font-size: 12px;
        }

        /* Divider */
        .divider {
            border-top: 1px dashed #e5e7eb;
            margin: 20px 0;
        }

        /* Passenger Section */
        .section-title {
            color: #9ca3af;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .passenger-box {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .p-name {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
        }

        .p-nik {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        .seat-info {
            float: right;
            text-align: right;
        }

        .seat-number {
            color: #5850ec;
            font-size: 16px;
            font-weight: bold;
        }

        .class-type {
            color: #9ca3af;
            font-size: 11px;
            text-transform: uppercase;
        }

        /* Flight Route Section */
        .flight-card {
            background-color: #f9fafb;
            border: 1px solid #eef2f6;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        .route-table {
            width: 100%;
            border-collapse: collapse;
        }

        .city-code {
            font-size: 22px;
            font-weight: bold;
            color: #1f2937;
        }

        .time {
            font-size: 18px;
            font-weight: bold;
            color: #5850ec;
            margin-bottom: 5px;
        }

        .airport-label {
            font-size: 11px;
            color: #9ca3af;
            font-weight: bold;
        }

        .flight-path {
            text-align: center;
            position: relative;
            color: #5850ec;
            font-size: 12px;
        }

        .plane-icon {
            font-size: 18px;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card-header">
            <div class="title">Rincian E-Tiket</div>
        </div>

        <div class="content">
            <div class="booking-row">
                <span class="status-badge">LUNAS</span>
                <div class="label">Kode Booking</div>
                <div class="booking-id">{{ $order->kode_pemesanan }}</div>
                <div class="date">{{ $order->waktu_pemesanan->format('d M Y, H:i') }}</div>
            </div>

            <div class="divider"></div>

            <div class="section-title">Daftar Penumpang</div>

            @foreach($order->details as $detail)
                <div class="passenger-box">
                    <div class="seat-info">
                        <div class="seat-number">Kursi {{ $detail->nomor_kursi }}</div>
                        <div class="class-type">{{ $detail->tipe_kelas }}</div>
                    </div>
                    <div class="p-name">{{ $detail->nama_penumpang }}</div>
                    <div class="p-nik">ID/NIK: {{ $detail->nik }}</div>
                    <div style="clear: both;"></div>
                </div>
            @endforeach

            <div class="flight-card">
                <table class="route-table">
                    <tr>
                        <td width="35%">
                            <div class="airport-label">KEBERANGKATAN</div>
                            <div class="time">{{ $detail->penerbangan->waktu_berangkat->format('H:i') }}</div>
                            <div class="city-code">{{ $detail->penerbangan->bandaraAsal->kode_iata }}</div>
                        </td>
                        <td width="30%" class="flight-path">
                            <div>{{ $detail->penerbangan->durasi ?? '4j 40m' }}</div>
                            <span class="plane-icon"></span>
                        </td>
                        <td width="35%" style="text-align: right;">
                            <div class="airport-label">KEDATANGAN</div>
                            <div class="time">{{ $detail->penerbangan->waktu_datang->format('H:i') }}</div>
                            <div class="city-code">{{ $detail->penerbangan->bandaraTujuan->kode_iata }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>