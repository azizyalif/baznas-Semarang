<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

            <!-- Dashboard actions -->
            <div class="sm:flex sm:justify-between sm:items-center mb-8">

                <!-- Left: Title -->
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Rekap Proposal Masuk BAZNAS Kota Semarang</h1>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Data Bantuan Proposal
                    </p>
                </div>

                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <a href="{{ route('jenis/export/excel') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                        <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="max-xs:sr-only">Export Excel</span>

                    </a>
                @endif
                </div>

            </div>
            <div>
                <div class="col-span-12 overflow-x-auto">
                    @include('rekaps.table-jenis')
                </div>
            </div>

        </div>
        
</x-app-layout>