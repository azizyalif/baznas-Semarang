<div>
    <table class="min-w-auto divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight"></th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Jenis Bantuan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Total</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Januari</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Februari</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Maret</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">April</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Mei</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Juni</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Juli</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Agustus</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">September</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Oktober</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">November</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Desember</th>
            </tr>
        </thead>
        <tbody>
            @php
                $lastProgram = '';
                $rowspans = [];
                // Hitung rowspan untuk setiap program
                foreach ($data as $item) {
                    $rowspans[$item['nama_program']] = ($rowspans[$item['nama_program']] ?? 0) + 1;
                }
            @endphp

            @foreach ($data as $item)
                <tr>
                    @if ($item['nama_program'] !== $lastProgram)
                        @php
                            $bgColors = [
                                'background-color: #000072',
                                'background-color: #87CEEB',
                                'background-color: #000072',
                                'background-color: #87CEEB',
                                'background-color: #000072',
                            ];
                            $programIndex = array_search($item['nama_program'], array_keys($rowspans));
                            $bgColor = $bgColors[$programIndex % count($bgColors)];
                        @endphp
                        <td class="px-6 py-4 text-center text-white font-bold" style="{{ $bgColor }}" rowspan="{{ $rowspans[$item['nama_program']] }}">
                            {{ $item['nama_program'] }}
                        </td>
                        @php $lastProgram = $item['nama_program']; @endphp
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['jns_bantuan'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['total'] }}</td>
                    @foreach ($item['bulan_counts'] as $jumlah)
                        <td class="px-6 py-4 whitespace-nowrap">{{ $jumlah }}</td>
                    @endforeach
                </tr>
            @endforeach

            <tr style="text-align:center;">
                <td class="px-6 py-4 whitespace-nowrap" style="text-align:center; font-size:24px;" colspan="2">TOTAL</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $grandTotal }}</td>
                @foreach ($grandBulanCounts as $jumlah)
                    <td class="px-6 py-4 whitespace-nowrap">{{ $jumlah }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
     {{-- Pagination --}}
    <nav aria-label="Page navigation">
        @if (is_object($data) && method_exists($data, 'links'))
            {{ $data->links() }}
        @endif
    </nav>
</div>

   