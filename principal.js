/* ===== ESPERAR A QUE EL DOM ESTÉ COMPLETAMENTE CARGADO ===== */
document.addEventListener("DOMContentLoaded", () => {

  /* ----------- Carrusel de banners principal ----------- */

  // Obtener el slider principal
  const slider = document.getElementById('slider');

  // Botones de navegación del slider
  const btnLeft = document.getElementById('btn-left');
  const btnRight = document.getElementById('btn-right');

  // Contenedor padre del slider
  const sliderContainer = slider.parentElement;

  // Índice actual del slide
  let index = 0;

  // Ancho de cada slide (se actualizará con resize)
  let slideWidth = 0;

  // Obtener todos los elementos hijos del slider (slides)
  const slides = slider.children;

  // Total de slides originales
  const totalSlides = slides.length;

  // Clonar el primer slide para crear efecto infinito
  const firstClone = slides[0].cloneNode(true);
  slider.appendChild(firstClone);

  // Total de slides incluyendo el clon
  const actualTotal = slider.children.length;

  // Agregar transición al slider
  slider.style.transition = 'transform 0.5s ease-in-out';

  // Función para actualizar el ancho de los slides al cambiar tamaño de ventana
  function actualizarSlideWidth() {
    slideWidth = sliderContainer.clientWidth; // Nuevo ancho del contenedor
    slider.style.transition = 'none'; // Quitar transición momentáneamente
    slider.style.transform = `translateX(-${slideWidth * index}px)`; // Ajustar posición
    setTimeout(() => {
      slider.style.transition = 'transform 0.5s ease-in-out'; // Restaurar transición
    }, 50);
  }

  // Actualizar ancho al redimensionar ventana
  window.addEventListener('resize', actualizarSlideWidth);

  // Actualizar ancho al cargar la página
  window.addEventListener('load', actualizarSlideWidth);

  // Función para mover el carrusel hacia la derecha automáticamente
  function moverCarrusel() {
    index++; // Avanzar índice
    slider.style.transform = `translateX(-${slideWidth * index}px)`; // Mover slider

    // Si llegamos al último slide (clon), reiniciar al inicio
    if (index === actualTotal - 1) {
      setTimeout(() => {
        slider.style.transition = 'none'; // Quitar transición
        index = 0; // Reiniciar índice
        slider.style.transform = `translateX(0px)`; // Volver al primer slide
        setTimeout(() => {
          slider.style.transition = 'transform 0.5s ease-in-out'; // Restaurar transición
        }, 50);
      }, 500); // Espera antes de resetear para que el usuario vea el clon
    }
  }

  // Evento click en botón izquierda
  btnLeft.addEventListener('click', () => {
    if (index <= 0) {
      slider.style.transition = 'none'; // Quitar transición
      index = actualTotal - 2; // Ir al penúltimo slide (antes del clon)
      slider.style.transform = `translateX(-${slideWidth * index}px)`; // Mover slider
      setTimeout(() => {
        slider.style.transition = 'transform 0.5s ease-in-out'; // Restaurar transición
        index--; // Retroceder un índice
        slider.style.transform = `translateX(-${slideWidth * index}px)`; // Mover slider
      }, 20);
    } else {
      index--; // Retroceder índice
      slider.style.transform = `translateX(-${slideWidth * index}px)`; // Mover slider
    }
  });

  // Evento click en botón derecha
  btnRight.addEventListener('click', moverCarrusel);

  // Mover carrusel automáticamente cada 2 segundos
  setInterval(moverCarrusel, 2000);

  /* ----------- Carruseles de libros (todos) -------------- */

  // Seleccionar todos los carruseles de libros
  const carruseles = document.querySelectorAll('.libros-carrusel');

  // Iterar sobre cada carrusel
  carruseles.forEach(carrusel => {
    const contenedor = carrusel.querySelector('.contenedor-libros'); // Contenedor de libros
    const btnIzq = carrusel.querySelector('.flecha.izquierda'); // Botón izquierda
    const btnDer = carrusel.querySelector('.flecha.derecha'); // Botón derecha
    const scrollAmount = 300; // Cantidad de scroll (ajustable)

    // Verificar que existan los elementos
    if (contenedor && btnIzq && btnDer) {
      // Click en botón derecha: mover hacia adelante
      btnDer.addEventListener('click', () => {
        contenedor.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      });

      // Click en botón izquierda: mover hacia atrás
      btnIzq.addEventListener('click', () => {
        contenedor.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      });
    }
  });

  /* ----------- Funcionalidad de búsqueda --------------- */

  // Elemento input de búsqueda
  const searchInput = document.getElementById('searchInput');

  // Contenedor de resultados
  const resultadosBusqueda = document.getElementById('resultadosBusqueda');

  if (searchInput && resultadosBusqueda) {
    // Evento keyup para buscar mientras escribe
    searchInput.addEventListener('keyup', () => {
      const query = searchInput.value.trim(); // Obtener valor limpio
      if (query.length === 0) {
        resultadosBusqueda.style.display = "none"; // Ocultar resultados si está vacío
        resultadosBusqueda.innerHTML = ""; // Limpiar resultados
        return;
      }

      // Fetch para enviar consulta al archivo PHP
      fetch(`buscar.php?q=${encodeURIComponent(query)}`)
        .then(response => response.text()) // Obtener texto
        .then(data => {
          resultadosBusqueda.innerHTML = data; // Mostrar resultados
          resultadosBusqueda.style.display = "block"; // Hacer visible
        })
        .catch(error => console.error('Error:', error)); // Manejar errores
    });
  }

  // Cerrar resultados al hacer click fuera del buscador
  document.addEventListener('click', function(event) {
    if (resultadosBusqueda && searchInput) {
      if (!resultadosBusqueda.contains(event.target) && !searchInput.contains(event.target)) {
        resultadosBusqueda.style.display = "none"; // Ocultar resultados
      }
    }
  });

});
