document.addEventListener("DOMContentLoaded", function () {
  function updateTimer() {
    let start = getCookie("inicio_temporizador");
    if (!start) return;
    let solicitud = getCookie("solicitud");
    if (solicitud) return;

    let currentTime = Math.floor(Date.now() / 1000);
    let counter = currentTime - parseInt(start);
    const total_time = 45 * 60;
    const alert_time = 30 * 60;
    console.log(counter);

    if (counter >= total_time) {
      if (typeof redirected === "undefined") {
        show_time_modal(`Se cerrará la sesión!`);

        redirectToPost(
          "http://localhost/TestWordpress/wordpress/exito-sesion-sence/",
          { logout_redirect: true }
        );
      }
    } else if (counter == alert_time) {
      const timeLeft = Math.floor((total_time - alert_time) / 60);
      show_time_modal(`Quedan ${timeLeft} minutos para cerrar la sesión!`);
    }
  }

  function getCookie(nombre) {
    let cookies = document.cookie.split("; ");
    for (let i = 0; i < cookies.length; i++) {
      let [key, value] = cookies[i].split("=");
      if (key === nombre) return value;
    }
    return null;
  }

  function redirectToPost(url, data) {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = url;

    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = data[key];
        form.appendChild(input);
      }
    }

    document.body.appendChild(form);
    form.submit();
  }

  setInterval(updateTimer, 1000);
  updateTimer();

  if (typeof redirected !== "undefined") {
    show_time_modal("Será redirigido al Sence al hacer click");
    document.body.addEventListener("click", () => {
      const form = document.getElementById("salir-sence");
      document.cookie = "solicitud=salir-sence; path=/; max-age=300";
      form.submit();
    });
  }
});
