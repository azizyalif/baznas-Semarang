<div>
    <!-- Table Component -->

    <table class="min-w-auto divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">No Agenda</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">NIK</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Nama Pemohon</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Bantuan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Tahun</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item=>$value)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nik }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->nama }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->bantuan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->tahun }}</td>
                @if (strpos(url()->current(),'excel') == false)
                <td class="px-6 py-4 whitespace-nowrap">
                    @if(auth()->check() && auth()->user()->role === 'operator')
                    <a href="{{route('arsip/delete', $value->id)}}" class="bg-red-500 text-white font-bold py-1 px-2 rounded text-xs">Delete</a>
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Pagination -->