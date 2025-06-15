import "./bootstrap";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

window.Echo.channel("admin-channel").listen("RequestHelpCreated", (e) => {
    showToast(
        "Permintaan bantuan baru dari " +
            (e.label ?? e.requestHelp.ip_address ?? "user")
    );
});

// Simple toast
window.showToast = function (msg) {
    let toast = document.createElement("div");
    toast.innerText = msg;
    toast.className = toast.className =
        "fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-blue-700 text-white px-6 py-3 rounded shadow-lg animate-bounce";
    document.body.appendChild(toast);

    // Play notification sound
    let audio = document.createElement("audio");
    audio.src = "/sound/notif1.wav"; // file Anda sendiri
    audio.autoplay = true;
    audio.style.display = "none";
    document.body.appendChild(audio);

    setTimeout(() => {
        toast.remove();
        audio.remove();
    }, 20000);
};
