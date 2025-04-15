/**
 * JavaScript para la página de inicio
 * Contiene funcionalidades para animaciones y el slider de testimonios
 */

// ==========================
// VARIABLES GLOBALES
// ==========================

const inicioContainer = document.querySelector('.inicio-container')
const videoContainer = document.querySelector('.inicio-video-container')
const categorias = document.querySelectorAll('.inicio-categoria')
const destacados = document.querySelectorAll('.inicio-destacado-item')
const sliderControls = document.querySelector('.inicio-slider-controls')
const newsletterForm = document.querySelector('.inicio-newsletter-formulario')

// ==========================
// MANEJADOR DE ENLACES INTERNOS
// ==========================

// Función para manejar el scroll suave a secciones internas
document.addEventListener('DOMContentLoaded', function () {
  // Seleccionar todos los enlaces internos
  const enlacesInternos = document.querySelectorAll('a[href^="#"]')

  enlacesInternos.forEach(enlace => {
    enlace.addEventListener('click', function (e) {
      e.preventDefault()

      const targetId = this.getAttribute('href')
      const targetElement = document.querySelector(targetId)

      if (targetElement) {
        // Calcular la posición del elemento objetivo
        const headerOffset = 80 // Ajustar según la altura del header
        const elementPosition = targetElement.getBoundingClientRect().top
        const offsetPosition =
          elementPosition + window.pageYOffset - headerOffset

        // Realizar el scroll suave
        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        })
      }
    })
  })

  // Animaciones para las categorías al entrar en viewport
  const observerCategorias = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1'
          entry.target.style.transform = 'translateY(0)'
        }
      })
    },
    {
      threshold: 0.2
    }
  )

  categorias.forEach(categoria => {
    categoria.style.opacity = '0'
    categoria.style.transform = 'translateY(30px)'
    categoria.style.transition = 'all 0.6s ease-out'
    observerCategorias.observe(categoria)
  })

  // Slider de destacados
  let currentSlide = 0
  const totalSlides = destacados.length

  function showSlide (index) {
    destacados.forEach((slide, i) => {
      slide.style.opacity = i === index ? '1' : '0'
      slide.style.transform = i === index ? 'translateY(0)' : 'translateY(30px)'
      slide.classList.toggle('active', i === index)
    })
  }

  function nextSlide () {
    currentSlide = (currentSlide + 1) % totalSlides
    showSlide(currentSlide)
  }

  function prevSlide () {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides
    showSlide(currentSlide)
  }

  // Iniciar slider automático
  let slideInterval = setInterval(nextSlide, 5000)

  // Controles del slider
  if (sliderControls) {
    const prevButton = sliderControls.querySelector('.inicio-slider-prev')
    const nextButton = sliderControls.querySelector('.inicio-slider-next')

    if (prevButton) {
      prevButton.addEventListener('click', () => {
        clearInterval(slideInterval)
        prevSlide()
        slideInterval = setInterval(nextSlide, 5000)
      })
    }

    if (nextButton) {
      nextButton.addEventListener('click', () => {
        clearInterval(slideInterval)
        nextSlide()
        slideInterval = setInterval(nextSlide, 5000)
      })
    }
  }

  // Mostrar primer slide
  if (destacados.length > 0) {
    showSlide(0)
  }

  // Animaciones para los botones
  const botones = document.querySelectorAll('.inicio-boton')
  botones.forEach(boton => {
    boton.addEventListener('mouseenter', function () {
      this.style.transform = 'translateY(-5px)'
    })

    boton.addEventListener('mouseleave', function () {
      this.style.transform = 'translateY(0)'
    })
  })

  // Validación del formulario de newsletter
  if (newsletterForm) {
    const emailInput = newsletterForm.querySelector('input[type="email"]')
    const submitButton = newsletterForm.querySelector('button')

    if (emailInput && submitButton) {
      emailInput.addEventListener('input', function () {
        const isValid = this.checkValidity()
        submitButton.disabled = !isValid
        submitButton.style.opacity = isValid ? '1' : '0.7'
      })

      newsletterForm.addEventListener('submit', function (e) {
        e.preventDefault()
        if (emailInput.checkValidity()) {
          // Aquí iría la lógica para enviar el email
          alert('¡Gracias por suscribirte a nuestro newsletter!')
          emailInput.value = ''
          submitButton.disabled = true
          submitButton.style.opacity = '0.7'
        }
      })
    }
  }

  // Animación del scroll indicator
  const scrollIndicator = document.querySelector('.inicio-scroll-indicator')
  if (scrollIndicator) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 100) {
        scrollIndicator.style.opacity = '0'
      } else {
        scrollIndicator.style.opacity = '1'
      }
    })
  }

  // Efecto hover para las imágenes de categorías
  categorias.forEach(categoria => {
    const imagen = categoria.querySelector('.inicio-categoria-imagen img')
    if (imagen) {
      categoria.addEventListener('mouseenter', function () {
        imagen.style.transform = 'scale(1.1)'
      })

      categoria.addEventListener('mouseleave', function () {
        imagen.style.transform = 'scale(1)'
      })
    }
  })
})

// ==========================
// EFECTOS DE PARALLAX
// ==========================

// Efecto parallax para el video de fondo
if (videoContainer) {
  window.addEventListener('scroll', function () {
    const scrolled = window.pageYOffset
    const video = videoContainer.querySelector('video')
    if (video) {
      video.style.transform = `translateY(${scrolled * 0.5}px)`
    }
  })
}
