<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');
        @font-face {
            font-family: 'Broadway';
            src: url("{{ public_path('fonts/BROADW.TTF') }}") format('truetype');
        }

        @font-face {
            font-family: 'BookAntiquaBold';
            src: url("{{ public_path('fonts/BOOKB.TTF') }}") format('truetype');
        }
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        body {
            width: 100%;
            height: 100%;
            background-image: url("{{ public_path('tamplate/tamplate_sertifikat.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }


        .content {
            position: absolute;
            width: 100%;
            top: 210px;
            text-align: center;
        }

        .nomor {
            font-family: sans-serif;
            font-size: 21px;
            margin-bottom: 75px;
            margin-top: 40px;
        }

        .nama {
            font-size: 50px;
            font-family: Lobster, cursive;
            font-weight: bold;
            margin-top: 80px;
        }

        .institusi {
            font-family: 'BookAntiquaBold';
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .tanggal {
            font-family: sans-serif;
            font-size: 21px;
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="nomor">{{ $nomor_sertifikat }}</div>
        <div class="nama">{{ strtoupper($nama) }}</div>
        <div class="institusi">{{ $instansi }}</div>
        <div class="tanggal">dari {{ $tanggal_mulai }} - {{ $tanggal_selesai }}</div>
    </div>
</body>
</html>
