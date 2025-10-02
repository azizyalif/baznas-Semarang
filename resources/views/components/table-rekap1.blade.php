<div>
    <table class="table table-bordered" style="margin-bottom:40px;">
        <thead>
            <tr>
                <th class="kode-col">KODE</th>
                <th class="jenis-col">Jenis Bantuan</th>
                <th class="number-col">TOTAL Proposal</th>
                <th class="number-col">Total Sudah Dibantu</th>
                <th class="number-col">Jumlah Proposal yang Belum Masuk Arsip</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total_proposal_accum = 0;
            $total_dibantu_accum = 0;
            $total_belum_arsip_accum = 0;
            @endphp

            @foreach ($data as $rekap)
            @php
            $total_proposal_accum += $rekap->total_proposal;
            $total_dibantu_accum += $rekap->total_dibantu;
            $total_belum_arsip_accum += $rekap->total_belum_arsip;
            @endphp
            <tr>
                <td>{{ $rekap->kode }}</td>
                <td class="jenis-col">{{ $rekap->nama_program }}</td>
                <td>{{ $rekap->total_proposal }}</td>
                <td>{{ $rekap->total_dibantu }}</td>
                <td>{{ $rekap->total_belum_arsip }}</td>
            </tr>
            @endforeach

            <tr style="font-weight:bold;background:#f5f5f5;">
                <td colspan="2" style="text-align:center;">TOTAL (Halaman ini)</td>
                <td>{{ $total_proposal_accum }}</td>
                <td>{{ $total_dibantu_accum }}</td>
                <td>{{ $total_belum_arsip_accum }}</td>
            </tr>

            <tr style="font-weight:bold;background:#ddd;">
                <td colspan="2" style="text-align:center;">TOTAL (Semua Data)</td>
                <td>{{ $total_proposal }}</td>
                <td>{{ $total_dibantu }}</td>
                <td>{{ $total_belum_arsip }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Pagination --}}
    <nav aria-label="Page navigation">
        {{ $rekaps->links() }}
    </nav>
</div>