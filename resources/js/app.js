import "./bootstrap";

window.Echo.channel("uids").listen("getUid", (e) => {
    // Mendengarkan event dan memperbarui input text
    document.getElementById("uid").value = e.uid;
});
