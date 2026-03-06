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
            line-height: 1.4;
        }

        /* Container Utama */
        .container {
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            background: #fff;
            overflow: hidden;
            max-width: 800px;
            margin: auto;
        }

        /* Header dengan Gradasi Indigo */
        .card-header {
            background: #4f46e5;
            color: white;
            padding: 25px;
            position: relative;
        }

        .title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .content {
            padding: 30px;
        }

        /* Booking Info Area */
        .booking-row {
            margin-bottom: 25px;
        }

        .label {
            color: #9ca3af;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 4px;
        }

        .booking-id {
            color: #4f46e5;
            font-size: 28px;
            font-weight: 900;
            margin: 2px 0;
        }

        .status-badge {
            background-color: #ecfdf5;
            color: #10b981;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            float: right;
            border: 1px solid #10b981;
            text-transform: uppercase;
        }

        /* Divider Putus-putus */
        .divider {
            border-top: 2px dashed #f3f4f6;
            margin: 25px 0;
        }

        /* Passenger Styling */
        .section-title {
            color: #1f2937;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        .passenger-box {
            background: #ffffff;
            border: 1px solid #f3f4f6;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 12px;
        }

        .p-name {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .p-nik {
            font-size: 11px;
            color: #6b7280;
            margin-top: 3px;
        }

        .seat-badge {
            float: right;
            text-align: right;
        }

        .seat-number {
            color: #4f46e5;
            font-size: 15px;
            font-weight: 800;
        }

        /* FLIGHT CARD (Bagian yang Anda minta) */
        .flight-card {
            background-color: #f8fafc;
            /* Indigo-50/50 vibe */
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-top: 25px;
        }

        .airline-tag {
            background: #4f46e5;
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 9px;
            font-weight: 800;
            display: inline-block;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .departure-date-info {
            font-size: 13px;
            font-weight: 700;
            color: #1e1b4b;
            margin-bottom: 15px;
        }

        .route-table {
            width: 100%;
            border-collapse: collapse;
        }

        .city-code {
            font-size: 20px;
            font-weight: 900;
            color: #111827;
        }

        .time-big {
            font-size: 24px;
            font-weight: 900;
            color: #4f46e5;
            line-height: 1;
            margin-bottom: 4px;
        }

        .airport-sub {
            font-size: 10px;
            color: #6b7280;
            font-weight: 700;
            text-transform: uppercase;
        }

        .flight-path-container {
            text-align: center;
            vertical-align: middle;
            color: #94a3b8;
        }

        .duration-text {
            font-size: 10px;
            font-weight: 800;
            color: #6366f1;
            margin-bottom: 5px;
        }

        .line-decoration {
            border-top: 2px solid #e2e8f0;
            position: relative;
            width: 80%;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card-header">
            <div class="title">E-TICKET RECEIPT</div>
        </div>

        <div class="content">
            <div class="booking-row">
                <span class="status-badge">Confirmed / Lunas</span>
                <div class="label">Booking Code</div>
                <div class="booking-id">{{ $order->kode_pemesanan }}</div>
                <div class="date" style="color: #9ca3af; font-size: 12px;">
                    Dipesan pada:
                    {{ \Carbon\Carbon::parse($order->waktu_pemesanan)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }}
                    WIB
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-title">Informasi Penumpang</div>

            @foreach($order->details as $detail)
                <div class="passenger-box">
                    <div class="seat-badge">
                        <div class="seat-number">{{ $detail->nomor_kursi }}</div>
                        <div class="label" style="font-size: 8px;">{{ $detail->tipe_kelas }}</div>
                    </div>
                    <div class="p-name">{{ $detail->nama_penumpang }}</div>
                    <div class="p-nik">ID/NIK: {{ $detail->nik }}</div>
                </div>
            @endforeach

            <div class="flight-card">
                <div class="airline-tag">{{ $detail->penerbangan->maskapai }}</div>

                <div class="departure-date-info">
                    
                    {{ \Carbon\Carbon::parse($detail->penerbangan->waktu_berangkat)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                </div>
                
                <table class="route-table">
                    <tr>
                        <td width="35%">
                            <div class="airport-sub">Keberangkatan</div>
                            <div class="time-big">
                                {{ \Carbon\Carbon::parse($detail->penerbangan->waktu_berangkat)->timezone('Asia/Jakarta')->format('H:i') }}
                            </div>
                            <div class="city-code">{{ $detail->penerbangan->bandaraAsal->kode_iata }}</div>
                        </td>
                
                        <td width="30%" class="flight-path-container">
                            <div class="duration-text">{{ $detail->penerbangan->durasi }}</div>
                            <div class="line-decoration"></div>
                            <div style="font-size: 9px; margin-top: 5px; font-weight: bold;">NON-STOP</div>
                        </td>
                
                        <td width="35%" style="text-align: right;">
                            <div class="airport-sub">Kedatangan</div>
                            <div class="time-big">
                                {{ \Carbon\Carbon::parse($detail->penerbangan->waktu_datang)->timezone('Asia/Jakarta')->format('H:i') }}
                            </div>
                            <div class="city-code">{{ $detail->penerbangan->bandaraTujuan->kode_iata }}</div>
                        </td>
                    </tr>
                </table>
            </div>

        <div style="margin-top: 30px; text-align: center; color: #9ca3af; font-size: 10px;">
            <p style="margin-bottom: 5px;">*Mohon tunjukkan e-tiket ini saat melakukan Check-In di Bandara.</p>
            <p>
                Dicetak pada:
                <strong>{{ \Carbon\Carbon::now()->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
                    WIB</strong>
            </p>
        </div>
        </div>
        </div>
        </body>
        
        </html>