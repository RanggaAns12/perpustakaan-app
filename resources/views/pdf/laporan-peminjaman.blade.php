<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perpustakaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        
        .status-dipinjam { color: #d97706; font-weight: bold; }
        .status-kembali { color: #059669; font-weight: bold; }
        .status-telat { color: #dc2626; font-weight: bold; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMINJAMAN PERPUSTAKAAN</h1>
        <p>SMAN 1 TANJUNG MORAWA</p>
        <p>Periode: {{ date('d/m/Y', strtotime($tglAwal)) }} - {{ date('d/m/Y', strtotime($tglAkhir)) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tgl Pinjam</th>
                <th style="width: 15%">Kode</th>
                <th style="width: 20%">Siswa</th>
                <th style="width: 30%">Judul Buku</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->tanggal_peminjaman)) }}</td>
                    <td>{{ $row->kode_transaksi }}</td>
                    <td>
                        {{ $row->siswa->nama_lengkap ?? 'Siswa Dihapus' }}
                        <br><small style="color: #666">{{ $row->siswa->kelas->nama_kelas ?? '-' }}</small>
                    </td>
                    <td>
                        @foreach($row->detailPeminjaman as $det)
                            <div>- {{ $det->buku->judul_buku ?? 'Buku Dihapus' }}</div>
                        @endforeach
                    </td>
                    <td>
                        @php
                            $statusClass = match($row->status_peminjaman) {
                                'Dipinjam' => 'status-dipinjam',
                                'Dikembalikan' => 'status-kembali',
                                'Terlambat' => 'status-telat',
                                default => ''
                            };
                        @endphp
                        <span class="{{ $statusClass }}">{{ $row->status_peminjaman }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }} oleh {{ auth()->user()->username }}
    </div>
</body>
</html>