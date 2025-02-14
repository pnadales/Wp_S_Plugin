const show_time_modal = (message) => {
  const modal = document.createElement("div");
  modal.classList.add("modal");
  modal.id = "sence-time-modal";

  const modalContent = document.createElement("div");
  modalContent.classList.add("modal-content");

  const closeButton = document.createElement("span");
  closeButton.classList.add("close-button");
  closeButton.innerHTML = "&times;";

  const modalText = document.createElement("p");
  modalText.textContent = message;

  modalContent.appendChild(closeButton);
  modalContent.appendChild(modalText);
  modal.appendChild(modalContent);

  document.body.appendChild(modal);

  modal.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
  closeButton.addEventListener("click", () => {
    modal.style.display = "none";
  });
};
