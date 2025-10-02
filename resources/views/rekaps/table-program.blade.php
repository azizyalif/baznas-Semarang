<div>
    <table class="min-w-auto divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">KODE</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Jenis Bantuan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">TOTAL Proposal</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Total Sudah Dibantu</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Jumlah Proposal yang Belum Masuk Arsip</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total_proposal_accum = 0;
            $total_dibantu_accum = 0;
            $total_belum_arsip_accum = 0;
            @endphp

            @foreach ($rekaps as $rekap)
            @php
            $total_proposal_accum += $rekap->total_proposal;
            $total_dibantu_accum += $rekap->total_dibantu;
            $total_belum_arsip_accum += $rekap->total_belum_arsip;
            @endphp
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $rekap->kode }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $rekap->nama_program }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $rekap->total_proposal }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $rekap->total_dibantu }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $rekap->total_belum_arsip }}</td>
            </tr>
            @endforeach

            <tr>
                <td class="px-6 py-4 whitespace-nowrap" colspan="2" style="text-align:center;">Total</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $total_proposal_accum }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $total_dibantu_accum }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $total_belum_arsip_accum }}</td>
            </tr>

            <tr>
                <td class="px-6 py-4 whitespace-nowrap" colspan="2" style="text-align:center;">Total Keseluruhan</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $total_proposal }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $total_dibantu }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $total_belum_arsip }}</td>
            </tr>
        </tbody>
    </table>
     {{-- Pagination --}}
     @if (strpos(url()->current(),'excel') == false)
    <nav aria-label="Page navigation">
        {{ $rekaps->links() }}
    </nav>
    @endif
</div>

   