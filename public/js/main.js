$(document).ready(function () {
  $(".header-menu").click(function () {
    $(".navbar-content").toggleClass("show");
  });
  // Elemen-elemen DOM
  const openModalBtn = document.getElementById("openModal");
  const modalOverlay = document.getElementById("modalOverlay");
  const modalContainer = document.getElementById("modalContainer");
  const closeModalBtn = document.getElementById("closeModal");
  const cancelBtn = document.getElementById("cancelBtn");

  // Fungsi untuk membuka modal utama
  function openModal() {
    modalOverlay.classList.remove("hidden");
    modalOverlay.classList.add("flex");
    setTimeout(() => {
      modalContainer.classList.remove("scale-95", "opacity-0");
      modalContainer.classList.add("scale-100", "opacity-100");
    }, 10);
  }

  // Fungsi untuk menutup modal utama
  function closeModal() {
    modalContainer.classList.remove("scale-100", "opacity-100");
    modalContainer.classList.add("scale-95", "opacity-0");
    setTimeout(() => {
      modalOverlay.classList.add("hidden");
      modalOverlay.classList.remove("flex");
    }, 300);
  }

  // Event listeners
  if (openModalBtn != null) openModalBtn.addEventListener("click", openModal);
  if (cancelBtn != null) cancelBtn.addEventListener("click", closeModal);

  // Menutup modal saat overlay diklik
  if (modalOverlay != null) {
    modalOverlay.addEventListener("click", (e) => {
      if (e.target === modalOverlay) {
        closeModal();
      }
    });
  }

  // Menutup modal dengan tombol ESC
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      if (!modalOverlay.classList.contains("hidden")) {
        closeModal();
      }
    }
  });

  // menambahkan nama file saat upload file
  // document.getElementById("fileInput").addEventListener("change", function (e) {
  //   const file = e.target.files[0];
  //   const fileName = document.getElementById("fileName");
  //   const fileNameText = document.getElementById("fileNameText");

  //   if (file) {
  //     fileNameText.textContent = file.name;
  //     fileName.classList.remove("hidden");
  //   } else {
  //     fileName.classList.add("hidden");
  //   }
  // });

});
