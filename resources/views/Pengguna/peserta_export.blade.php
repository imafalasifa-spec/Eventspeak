<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Peserta</title>
</head>

<body>

    <h2>Data Peserta Event</h2>
    <h3>{{ $namaEvent }}</h3>

    <table border="1">
        <thead>
            <tr style="font-weight:bold;">
                <th>No</th>
                <th>Nama Peserta</th>
                <th>No WA</th>
                <th>Metode Bayar</th>
                <th>Nomor Tiket</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>

        <tbody>
            @forelse($peserta as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama_user }}</td>
                <td>{{ $p->no_wa }}</td>
                <td>{{ ucfirst($p->metode_bayar) }}</td>
                <td>{{ $p->nomor_tiket }}</td>
                <td>{{ $p->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Belum ada peserta.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>