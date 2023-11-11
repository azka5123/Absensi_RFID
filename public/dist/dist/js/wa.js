// URL API dan endpoint yang ingin Anda akses
const apiUrl = "http://localhost:5001";
const endpoint = "/start-session?session=nomorazka&scan=true";

// Fetch data dari API
fetch(apiUrl + endpoint, {
  method: "GET",
})
  .then((response) => {
    if (!response.ok) {
      throw new Error("Gagal mengambil data dari API");
    }
    return response.json();
  })
  .then((data) => {
    // Simpan data dalam sesi JavaScript
    sessionStorage.setItem("apiData", JSON.stringify(data));
  })
  .catch((error) => {
    console.error(error);
  });
