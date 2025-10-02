<div>
    <!-- Table Component -->

    <table class="min-w-auto divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Nama</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Email</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight">Role</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-tight"></th>

            </tr>
        </thead>
        <tbody>
            @foreach($data as $akun=>$value)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ Str::mask($value->email, '*', -18 ,8) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $value->role }}</td>
                @if (strpos(url()->current(),'excel') == false)
                <td class="px-6 py-4 whitespace-nowrap">
                    @if(auth()->check() && auth()->user()->role === 'operator')
                        @if($value->role != 'admin')
                        <a href="{{route('settings/admin', $value->id)}}" style="background-color: blue;" class="text-white font-bold py-1 px-2 rounded text-xs">Admin</a>
                        @endif
                        @if($value->role != 'super_admin')
                        <a href="{{route('settings/super_admin', $value->id)}}" style="background-color: yellow;" class="text-white font-bold py-1 px-2 rounded text-xs">Super Admin</a>
                        @endif
                        @if($value->role != 'operator')
                        <a href="{{route('settings/operator', $value->id)}}" style="background-color: teal;" class="text-white font-bold py-1 px-2 rounded text-xs">Operator</a>
                        <a href="{{route('settings/account/delete', $value->id)}}" class="bg-red-500 text-white font-bold py-1 px-2 rounded text-xs">Delete</a>
                        @endif
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>