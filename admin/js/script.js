//Modal
document.addEventListener("DOMContentLoaded", () => {
  function setModalView(overflow, zindex, state) {
    document.body.style.overflow = overflow;
    modalOtec.style.display = state == true ? "block" : "none";
    modalOtec.style.zIndex = zindex;
    modalBack.style.zIndex = zindex - 1;
  }
  const showModal = document.getElementById("btn-add-otec");
  const modalOtec = document.getElementById("modal-otec");
  const btnClose = document.getElementById("closeM");
  const modalCard = document.getElementById("otec-card");
  const modalBack = document.getElementById("modal-background");
  showModal.addEventListener("click", function () {
    setModalView("hidden", 100, true);
  });
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
});
