$(document).ready(function () {
  // Menginisialisasi DataTable
  var table = $("#example1").DataTable();

  // Menambahkan event click pada setiap elemen dropdown-item
  $(".dropdown-item").on("click", function () {
    var selectedKelas = $(this).data("kelas");

    // Menghapus semua baris yang ada di tabel
    table.clear();

    $("#dropdownMenuButton").on("change", function () {
      var selectedValue = $(this).val();
      table.order([selectedValue, "asc"]).draw();
    });

    // // Mengambil data siswa berdasarkan kelas yang dipilih
    // $.ajax({
    //   url: "/kelas/tkj/" + selectedKelas, // Ganti dengan URL yang sesuai
    //   type: "GET",
    //   success: function (data) {
    //     // Memasukkan data siswa ke dalam tabel
    //     $.each(data, function (index, item) {
    //       table.row
    //         .add([
    //           item.rStudent.name,
    //           item.rStudent.kelas,
    //           item.rStudent.jurusan,
    //           item.jam_masuk,
    //           item.jam_keluar,
    //           item.keterangan,
    //           item.izin,
    //         ])
    //         .draw();
    //     });
    //   },
    //   error: function () {
    //     alert("Terjadi kesalahan saat mengambil data siswa.");
    //   },
    // });
  });
});
