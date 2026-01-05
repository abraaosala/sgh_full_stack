
async function sair() {
  const confirm = await Swal.fire({
    title: "Tem certeza?",
    text: "Deseja realmente sair do sistema?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sim, Sair",
    cancelButtonText: "Cancelar",
    // customClass: {
    //   popup: "small-sweetalert", // Classe do popup
    //   confirmButton: " swal2-confirm btn-swal-primary", // Botão de confirmação
    //   cancelButton: "btn-secondary swal2-cancel", // Botão de cancelamento
    // },
    // buttonsStyling: false, // Desativa o estilo padrão do SweetAlert
  });

  if (confirm.isConfirmed) {
    try {
      const response = await fetch("/sair", {
        method: "POST",
      });

      const result = await response.json();

      if (result.status) {
        console.log(result.msg);
        // setTimeout(() => {
          location.href = result.redirect;
        // }, 2000);
      }
    } catch (error) {
      console.error("Erro ao realizar logout:", error);
      Swal.fire(
        "Erro",
        "Não foi possível realizar o logout. Tente novamente mais tarde.",
        "error"
      );
    }
  } else {
    Swal.fire("Cancelado", "Você permaneceu no sistema.", "info");
  }
}
const logoutCont = document.querySelector(".sair");

logoutCont.addEventListener("click", async function () {
  const confirm = await Swal.fire({
    title: "Tem certeza?",
    text: "Deseja realmente sair do sistema?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sim, sair",
    cancelButtonText: "Cancelar",
    customClass: {
      popup: "small-sweetalert", // Classe do popup
      confirmButton: " swal2-confirm btn-swal-primary", // Botão de confirmação
      cancelButton: "btn-secondary swal2-cancel", // Botão de cancelamento
    },
    buttonsStyling: false, // Desativa o estilo padrão do SweetAlert
  });

  if (confirm.isConfirmed) {
    try {
      const response = await fetch("/sair", {
        method: "POST",
      });

      const result = await response.json();

      if (result.status) {
        console.log(result.msg);
        setTimeout(() => {
          location.href = result.redirect;
        }, 2000);
      }
    } catch (error) {
      console.error("Erro ao realizar logout:", error);
      Swal.fire(
        "Erro",
        "Não foi possível realizar o logout. Tente novamente mais tarde.",
        "error"
      );
    }
  } else {
    Swal.fire("Cancelado", "Você permaneceu no sistema.", "info");
  }
  /*
   */
});

$(document).ready(function() {
  $('.select2').select2(/* {
    width: '100%' // Define a largura para 100%
  } */);
});