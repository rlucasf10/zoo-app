document.addEventListener('DOMContentLoaded', function () {
  // Filtrado por categoría
  const filtros = document.querySelectorAll('.btn-filtro')
  const animales = document.querySelectorAll('.col-md-4')

  // Función para filtrar animales
  function filtrarAnimales (categoria) {
    animales.forEach(animal => {
      if (
        categoria === 'todos' ||
        animal.getAttribute('data-categoria') === categoria
      ) {
        animal.style.display = 'block'
      } else {
        animal.style.display = 'none'
      }
    })
  }

  // Evento click para los botones de filtro
  filtros.forEach(filtro => {
    filtro.addEventListener('click', function () {
      // Remover clase active de todos los botones
      filtros.forEach(f => f.classList.remove('active'))
      // Agregar clase active al botón clickeado
      this.classList.add('active')

      const categoria = this.getAttribute('data-categoria')
      filtrarAnimales(categoria)
    })
  })

  // Búsqueda por nombre
  const buscador = document.getElementById('buscarAnimal')
  buscador.addEventListener('input', function () {
    const busqueda = this.value.toLowerCase()

    animales.forEach(animal => {
      const nombre = animal.querySelector('h4').textContent.toLowerCase()
      const descripcion = animal.querySelector('p').textContent.toLowerCase()
      const categoria = animal.getAttribute('data-categoria')

      // Obtener el botón de filtro activo
      const filtroActivo = document.querySelector('.btn-filtro.active')
      const categoriaActiva = filtroActivo
        ? filtroActivo.getAttribute('data-categoria')
        : 'todos'

      // Verificar si el animal coincide con la búsqueda y la categoría activa
      if (
        (nombre.includes(busqueda) || descripcion.includes(busqueda)) &&
        (categoriaActiva === 'todos' || categoria === categoriaActiva)
      ) {
        animal.style.display = 'block'
      } else {
        animal.style.display = 'none'
      }
    })
  })

  // Animación suave al hacer hover sobre las tarjetas
  const tarjetas = document.querySelectorAll('.animal-card')
  tarjetas.forEach(tarjeta => {
    tarjeta.addEventListener('mouseenter', function () {
      this.style.transform = 'translateY(-5px)'
    })

    tarjeta.addEventListener('mouseleave', function () {
      this.style.transform = 'translateY(0)'
    })
  })
})
