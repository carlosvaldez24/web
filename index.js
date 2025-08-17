// Carrusel automático de banner superior con botones
const slider = document.getElementById('slider');
const sliderContainer = document.querySelector('.slider-container');
const btnLeft = document.getElementById('btn-left');
const btnRight = document.getElementById('btn-right');

let index = 0;
let interval;
let width = sliderContainer.clientWidth;

// Clonar la primera imagen para efecto de loop infinito
const firstSlide = slider.children[0].cloneNode(true);
slider.appendChild(firstSlide);

function updateSlider() {
  slider.style.transition = "transform 0.5s ease-in-out";
  slider.style.transform = `translateX(-${index * width}px)`;
}

function moveNext() {
  index++;
  updateSlider();

  if (index === slider.children.length - 1) {
    setTimeout(() => {
      slider.style.transition = "none";
      index = 0;
      slider.style.transform = `translateX(0px)`;
    }, 500);
  }
}

function movePrev() {
  if (index === 0) {
    slider.style.transition = "none";
    index = slider.children.length - 2;
    slider.style.transform = `translateX(-${index * width}px)`;
    setTimeout(() => {
      slider.style.transition = "transform 0.5s ease-in-out";
      updateSlider();
    }, 20);
  } else {
    index--;
    updateSlider();
  }
}

// Eventos para botones del carrusel automático
btnRight.addEventListener('click', () => {
  moveNext();
  resetInterval();
});

btnLeft.addEventListener('click', () => {
  movePrev();
  resetInterval();
});

// Funciones de auto-slide
function startAutoSlide() {
  interval = setInterval(moveNext, 3000);
}

function resetInterval() {
  clearInterval(interval);
  startAutoSlide();
}

// Ajustar ancho en redimensionamiento
window.addEventListener('resize', () => {
  width = sliderContainer.clientWidth;
  slider.style.transition = 'none';
  slider.style.transform = `translateX(-${index * width}px)`;
});

// Iniciar carrusel automático
startAutoSlide();


// Carrusel horizontal de libros con flechas
const contenedor = document.getElementById('contenedor-libros');
const btnIzq = document.getElementById('flecha-izq');
const btnDer = document.getElementById('flecha-der');

btnIzq.addEventListener('click', () => {
  contenedor.scrollBy({ left: -300, behavior: 'smooth' });
});

btnDer.addEventListener('click', () => {
  contenedor.scrollBy({ left: 300, behavior: 'smooth' });
});


// js/portada.js
(function () {
  const DURATION_MS = 6000; // cuánto dura la portada (ajusta a tu gusto)

  const portada   = document.getElementById('portada');
  const contenido = document.getElementById('contenido');
  const body      = document.body;
  const canvas    = document.getElementById('estrellas');
  if (!portada || !contenido || !canvas) return;

  const ctx = canvas.getContext('2d');
  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  // Estrellas
  class Estrella {
    constructor() { this.reset(); }
    reset() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * -canvas.height;
      this.size = Math.random() * 8 + 4;
      this.speed = Math.random() * 2 + 1;
      this.opacity = Math.random();
      this.flicker = Math.random() * 0.05 + 0.01;
    }
    update() {
      this.y += this.speed;
      this.opacity += (Math.random() > 0.5 ? this.flicker : -this.flicker);
      if (this.opacity > 1) this.opacity = 1;
      if (this.opacity < 0.3) this.opacity = 0.3;
      if (this.y > canvas.height) this.reset();
    }
    draw() {
      ctx.save();
      ctx.globalAlpha = this.opacity;
      ctx.shadowColor = 'white';
      ctx.shadowBlur = 20;
      drawStar(ctx, this.x, this.y, 5, this.size, this.size / 2);
      ctx.restore();
    }
  }

  function drawStar(ctx, x, y, spikes, outerRadius, innerRadius) {
    let rot = Math.PI / 2 * 3;
    let cx = x, cy = y;
    const step = Math.PI / spikes;

    ctx.beginPath();
    ctx.moveTo(cx, cy - outerRadius);
    for (let i = 0; i < spikes; i++) {
      cx = x + Math.cos(rot) * outerRadius;
      cy = y + Math.sin(rot) * outerRadius;
      ctx.lineTo(cx, cy);
      rot += step;

      cx = x + Math.cos(rot) * innerRadius;
      cy = y + Math.sin(rot) * innerRadius;
      ctx.lineTo(cx, cy);
      rot += step;
    }
    ctx.lineTo(x, y - outerRadius);
    ctx.closePath();
    ctx.fillStyle = 'white';
    ctx.fill();
  }

  const estrellas = Array.from({ length: 80 }, () => new Estrella());

  let raf = null;
  function animar() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    for (const e of estrellas) { e.update(); e.draw(); }
    raf = requestAnimationFrame(animar);
  }
  animar();

  // Respeta "reducir movimiento" del SO
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Oculta la portada después del tiempo configurado
  setTimeout(() => {
    portada.style.opacity = '0';
    setTimeout(() => {
      if (raf) cancelAnimationFrame(raf);
      portada.style.display = 'none';
      contenido.style.display = 'block';
      body.classList.remove('no-scroll');
      if (reduceMotion) window.scrollTo(0, 0);
    }, 1000); // debe coincidir con transition del #portada
  }, reduceMotion ? 1000 : DURATION_MS);
})();
