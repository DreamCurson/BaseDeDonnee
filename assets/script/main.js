document.addEventListener("DOMContentLoaded", () => {
  const deleteBtn = document.querySelector(".formulaireUtilisateur__delete");
  const confirmBtn = document.querySelector(
    ".formulaireUtilisateur__confirmation"
  );

  deleteBtn.addEventListener("click", () => {
    confirmBtn.style.display = "inline-block";
    deleteBtn.style.display = "none";
  });
});
