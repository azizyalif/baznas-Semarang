<x-app-layout>
    <div>
        <h3 class="font-bold m-t-0" style="text-align: center;">Lembar Disposisi</h3>
    </div>

    <div class="container-disposisi" style="max-width: 800px; margin: 0 auto; background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <div class="header" style="text-align: center; margin-bottom: 20px;">
            <div class="logo">
                <img src="{{ asset('apple-touch-icon.png') }}" style="width: 70px; height: 70px; margin: 0 auto 2px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
            </div>
            <div class="sub-title" style="font-size: 12px;color: #666;">KOTA SEMARANG</div>
        </div>

        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 14px;
            }

            td,
            th {
                border: 2px solid #000;
                padding: 8px;
                vertical-align: top;
            }

            .header-row {
                background-color: #f9f9f9;
            }

            .label-col {
                width: 20%;
                font-weight: bold;
            }

            .content-col {
                width: 30%;
            }

            .separator {
                width: 5%;
                text-align: center;
                font-weight: bold;
            }

            .value-col {
                width: 45%;
            }

            .large-content {
                text-align: left;
                font-weight: bold;
                padding: 15px;
            }

            .disposition-header {
                text-align: center;
                font-weight: bold;
                background-color: #f0f0f0;
                padding: 10px;
            }

            .disposition-row {
                height: 80px;
            }

            .disposition-label {
                text-align: center;
                font-weight: bold;
                width: 33.33%;
            }
        </style>

        <table>
            <tr class="header-row">
                <td class="label-col">Surat dari</td>
                <td class="separator">:</td>
                <td class="content-col">{{ $surat }}</td>
                <td class="label-col">Diterima tanggal</td>
                <td class="separator">:</td>
                <td class="value-col">{{ $tanggalFormat }}</td>
            </tr>
            <tr class="header-row">
                <td class="label-col">Nomor Surat</td>
                <td class="separator">:</td>
                <td class="content-col"></td>
                <td class="label-col">No. Agenda</td>
                <td class="separator">:</td>
                <td class="value-col">{{ $proposal->id }}</td>
            </tr>
            <tr>
                <td class="label-col">Perihal</td>
                <td class="separator">:</td>
                <td colspan="4" class="large-content">
                    {{ $perihal }}<br><br>
                    {{ $almt }}
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="disposition-header" colspan="3">ISI DISPOSISI</td>
            </tr>
            <tr>
                <td class="disposition-label">Ketua</td>
                <td class="disposition-label">Kepala Pelaksana</td>
                <td class="disposition-label">Kabag. Administrasi</td>
            </tr>
            <tr class="disposition-row" >
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; color:white; margin: 20px 0;">
        <button style="background-color: blue;" type="button" class="btn btn-primary" onclick="printDisposisi()">
        Cetak Disposisi
        </button>
    </div>

    <script>
        function printDisposisi() {
            var originalContents = document.body.innerHTML;
            var disposisiContent = document.querySelector('.container-disposisi');

            if (disposisiContent) {
                var printContents = `
            <div style="font-family: Arial, sans-serif;">
                ${disposisiContent.innerHTML}
            </div>
            <style>
                @media print {
                    body { margin: 0; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px; }
                    td, th { border: 2px solid #000; padding: 8px; vertical-align: top; }
                    .header-row { background-color: #f9f9f9; }
                    .label-col { width: 20%; font-weight: bold; }
                    .content-col { width: 30%; }
                    .separator { width: 5%; text-align: center; font-weight: bold; }
                    .value-col { width: 45%; }
                    .large-content { text-align: left; font-weight: bold; padding: 15px; }
                    .disposition-header { text-align: center; font-weight: bold; background-color: #f0f0f0; padding: 10px; }
                    .disposition-row { height: 80px; }
                    .disposition-label { text-align: center; font-weight: bold; width: 33.33%; }
                }
            </style>
            `;

                document.body.innerHTML = printContents;
                window.print();

                setTimeout(function() {
                    document.body.innerHTML = originalContents;
                }, 1000);
            } else {
                alert('Konten disposisi tidak ditemukan!');
            }
        }
    </script>
</x-app-layout>