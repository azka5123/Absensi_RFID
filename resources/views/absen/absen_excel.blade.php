 <div class="table-responsive">
     @php
         use Carbon\Carbon;
         setlocale(LC_TIME, 'id_ID.utf8');
         $now = Carbon::now();
         $bulan = $now->subMonths(1)->isoFormat('MMMM');
     @endphp
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
         <tr>
             <td colspan="7" rowspan="2" align="center">Rekap Absensi bulan
                 {{ $bulan }}</td>
         </tr>
         <tr>
             <td></td>
         </tr>

         <tr>
             <th>Nama Siswa</th>
             <th>Kelas</th>
             <th>Jurusan</th>
             <th>Jam Masuk</th>
             <th>Jam Keluar</th>
             <th>Keterangan</th>
             <th>Izin</th>
         </tr>
         <tbody>
             @foreach ($absen as $data)
                 <tr>
                     <td>{{ $data->rStudent->name }}</td>
                     <td>{{ $data->rStudent->kelas }}</td>
                     <td>{{ $data->rStudent->jurusan }}</td>
                     <td>
                         @if ($data->jam_masuk != null)
                             {{ Carbon::parse($data->jam_masuk)->format('d-m-Y / H:i') }}
                         @else
                             {{ $data->jam_masuk }}
                         @endif
                     </td>
                     <td>
                         @if ($data->jam_keluar != null)
                             {{ Carbon::parse($data->jam_keluar)->format('d-m-Y / H:i') }}
                         @else
                             {{ $data->jam_keluar }}
                         @endif
                     </td>
                     <td>{{ $data->keterangan }}</td>
                     <td>{{ $data->izin }}</td>
                 </tr>
             @endforeach
         </tbody>
     </table>
 </div>
