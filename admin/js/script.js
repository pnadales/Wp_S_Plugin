//Modal
document.addEventListener("DOMContentLoaded", () => {
  function setModalView(overflow, zindex, state) {
    document.body.style.overflow = overflow;
    modalOtec.style.display = state == true ? "block" : "none";
    modalOtec.style.zIndex = zindex;
    modalBack.style.zIndex = zindex - 1;
  }
  function emptyInput() {
    const inputs = document.querySelectorAll(".my-inputs");
    inputs.forEach((input) => {
      input.value = "";
      input.readOnly = false;
      if (input.classList.value.includes("aux-input")) {
        input.style.display = "none";
        input.disabled = true;
      }
    });
    const selectM = document.querySelectorAll(".modal-select");
    if (selectM) {
      selectM.forEach((select) => {
        select.value = "";
        select.style.display = "block";
      });
    }
  }
  const showModal = document.getElementById("btn-add");
  const modalOtec = document.getElementById("modal");
  const btnClose = document.getElementById("closeM");
  const modalCard = document.getElementById("modal-card");
  const modalBack = document.getElementById("modal-background");
  if (showModal) {
    showModal.addEventListener("click", function () {
      emptyInput();
      const submitModal = document.getElementById("submit-modal");
      submitModal.value = "Guardar";
      submitModal.name = `save-${page}`;
      setModalView("hidden", 100, true);
    });
  }
  btnClose.addEventListener("click", function (event) {
    event.preventDefault();
    setModalView("auto", -1, false);
  });
  modalOtec.addEventListener("click", function (event) {
    if (!modalCard.contains(event.target)) {
      setModalView("auto", -1, false);
    }
  });
  modalBack.addEventListener("click", function () {
    setModalView("auto", -1, false);
  });
  //   setModalView("hidden", 100, true);

  //Para Otec
  const deleteOtecButtons = document.querySelectorAll(".btn-delete-otec");
  deleteOtecButtons.forEach((deleteB) => {
    deleteB.addEventListener("click", function () {
      const otecId = this.dataset.id;
      if (confirm("¿Quieres eliminar?")) {
        fetch(SolicitudesAjax.url, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            action: "eliminarOtec",
            nonce: SolicitudesAjax.seguridad,
            id: otecId,
          }).toString(),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
          })
          .then(() => {
            location.reload();
          })
          .catch((error) => {
            console.error("Error en la solicitud:", error);
          });
      }
    });
  });

  const editOtecButtons = document.querySelectorAll(".btn-edit");
  // editOtecButtons.forEach((editB) => {
  //   editB.addEventListener("click", function () {
  //     const otecId = this.dataset.id;
  //     document.getElementById("rut_otec").value = otecId;
  //     document.getElementById("rut_otec").readOnly = true;
  //     document.getElementById("nombre_otec").value = otecs[otecId].nombre_otec;
  //     document.getElementById("token").value = otecs[otecId].token;
  //     setModalView("hidden", 100, true);
  //   });
  // });

  editOtecButtons.forEach((editB) => {
    editB.addEventListener("click", function () {
      const submitModal = document.getElementById("submit-modal");
      submitModal.value = "Actualizar";
      submitModal.name = `update-${page}`;
      const tInputs = document.querySelectorAll(".my-inputs");
      tInputs.forEach((input) => {
        input.value = modal_data[editB.dataset.id][input.name];
        input.readOnly = editB.dataset.id.split("/").includes(input.value)
          ? true
          : false;
      });
      const selectM = document.querySelectorAll(".modal-select");
      if (selectM) {
        selectM.forEach((select) => {
          select.value = modal_data[editB.dataset.id][select.name];
          if (editB.dataset.id.split("/").includes(select.value)) {
            const input = document.querySelector(`input[name=${select.name}]`);
            input.value = select.value;
            input.readOnly = true;
            select.desabled = true;
            select.style.display = "none";
          }
        });
      }

      // console.log(JSON.parse(this.dataset.id));
      // console.log(modal_data);
      // console.log(Object.keys(modal_data));
      setModalView("hidden", 100, true);
    });
  });
});
