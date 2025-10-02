<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <h3 class="text-2xl font-bold mb-2">Edit Proposal Permohonan</h3>
        <p class="text-gray-500 mb-6">Pastikan masukkan data dengan teliti.</p>


        <div id="exampleValidator">
            <form id="validation" action="{{ route('proposal/update', $proposal->id) }}" data-proposal-id="{{ $proposal->id }}" method="POST" class="space-y-8">
                @csrf
                <!-- Step 1: Detail Proposal -->
                @method('PUT')
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div>
                            <label class="block font-medium mb-1">No Agenda</label>
                            <input type="text" class="w-full border rounded px-3 py-2" required name="agenda" value="{{ old('agenda', $proposal->id ?? '') }}" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Kode</label>
                            <input type="text" required class="w-full border rounded px-3 py-2" name="kode" value="{{ old('kode', $proposal->kode ?? '') }}" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Keterangan</label>
                            <select class="w-full border rounded px-3 py-2" name="program" id="program" required>
                                <option value="">Pilih Keterangan</option>
                                @foreach ($program as $p)
                                <option value="{{ $p->id }}" {{ old('program') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_program }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Jumlah Proposal</label>
                            <input type="number" required class="w-full border rounded px-3 py-2" name="jumlah" value="{{ old('jumlah', $proposal->jml_proposal ?? '') }}" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Proposal Masuk</label>
                            <input type="date" required class="w-full border rounded px-3 py-2" name="proposalmasuk" value="{{ old('proposalmasuk', $proposal->tgl_masuk ?? '') }}" />
                        </div>
                    </div>
                </div>

                <div>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div>
                            <label class="block font-medium mb-1">Nama Instansi</label>
                            <input type="text" class="w-full border rounded px-3 py-2" name="instansi" value="{{ old('instansi', $proposal->nm_instansi ?? '') }}" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Pimpinan Organisasi</label>
                            <input type="text" class="w-full border rounded px-3 py-2" name="pimpinan" value="{{ old('pimpinan', $proposal->nm_pimpinan ?? '') }}" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nama Pemohon</label>
                            <input type="text" class="w-full border rounded px-3 py-2" name="pemohon" required value="{{ old('pemohon', $proposal->nm_pemohon ?? '') }}" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Jenis Kelamin</label>
                            <div class="flex space-x-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jk" value="P" required {{ old('jk') == 'P' ? 'checked' : '' }} class="form-radio">
                                    <span class="ml-2">Perempuan</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jk" value="L" required {{ old('jk') == 'L' ? 'checked' : '' }} class="form-radio">
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nama Anak</label>
                            <input type="text" class="w-full border rounded px-3 py-2" name="anak" value="{{ old('anak', $proposal->nm_anak ?? '') }}" />
                        </div>

                        <label class="block font-medium mb-1">NIK</label>
                        <input type="text" class="w-full border rounded px-3 py-2" name="nik" readonly value="{{ old('nik', $proposal->nik ?? '') }}" />
                        <small class="text-gray-400">NIK dengan tambahan 0 berarti belum pernah Mengajukan</small>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">TTL</label>
                        <input type="text" class="w-full border rounded px-3 py-2" name="ttl" required value="{{ old('ttl', $proposal->ttl ?? '') }}" />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Alamat</label>
                        <input type="text" class="w-full border rounded px-3 py-2" name="alamat" required value="{{ old('alamat', $proposal->alamat ?? '') }}" />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Kecamatan</label>
                        <select class="w-full border rounded px-3 py-2" name="kecamatan" id="kecamatan" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatan as $kec)
                            <option value="{{ $kec->id }}" {{ old('kecamatan') == $kec->id ? 'selected' : ''}}>
                                {{ $kec->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Kelurahan</label>
                        <select class="w-full border rounded px-3 py-2" name="kelurahan" id="kelurahan" required>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Pekerjaan</label>
                        <select class="w-full border rounded px-3 py-2" name="kerja" id="kerja" required>
                            <option value="">Pilih Pekerjaan</option>
                            @foreach ($pekerjaan as $k)
                            <option value="{{ $k->id }}" {{ old('kerja') == $k->id ? 'selected' : ''}}>
                                {{ $k->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Jenis Permohonan</label>
                        <select class="w-full border rounded px-3 py-2" name="jenisPermohonan" id="jenisPermohonan" required>
                            <option value="">Pilih Jenis Permohonan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">No Telpon</label>
                        <input type="text" class="w-full border rounded px-3 py-2" name="hp" required value="{{ old('hp', $proposal->no_telp ?? '') }}" />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Jam Pengajuan</label>
                        <input type="time" class="w-full border rounded px-3 py-2" name="waktu" required value="{{ old('waktu', $proposal->jam_pengajuan ?? '') }}" />
                    </div>
                </div>
        </div>

        <!-- Step 3: Lanjutan -->
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium mb-1">Yang Mengajukan</label>
                    <input class="w-full border rounded px-3 py-2" name="pengaju" required value="{{ old('pengaju', $proposal->pengaju ?? '') }}" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Tgl Penyerahan Proposal</label>
                    <input class="w-full border rounded px-3 py-2" name="penyerahan" value="{{ old('penyerahan', $proposal->penyerahan ?? '') }}" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Realisasi</label>
                    <input class="w-full border rounded px-3 py-2" name="realisasi" value="{{ old('realisasi', $proposal->realisasi ?? '') }}" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Nominal</label>
                    <input class="w-full border rounded px-3 py-2" name="nominal" required value="{{ old('nominal', $proposal->nominal ?? '') }}" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Keterangan</label>
                    <input class="w-full border rounded px-3 py-2" name="ket_realisasi" value="{{ old('ket_realisasi', $proposal->keterangan_realisasi ?? '') }}" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Dibantu</label>
                    <input class="w-full border rounded px-3 py-2" name="follup" value="{{ old('follup', $proposal->dibantu ?? '') }}" />
                    <small class="text-gray-400">0=Belum diproses, 1=Dalam proses, 2=Dibantu</small>
                </div>
            </div>
        </div>

        <input type="hidden" name="submit" value="1" />
        <div class="mt-8">
            <button style="background-color: blue;" type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Submit</button>
        </div>
        </form>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var kelurahanData = JSON.parse('{!! addslashes(json_encode($kelurahan)) !!}');


            document.getElementById('kecamatan').addEventListener('change', function() {
                var kecamatanId = this.value;
                var kelurahanSelect = document.getElementById('kelurahan');
                kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';

                kelurahanData.forEach(function(kel) {
                    if (kel.id_kecamatan == kecamatanId) {
                        var opt = document.createElement('option');
                        opt.value = kel.id;
                        opt.text = kel.nama;
                        kelurahanSelect.appendChild(opt);
                    }
                });
            });

            // Data jenis permohonan dari server
            var jenisPermohonanData = JSON.parse('{!! addslashes(json_encode($jenisPermohonan)) !!}');

            // Handle program change
            document.getElementById('program').addEventListener('change', function() {
                var programId = this.value;
                var jenisSelect = document.getElementById('jenisPermohonan');
                jenisSelect.innerHTML = '<option value="">Pilih Jenis Permohonan</option>';

                jenisPermohonanData.forEach(function(item) {
                    if (item.id_program == programId) {
                        var opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.jns_bantuan;
                        jenisSelect.appendChild(opt);
                    }
                });
            });

            // Handle form submission via AJAX
            document.getElementById('validation').addEventListener('submit', function(e) {

                e.preventDefault();

                var formData = new FormData(this);
                var alertContainer = document.getElementById('alert-container');
                var proposalId = this.dataset.proposalId;
                fetch(`{{ url('proposal/update') }}/${proposalId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'success') {
                            alertContainer.innerHTML = '<div class="alert alert-success">Data berhasil disimpan!</div>';
                            this.reset();
                            setTimeout(() => {
                                window.location.href = '{{ route("proposal") }}';
                            }, 1500);
                        } else if (data.error) {
                            alertContainer.innerHTML = '<div class="alert alert-danger">' + data.error + '</div>';
                        } else if (data.errors) {
                            var errorHtml = '<div class="alert alert-danger"><ul>';
                            Object.values(data.errors).forEach(function(error) {
                                errorHtml += '<li>' + error + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            alertContainer.innerHTML = errorHtml;
                        }
                    })
                    .catch(error => {
                        alertContainer.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan: ' + error.message + '</div>';
                    });
            });
        });
    </script>


</x-app-layout>