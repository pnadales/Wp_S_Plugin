document.addEventListener("DOMContentLoaded", function () {
  function actualizarTemporizador() {
    let inicio = getCookie("inicio_temporizador");
    if (!inicio) return;

    let tiempoActual = Math.floor(Date.now() / 1000);
    let contador = tiempoActual - parseInt(inicio);

    if (contador == 30) {
      alert("queda poco tiempo");
    } else if (contador == 60) {
      //   window.location.assign("TestWordpress/wordpress/exito-sesion-sence/");
    }
  }

  function getCookie(nombre) {
    let cookies = document.cookie.split("; ");
    for (let i = 0; i < cookies.length; i++) {
      let [clave, valor] = cookies[i].split("=");
      if (clave === nombre) return valor;
    }
    return null;
  }

  setInterval(actualizarTemporizador, 1000);
  actualizarTemporizador();
});
