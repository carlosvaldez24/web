document.addEventListener("DOMContentLoaded", () => {
  // Obtener ID del libro desde atributo data del body
  const idLibro = document.body.getAttribute("data-libro-id");

  const btnLeer = document.querySelector(".btn-leer");
  const searchInput = document.getElementById("searchInput");
  const searchResults = document.getElementById("resultadosBusqueda");
  const searchBtn = document.querySelector(".search-btn");
  const categoriaLinks = document.querySelectorAll(".dropdown-content a");
  const carrusel = document.querySelector(".carrusel");
  const izquierda = document.querySelector(".flecha.izquierda");
  const derecha = document.querySelector(".flecha.derecha");

  // Botón "Leer ahora"
  if (btnLeer) {
    btnLeer.addEventListener("click", () => {
      window.location.href = "leer.html";
    });
  }

  // Mostrar resultados búsqueda
  function mostrarResultadosBusqueda(query) {
    fetch(`buscar.php?q=${encodeURIComponent(query)}`)
      .then(response => response.text())
      .then(data => {
        if (searchResults) {
          searchResults.innerHTML = data;
          searchResults.style.display = "block";
        }
      })
      .catch(err => console.error("Error en búsqueda:", err));
  }

  // Búsqueda en vivo
  if (searchInput && searchResults) {
    searchInput.addEventListener("keyup", () => {
      const query = searchInput.value.trim();
      if (query.length === 0) {
        searchResults.style.display = "none";
        return;
      }
      mostrarResultadosBusqueda(query);
    });
  }

  // Buscar al presionar botón
  if (searchBtn && searchInput && searchResults) {
    searchBtn.addEventListener("click", () => {
      const query = searchInput.value.trim();
      if (query !== "") {
        mostrarResultadosBusqueda(query);
      }
    });
  }

  // Ocultar resultados al hacer clic fuera
  if (searchResults && searchInput) {
    document.addEventListener("click", (e) => {
      if (!searchResults.contains(e.target) && e.target !== searchInput) {
        searchResults.style.display = "none";
      }
    });
  }

  // Filtros de categorías
  categoriaLinks.forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const categoria = link.textContent;
      alert(`Filtrando libros por la categoría: ${categoria}`);
    });
  });

  // Carrusel sugerencias
  const scrollAmount = 150;
  if (derecha && izquierda && carrusel) {
    derecha.addEventListener("click", () => {
      carrusel.scrollBy({ left: scrollAmount, behavior: "smooth" });
    });
    izquierda.addEventListener("click", () => {
      carrusel.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    });
  }

  // Botón favoritos
  const btnFavorito = document.getElementById("btn-favorito");
  const numFavoritos = document.getElementById("num-favoritos");

  if (btnFavorito && idLibro) {
    btnFavorito.addEventListener("click", () => {
      fetch(`update_favorites.php?id=${idLibro}`)
        .then(res => res.json())
        .then(data => {
          if (data.nuevoFavoritos !== undefined) {
            numFavoritos.textContent = Number(data.nuevoFavoritos).toLocaleString();
          }
        })
        .catch(err => console.error("Error actualizando favoritos:", err));
    });
  }
});
