<div>
    <!-- Table Component -->

    <table class="min-w-auto divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">No Agenda</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Kode</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Keterangan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Jumlah Proposal</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Tanggal Proposal Masuk</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Nama Instansi</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Nama Pimpinan Organisasi</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Nama Pemohon</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Jenis Kelamin</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Nama Anak</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">NIK</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">TTL</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Alamat</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Kelurahan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Kecamatan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Pekerjaan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Jenis Permohonan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">No Telpon</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Jam Pengajuan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Yang Mengajukan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Tgl Penyerahan Proposal</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Tanggal Realisasi</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Nominal</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Keterangan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Sudah Dibantu</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight"></th>

            </tr>
        </thead>
        <tbody>
            @foreach($proposals as $proposal=>$value)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->kode }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->keterangan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->jml_proposal }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->tgl_masuk->toDateString() }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nm_instansi }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nm_pimpinan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nm_pemohon }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $value->jns_kelamin === 'L' ? 'Laki-laki' : ($value->jns_kelamin === 'P' ? 'Perempuan' : '') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nm_anak }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nik }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->ttl }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->alamat }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->kelurahan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->kecamatan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->pekerjaan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->jns_permohonan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->no_telp }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->jam_pengajuan->toTimeString() }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->pengaju }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->penyerahan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->realisasi }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nominal }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->keterangan_realisasi }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                    $statusOptions = [
                    '' => 'Semua Status',
                    '0' => 'Belum Diproses',
                    '1' => 'Sedang Diproses',
                    '2' => 'Sudah Dibantu'
                    ];
                    @endphp
                    {{ $statusOptions[$value->dibantu] ?? '' }}
                </td>
                @if (strpos(url()->current(),'excel') == false)
                <td class="px-6 py-4 whitespace-nowrap">
                    @if(auth()->check() && auth()->user()->role === 'super_admin')
                    <a href="{{route('proposal/edit', $value->id)}}" style="background-color: blue;" class="text-white font-bold py-1 px-2 rounded text-xs">Edit</a>
                    @if($value->dibantu != 1)
                        <a href="{{route('proposal/proses', $value->id)}}" style="background-color: yellow;" class="text-white font-bold py-1 px-2 rounded text-xs">Proses</a>
                    @endif
                    @endif
                    <a href="{{route('proposal/disposisi', $value->id)}}" style="background-color: teal;" class="text-white font-bold py-1 px-2 rounded text-xs">Disposisi</a>
                    @if(auth()->check() && auth()->user()->role === 'operator')
                    <a href="{{route('proposal/delete', $value->id)}}" class="bg-red-500 text-white font-bold py-1 px-2 rounded text-xs">Delete</a>
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Pagination -->