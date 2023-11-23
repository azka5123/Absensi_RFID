const mqtt_broker = "broker.hivemq.com";
const mqtt_port = 8000;
const mqttTopic = "uid_topic";

const clientId = "webClient_" + new Date().getTime();
const client = new Paho.MQTT.Client(mqtt_broker, mqtt_port, clientId);

client.onConnectionLost = onConnectionLost;
client.onMessageArrived = onMessageArrived;

const options = {
  onSuccess: onConnect,
  onFailure: onFailure,
};

client.connect(options);

function onConnect() {
  console.log("Connected to MQTT broker");
  client.subscribe(mqttTopic);
}

function onFailure(message) {
  console.log("Connection failed: " + message.errorMessage);
}

function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("Connection lost: " + responseObject.errorMessage);
  }
}

function onMessageArrived(message) {
  const uid = message.payloadString;
  console.log("Received UID: " + uid);
  $("#uid").val(uid);
}
// // Membuat objek WebSocket
// var socket = new WebSocket("ws://127.0.0.1:6001/app/ABCDEFG"); // Ganti dengan alamat server WebSocket Anda

// // Ketika koneksi berhasil dibuka
// socket.addEventListener("open", (event) => {
//   console.log("Koneksi WebSocket terbuka.");
// });

// // Ketika pesan diterima dari server
// socket.addEventListener("message", (event) => {
//   var uid = event.data; // Data UID yang diterima dari server
//   console.log("UID diterima: " + uid);

//   // Tampilkan UID di halaman web (misalnya, dalam elemen dengan ID "uidDisplay")
//   document.getElementById("uid").value = uid;
// });

// // Ketika koneksi ditutup
// socket.addEventListener("close", (event) => {
//   console.log("Koneksi WebSocket ditutup.");
// });

// // Ketika terjadi kesalahan
// socket.addEventListener("error", (event) => {
//   console.error("Terjadi kesalahan dalam koneksi WebSocket: " + event.message);
// });
