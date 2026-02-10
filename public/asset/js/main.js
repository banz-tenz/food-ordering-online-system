//DOM
const useremail = document.getElementById("email");
const password = document.getElementById("password");
const confirmpassword = document.getElementById("confirmpw");
const form = document.getElementById("form");
const pwerror = document.getElementById("errorPs");
const emerror = document.getElementById("erroremail");
const confirmpwerror = document.getElementById("errorPasCf");

password.addEventListener("input", () => {
  if (password.value.length < 8) {
    pwerror.classList.remove("invisible");
  } else {
    pwerror.classList.add("invisible");
  }
});

confirmpassword.addEventListener("input", () => {
  if (password.value !== confirmpassword.value) {
    confirmpwerror.classList.remove("invisible");
  } else {
    confirmpwerror.classList.add("invisible");
  }
});

useremail.addEventListener("input", () => {
  if (useremail.value.includes("@")) {
    emerror.classList.add("invisible");
  } else {
    emerror.classList.remove("invisible");
  }
});

function openDeleteModal(id) {
  const modal = document.getElementById("deleteModal");
  const confirmBtn = document.getElementById("confirmDeleteBtn");
  // Set the delete link dynamically
  confirmBtn.href = "/admin/category/delete?id=" + id;
  modal.classList.remove("hidden");
  modal.classList.add("flex");
}

function closeDeleteModal() {
  const modal = document.getElementById("deleteModal");
  modal.classList.add("hidden");
  modal.classList.remove("flex");
}


