document.addEventListener("DOMContentLoaded", () => {
  // ----------- Carrusel de banners principal -----------
  const slider = document.getElementById('slider');
  const btnLeft = document.getElementById('btn-left');
  const btnRight = document.getElementById('btn-right');
  const sliderContainer = slider.parentElement;
  
  let index = 0;
  let slideWidth = 0;
  
  const slides = slider.children;
  const totalSlides = slides.length;
  
  const firstClone = slides[0].cloneNode(true);
  slider.appendChild(firstClone);
  
  const actualTotal = slider.children.length;
  slider.style.transition = 'transform 0.5s ease-in-out';
  
  function actualizarSlideWidth() {
    slideWidth = sliderContainer.clientWidth;
    slider.style.transition = 'none';
    slider.style.transform = `translateX(-${slideWidth * index}px)`;
    setTimeout(() => {
      slider.style.transition = 'transform 0.5s ease-in-out';
    }, 50);
  }
  
  window.addEventListener('resize', actualizarSlideWidth);
  window.addEventListener('load', actualizarSlideWidth);
  
  function moverCarrusel() {
    index++;
    slider.style.transform = `translateX(-${slideWidth * index}px)`;
  
    if (index === actualTotal - 1) {
      setTimeout(() => {
        slider.style.transition = 'none';
        index = 0;
        slider.style.transform = `translateX(0px)`;
        setTimeout(() => {
          slider.style.transition = 'transform 0.5s ease-in-out';
        }, 50);
      }, 500);
    }
  }
  
  btnLeft.addEventListener('click', () => {
    if (index <= 0) {
      slider.style.transition = 'none';
      index = actualTotal - 2;
      slider.style.transform = `translateX(-${slideWidth * index}px)`;
      setTimeout(() => {
        slider.style.transition = 'transform 0.5s ease-in-out';
        index--;
        slider.style.transform = `translateX(-${slideWidth * index}px)`;
      }, 20);
    } else {
      index--;
      slider.style.transform = `translateX(-${slideWidth * index}px)`;
    }
  });
  
  btnRight.addEventListener('click', moverCarrusel);
  
  setInterval(moverCarrusel, 2000);
  // -------------------------------------------------------
  
  // ----------- Carruseles de libros (todos) --------------
  const carruseles = document.querySelectorAll('.libros-carrusel');
  
  carruseles.forEach(carrusel => {
    const contenedor = carrusel.querySelector('.contenedor-libros');
    const btnIzq = carrusel.querySelector('.flecha.izquierda');
    const btnDer = carrusel.querySelector('.flecha.derecha');
    const scrollAmount = 300; // Ajusta este valor según necesites
    
    if (contenedor && btnIzq && btnDer) {
      btnDer.addEventListener('click', () => {
        contenedor.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      });
      btnIzq.addEventListener('click', () => {
        contenedor.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      });
    }
  });
  // -------------------------------------------------------
  
  // ----------- Funcionalidad de búsqueda ---------------
  const searchInput = document.getElementById('searchInput');
  const resultadosBusqueda = document.getElementById('resultadosBusqueda');
  
  if (searchInput && resultadosBusqueda) {
    searchInput.addEventListener('keyup', () => {
      const query = searchInput.value.trim();
      if (query.length === 0) {
        resultadosBusqueda.style.display = "none";
        resultadosBusqueda.innerHTML = "";
        return;
      }
      fetch(`buscar.php?q=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(data => {
          resultadosBusqueda.innerHTML = data;
          resultadosBusqueda.style.display = "block";
        })
        .catch(error => console.error('Error:', error));
    });
  }
  
  document.addEventListener('click', function(event) {
    if (resultadosBusqueda && searchInput) {
      if (!resultadosBusqueda.contains(event.target) && !searchInput.contains(event.target)) {
        resultadosBusqueda.style.display = "none";
      }
    }
  });
  // -------------------------------------------------------
});
