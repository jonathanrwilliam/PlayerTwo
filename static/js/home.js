// Alternar a visibilidade dos botões ocultos de filtro
$(document).ready(function () {
  $("#filtroButton").click(function () {
    console.log("Botão de filtro clicado");
    $(".botoes").toggle();
    $(".campoIdade").toggle();
  });
});

// Alternar a visibilidade dos cards de jogos
$(document).ready(function () {
  $("#btnJogos").click(function () {
    console.log("Botão de jogos clicado");
    $("#Cards").toggle();
  });
});

//Código para ocultar/exibir conteúdo de Convites e Conversas em telas pequenas
document.addEventListener("DOMContentLoaded", function () {
  // Elementos da seção de Convites, Emails e Principal
  var convitesSection = document.getElementById("Convites");
  var emailsSection = document.getElementById("Conversas");
  var principalSection = document.getElementById("Principal");

  // Função para controlar a visibilidade das seções
  function toggleSections() {
    if (window.innerWidth < 992) { // Tela pequena
      convitesSection.classList.add("d-none");
      emailsSection.classList.add("d-none");
      principalSection.classList.remove("d-none");
    } else { // Tela grande
      convitesSection.classList.remove("d-none");
      emailsSection.classList.remove("d-none");
      principalSection.classList.remove("d-none");
    }
  }

  // Inicialmente, ajustar a visibilidade com base no tamanho da tela
  toggleSections();

  // Botão de Convites
  document.getElementById("showConvites").addEventListener("click", function (event) {
    event.preventDefault();
    convitesSection.classList.remove("d-none");
    emailsSection.classList.add("d-none");
    principalSection.classList.add("d-none");
  });

  // Botão de Emails
  document.getElementById("showConversas").addEventListener("click", function (event) {
    event.preventDefault();
    convitesSection.classList.add("d-none");
    emailsSection.classList.remove("d-none");
    principalSection.classList.add("d-none");
  });

  // Evento de redimensionamento da tela
  window.addEventListener("resize", toggleSections);
});
