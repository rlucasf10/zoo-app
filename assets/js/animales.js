document.addEventListener('DOMContentLoaded', function () {
  // Elementos del DOM
  const searchInput = document.getElementById('buscarAnimal')
  const filterButtons = document.querySelectorAll('.btn-filtro')
  const animalCards = document.querySelectorAll('.animal-card-container')
  const contadorResultados = document.getElementById('contador-resultados')
  const animalesContainer = document.getElementById('animales-container')

  // Función para normalizar texto (eliminar tildes y convertir a minúsculas)
  function normalizarTexto (texto) {
    return texto
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
  }

  // Función para actualizar el contador de resultados
  function actualizarContador (cantidad) {
    if (contadorResultados) {
      contadorResultados.textContent = `${cantidad} ${
        cantidad === 1 ? 'animal encontrado' : 'animales encontrados'
      }`
    }
  }

  // Función para filtrar animales
  function filtrarAnimales () {
    const searchTerm = normalizarTexto(searchInput.value)
    const filtroActivo =
      document.querySelector('.btn-filtro.active')?.dataset.filtro
    let animalesVisibles = 0

    animalCards.forEach(card => {
      const nombre = normalizarTexto(
        card.querySelector('h4')?.textContent || ''
      )
      const especie = normalizarTexto(
        card.querySelector('.especie')?.textContent || ''
      )
      const habitat = normalizarTexto(
        card.querySelector('.habitat')?.textContent || ''
      )
      const categoria = card.dataset.categoria

      const coincideBusqueda =
        nombre.includes(searchTerm) ||
        especie.includes(searchTerm) ||
        habitat.includes(searchTerm)

      const coincideFiltro =
        filtroActivo === 'todos' || categoria === filtroActivo

      if (coincideBusqueda && coincideFiltro) {
        card.style.display = 'block'
        animalesVisibles++
      } else {
        card.style.display = 'none'
      }
    })

    actualizarContador(animalesVisibles)

    // Actualizar la visibilidad del botón "Mostrar más/menos" después de filtrar
    actualizarBotonMostrarMas()
  }

  // Función para actualizar la visibilidad del botón "Mostrar más/menos"
  function actualizarBotonMostrarMas () {
    const btnMostrarMas = document.getElementById('btn-mostrar-mas')
    if (btnMostrarMas) {
      // Obtener el filtro activo
      const filtroActivo =
        document.querySelector('.btn-filtro.active')?.dataset.filtro

      // Obtener todas las tarjetas que están actualmente visibles (no ocultas por filtros)
      const tarjetasVisibles = Array.from(animalCards).filter(
        card => card.style.display !== 'none'
      )

      const btnContainer = btnMostrarMas.parentNode

      // Solo mostrar el botón en la sección "Todos" y si hay más de 12 tarjetas visibles
      if (filtroActivo === 'todos' && tarjetasVisibles.length > 12) {
        // Si hay más de 12 tarjetas visibles, mostrar el botón
        btnContainer.style.display = 'block'

        // Ocultar todas las tarjetas después de la doceava
        for (let i = 12; i < tarjetasVisibles.length; i++) {
          tarjetasVisibles[i].classList.add('animal-oculto')
        }

        btnMostrarMas.textContent = 'Mostrar más'
      } else {
        // Si no estamos en "Todos" o hay 12 o menos tarjetas visibles, ocultar el botón
        btnContainer.style.display = 'none'

        // Asegurarse de que todas las tarjetas estén visibles en las otras categorías
        tarjetasVisibles.forEach(card => {
          card.classList.remove('animal-oculto')
        })
      }
    }
  }

  // Función para crear el botón "Mostrar más/menos"
  function crearBotonMostrarMas () {
    // Verificar si ya existe el botón
    if (document.getElementById('btn-mostrar-mas')) {
      return
    }

    // Crear el botón
    const btnMostrarMas = document.createElement('button')
    btnMostrarMas.id = 'btn-mostrar-mas'
    btnMostrarMas.className = 'btn btn-filtro'
    btnMostrarMas.textContent = 'Mostrar más'

    // Agregar el botón al contenedor de animales
    if (animalesContainer) {
      // Crear un contenedor para el botón
      const btnContainer = document.createElement('div')
      btnContainer.className = 'col-12 text-center mt-4'
      btnContainer.appendChild(btnMostrarMas)

      // Insertar el botón al final del contenedor de animales
      animalesContainer.appendChild(btnContainer)

      // Ocultar todas las tarjetas después de la doceava
      if (animalCards.length > 12) {
        for (let i = 12; i < animalCards.length; i++) {
          animalCards[i].classList.add('animal-oculto')
        }

        // Agregar evento al botón
        btnMostrarMas.addEventListener('click', function () {
          const tarjetasOcultas = document.querySelectorAll('.animal-oculto')

          if (tarjetasOcultas.length > 0) {
            // Mostrar todas las tarjetas ocultas
            tarjetasOcultas.forEach(card => {
              card.classList.remove('animal-oculto')
            })
            btnMostrarMas.textContent = 'Mostrar menos'
          } else {
            // Ocultar todas las tarjetas después de la doceava
            for (let i = 12; i < animalCards.length; i++) {
              animalCards[i].classList.add('animal-oculto')
            }
            btnMostrarMas.textContent = 'Mostrar más'
          }
        })
      } else {
        // Si hay 12 o menos tarjetas, ocultar el botón
        btnContainer.style.display = 'none'
      }
    }
  }

  // Event listeners
  if (searchInput) {
    searchInput.addEventListener('input', filtrarAnimales)
  }

  if (filterButtons.length > 0) {
    filterButtons.forEach(button => {
      button.addEventListener('click', function () {
        filterButtons.forEach(btn => btn.classList.remove('active'))
        this.classList.add('active')

        // Limpiar el campo de búsqueda cuando se selecciona una categoría
        if (searchInput) {
          searchInput.value = ''
        }

        filtrarAnimales()
      })
    })
  }

  // Inicializar contador
  if (animalCards.length > 0) {
    actualizarContador(animalCards.length)

    // Animación de entrada para las tarjetas
    animalCards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.1}s`
    })

    // Crear el botón "Mostrar más/menos"
    crearBotonMostrarMas()
  }
})
