// Datos de los animales por categoría
const animalesPorCategoria = {
  mamiferos: [
    { nombre: 'Tigre de Bengala' },
    { nombre: 'Búfalo Africano' },
    { nombre: 'Cebra de Planicie' },
    { nombre: 'Elefante Africano' },
    { nombre: 'Y muchos más...' }
  ],
  aves: [
    { nombre: 'Águila Real' },
    { nombre: 'Flamenco Rosa' },
    { nombre: 'Pingüino Emperador' },
    { nombre: 'Pingüino Emperador del Mar de Ross' },
    { nombre: 'Y muchos más...' }
  ],
  reptiles: [
    { nombre: 'Cocodrilo del Nilo' },
    { nombre: 'Tortuga Boba' },
    { nombre: 'Pitón Reticulada' },
    { nombre: 'Lagarto Monitor de Komodo' },
    { nombre: 'Y muchos más...' }
  ],
  anfibios: [
    { nombre: 'Rana Flecha Azul' },
    { nombre: 'Salamandra Común' },
    { nombre: 'Sapo Común' },
    { nombre: 'Tritón Crestado' },
    { nombre: 'Y muchos más...' }
  ],
  peces: [
    { nombre: 'Pez Ángel' },
    { nombre: 'Pez Dorado' },
    { nombre: 'Pez Betta' },
    { nombre: 'Pez Cirujano Azul' },
    { nombre: 'Y muchos más...' }
  ]
}

// Datos de las rutas predefinidas
const rutasPredefinidas = {
  mamiferos: {
    nombre: 'Ruta de Mamíferos',
    duracion: '3',
    puntosInteres: ['mamiferos'],
    descripcion:
      'Descubre los mamíferos más impresionantes de nuestro zoológico.',
    horario: '10:00 - 12:30',
    distancia: '3 km',
    imagen: window.base_url + '/assets/images/ruta-mamiferos.jpeg'
  },
  aves: {
    nombre: 'Ruta de Aves',
    duracion: '2',
    puntosInteres: ['aves'],
    descripcion:
      'Explora el fascinante mundo de las aves de nuestro zoológico.',
    horario: '11:00 - 13:00',
    distancia: '2 km',
    imagen: window.base_url + '/assets/images/ruta-aves.jpeg'
  },
  familiar: {
    nombre: 'Ruta Familiar',
    duracion: '4',
    puntosInteres: ['mamiferos', 'aves', 'reptiles', 'anfibios', 'peces'],
    descripcion:
      'La ruta perfecta para disfrutar en familia con los más pequeños.',
    horario: '10:00 - 14:00',
    distancia: '4 km',
    imagen: window.base_url + '/assets/images/ruta-familiar.jpeg'
  }
}

// Función para mostrar una ruta predefinida
function mostrarRutaPredefinida (ruta, vistaPrevia) {
  // Actualizar la vista previa
  actualizarVistaPreviaItinerario(
    ruta.nombre,
    ruta.duracion,
    ruta.puntosInteres,
    vistaPrevia
  )

  // Actualizar el formulario
  const nombreInput = document.getElementById('nombreItinerario')
  const duracionSelect = document.getElementById('duracion')
  const container = document.getElementById('puntos-interes-container')

  // Actualizar nombre
  nombreInput.value = ruta.nombre

  // Actualizar duración
  // Convertir la duración a un número entero para el select
  const duracionNumero = parseFloat(ruta.duracion)
  // Redondear al número entero más cercano
  const duracionRedondeada = Math.round(duracionNumero)

  // Asegurarse de que el valor esté en el rango válido (1-4)
  const duracionFinal = Math.max(1, Math.min(4, duracionRedondeada))

  // Establecer el valor en el select
  duracionSelect.value = duracionFinal.toString()

  //console.log('Duración original:', ruta.duracion)
  //console.log('Duración redondeada:', duracionRedondeada)
  //console.log('Duración final:', duracionFinal)
  //console.log('Valor del select:', duracionSelect.value)

  // Limpiar y rellenar los puntos de interés
  container.innerHTML = ''
  ruta.puntosInteres.forEach(punto => {
    const nuevoPunto = crearPuntoInteres()
    const select = nuevoPunto.querySelector('select')
    select.value = punto
    container.appendChild(nuevoPunto)

    // Agregar evento para actualizar la vista previa cuando cambie el punto de interés
    select.addEventListener('change', function () {
      actualizarVistaPreviaConSeleccionActual()
    })
  })

  // Actualizar la vista previa
  actualizarVistaPreviaItinerario(
    nombreInput.value,
    duracionSelect.value,
    Array.from(document.querySelectorAll('.punto-interes-select'))
      .map(select => select.value)
      .filter(value => value !== ''),
    vistaPrevia
  )
}

// Función para actualizar la vista previa del itinerario
function actualizarVistaPreviaItinerario (
  nombre,
  duracion,
  puntosInteres,
  vistaPrevia
) {
  // Formatear los puntos de interés
  const puntosFormateados = puntosInteres.map(punto => {
    return punto
      .replace(/_/g, ' ')
      .split(' ')
      .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
      .join(' ')
  })

  // Determinar la imagen según el nombre
  let imagen = window.base_url + '/assets/images/ruta-default.webp'
  if (nombre.includes('Mamíferos')) {
    imagen = window.base_url + '/assets/images/ruta-mamiferos.jpeg'
  } else if (nombre.includes('Aves')) {
    imagen = window.base_url + '/assets/images/ruta-aves.jpeg'
  } else if (nombre.includes('Familiar')) {
    imagen = window.base_url + '/assets/images/ruta-familiar.jpeg'
  }

  // Crear HTML para la vista previa
  let html = `
        <div class="vista-previa-itinerario-card">
            <div class="vista-previa-imagen" style="background-image: url('${imagen}');">
                <div class="vista-previa-overlay">
                    <h4>${nombre}</h4>
                </div>
            </div>
            <div class="vista-previa-info">
                <p><i class="fas fa-clock"></i> Duración: ${duracion} ${
    parseFloat(duracion) === 1 ? 'hora' : 'horas'
  }</p>
                <p><i class="fas fa-calendar-alt"></i> Horario: ${
                  nombre.includes('Mamíferos')
                    ? '10:00 - 12:30'
                    : nombre.includes('Aves')
                    ? '11:00 - 13:00'
                    : nombre.includes('Familiar')
                    ? '10:00 - 14:00'
                    : '10:00 - 12:00'
                }</p>
                <p><i class="fas fa-walking"></i> Distancia: ${
                  nombre.includes('Mamíferos')
                    ? '3 km'
                    : nombre.includes('Aves')
                    ? '2 km'
                    : nombre.includes('Familiar')
                    ? '4 km'
                    : '2 km'
                }</p>
                <p class="vista-previa-descripcion">${
                  nombre.includes('Mamíferos')
                    ? 'Descubre los mamíferos más impresionantes de nuestro zoológico.'
                    : nombre.includes('Aves')
                    ? 'Explora el fascinante mundo de las aves de nuestro zoológico.'
                    : nombre.includes('Familiar')
                    ? 'La ruta perfecta para disfrutar en familia con los más pequeños.'
                    : 'Tu itinerario personalizado'
                }</p>
                <div class="vista-previa-puntos">
                    <h5>Puntos de Interés:</h5>
                    <ul>
    `

  puntosFormateados.forEach(punto => {
    html += `<li><i class="fas fa-map-marker-alt"></i> ${punto}</li>`
  })

  html += `
                </ul>
            </div>
    `

  // Añadir sección de animales por punto de interés
  html += `
                <div class="vista-previa-animales">
                    <h5>Animales que podrás ver</h5>
    `

  // Verificar que el objeto animalesPorCategoria esté definido
  if (typeof animalesPorCategoria !== 'undefined') {
    // Conjunto para almacenar los animales ya mostrados (para evitar duplicados)
    const animalesMostrados = new Set()

    // Iterar sobre cada punto de interés
    puntosInteres.forEach(punto => {
      // Verificar si el punto existe en el objeto animalesPorCategoria
      if (animalesPorCategoria[punto]) {
        // Formatear el nombre del punto de interés para mostrarlo
        const puntoFormateado = punto
          .replace(/_/g, ' ')
          .split(' ')
          .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
          .join(' ')

        html += `
                    <div class="vista-previa-punto-interes">
                        <h6>${puntoFormateado}</h6>
                        <ul class="vista-previa-animales-lista">
        `

        // Añadir cada animal a la lista (evitando duplicados)
        animalesPorCategoria[punto].forEach(animal => {
          if (!animalesMostrados.has(animal.nombre)) {
            html += `<li>${animal.nombre}</li>`
            animalesMostrados.add(animal.nombre)
          }
        })

        html += `
                        </ul>
                    </div>
        `
      }
    })

    // Si no hay puntos de interés con animales, mostrar un mensaje
    if (animalesMostrados.size === 0) {
      html +=
        '<p class="text-muted">Selecciona puntos de interés para ver los animales disponibles</p>'
    }
  } else {
    html += '<p class="text-muted">No se pudieron cargar los animales</p>'
  }

  html += `
                </div>
        </div>
    </div>
    `

  // Actualizar la vista previa
  vistaPrevia.innerHTML = html
}

// Función para crear un nuevo punto de interés
function crearPuntoInteres () {
  const div = document.createElement('div')
  div.className = 'punto-interes-item'

  // Generar un ID único para el select
  const selectId = 'punto-interes-' + Date.now()

  div.innerHTML = `
    <div class="punto-interes-content">
      <select id="${selectId}" name="puntosInteres[]" class="form-control punto-interes-select" required>
        <option value="">Seleccione un punto de interés</option>
        <option value="mamiferos">Mamíferos</option>
        <option value="aves">Aves</option>
        <option value="reptiles">Reptiles</option>
        <option value="anfibios">Anfibios</option>
        <option value="peces">Peces</option>
      </select>
      <button type="button" class="btn-remove-punto">
        <i class="fas fa-times"></i>
      </button>
    </div>
  `

  return div
}

// Función para limpiar el formulario (accesible globalmente)
function limpiarFormulario () {
  //console.log('Función limpiarFormulario llamada')

  // Obtener los elementos del formulario
  const nombreInput = document.getElementById('nombreItinerario')
  const duracionSelect = document.getElementById('duracion')
  const vistaPrevia = document.getElementById('vistaPrevia')

  if (!nombreInput || !duracionSelect || !vistaPrevia) {
    //console.error('No se encontraron elementos del formulario')
    return
  }

  // Limpiar el nombre del itinerario
  nombreInput.value = ''

  // Restablecer la duración a 1 hora
  duracionSelect.value = '1'

  // Limpiar todos los puntos de interés excepto el primero
  const puntosInteres = document.querySelectorAll('.punto-interes-item')
  //console.log('Puntos de interés encontrados:', puntosInteres.length)

  if (puntosInteres.length > 1) {
    // Mantener solo el primer punto de interés y resetear su valor
    for (let i = 1; i < puntosInteres.length; i++) {
      puntosInteres[i].remove()
    }
  }

  // Resetear el valor del primer punto de interés
  const primerPunto = document.querySelector('.punto-interes-select')
  if (primerPunto) {
    primerPunto.value = ''
  }

  // Actualizar la vista previa
  actualizarVistaPreviaItinerario('Itinerario', '1', [], vistaPrevia)
  //console.log('Formulario limpiado')
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('puntos-interes-container')
  const btnAddPunto = document.getElementById('btn-add-punto')
  const form = document.getElementById('formItinerario')
  const vistaPrevia = document.getElementById('vistaPrevia')

  // Elementos del formulario para la vista previa
  const nombreInput = document.getElementById('nombreItinerario')
  const duracionSelect = document.getElementById('duracion')

  // Verificar que el objeto animalesPorCategoria esté correctamente definido
  //console.log('Objeto animalesPorCategoria definido:', animalesPorCategoria)
  //console.log('Categorías disponibles:', Object.keys(animalesPorCategoria))

  // Agregar eventos a los botones "Ver Ruta"
  document.querySelectorAll('.btn-itinerario').forEach(btn => {
    btn.addEventListener('click', function () {
      const rutaId = this.getAttribute('data-ruta')
      if (rutasPredefinidas[rutaId]) {
        // Usar la función mostrarRutaPredefinida para actualizar todo
        mostrarRutaPredefinida(rutasPredefinidas[rutaId], vistaPrevia)
      }
    })
  })

  // Función para actualizar la vista previa con la selección actual
  function actualizarVistaPreviaConSeleccionActual () {
    const puntosInteres = Array.from(
      document.querySelectorAll('.punto-interes-select')
    )
      .map(select => select.value)
      .filter(value => value !== '')

    //console.log('Puntos de interés seleccionados:', puntosInteres)

    actualizarVistaPreviaItinerario(
      nombreInput.value,
      duracionSelect.value,
      puntosInteres,
      vistaPrevia
    )
  }

  // Agregar evento para añadir un nuevo punto de interés
  btnAddPunto.addEventListener('click', function () {
    const nuevoPunto = crearPuntoInteres()
    container.appendChild(nuevoPunto)

    // Obtener el select del nuevo punto
    const select = nuevoPunto.querySelector('select')

    // Agregar evento para actualizar la vista previa cuando cambie el punto de interés
    select.addEventListener('change', function () {
      actualizarVistaPreviaConSeleccionActual()
    })

    // Agregar evento para eliminar el punto de interés
    const btnRemove = nuevoPunto.querySelector('.btn-remove-punto')
    btnRemove.addEventListener('click', function () {
      nuevoPunto.remove()
      actualizarVistaPreviaConSeleccionActual()
    })

    // Actualizar la vista previa
    actualizarVistaPreviaConSeleccionActual()
  })

  // Agregar eventos para actualizar la vista previa cuando cambie el nombre o la duración
  nombreInput.addEventListener('input', function () {
    actualizarVistaPreviaConSeleccionActual()
  })

  duracionSelect.addEventListener('change', function () {
    actualizarVistaPreviaConSeleccionActual()
  })

  // Agregar evento para el envío del formulario
  form.addEventListener('submit', function (e) {
    e.preventDefault()

    // Obtener los datos del formulario
    const nombre = nombreInput.value
    const duracion = duracionSelect.value
    const puntosInteres = Array.from(
      document.querySelectorAll('.punto-interes-select')
    )
      .map(select => select.value)
      .filter(value => value !== '')

    // Validar que se haya seleccionado al menos un punto de interés
    if (puntosInteres.length === 0) {
      alert('Por favor, selecciona al menos un punto de interés.')
      return
    }

    // Enviar los datos al servidor
    fetch(window.base_url + '/views/itinerarios.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        nombre: nombre,
        duracion: duracion,
        puntosInteres: puntosInteres
      })
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Recargar la página para mostrar el mensaje de éxito
          window.location.reload()
        } else {
          alert('Error: ' + data.error)
        }
      })
      .catch(error => {
        //console.error('Error:', error)
        alert('Error al crear el itinerario. Por favor, inténtalo de nuevo.')
      })
  })

  // Inicializar la vista previa sin puntos de interés
  actualizarVistaPreviaItinerario('Itinerario', '1', [], vistaPrevia)

  // Agregar eventos a los puntos de interés existentes
  document.querySelectorAll('.punto-interes-select').forEach(select => {
    select.addEventListener('change', function () {
      actualizarVistaPreviaConSeleccionActual()
    })
  })

  // Agregar eventos a los botones de eliminar existentes
  document.querySelectorAll('.btn-remove-punto').forEach(btn => {
    btn.addEventListener('click', function () {
      this.closest('.punto-interes-item').remove()
      actualizarVistaPreviaConSeleccionActual()
    })
  })

  // Agregar evento para el botón de limpiar formulario
  const btnLimpiar = document.getElementById('btn-limpiar')
  //console.log('Botón limpiar encontrado:', btnLimpiar)
  if (btnLimpiar) {
    btnLimpiar.addEventListener('click', function () {
      //console.log('Botón limpiar clickeado')
      // Limpiar el nombre del itinerario
      nombreInput.value = ''

      // Restablecer la duración a 1 hora
      duracionSelect.value = '1'

      // Limpiar todos los puntos de interés excepto el primero
      const puntosInteres = document.querySelectorAll('.punto-interes-item')
      //console.log('Puntos de interés encontrados:', puntosInteres.length)
      if (puntosInteres.length > 1) {
        // Mantener solo el primer punto de interés y resetear su valor
        for (let i = 1; i < puntosInteres.length; i++) {
          puntosInteres[i].remove()
        }
      }

      // Resetear el valor del primer punto de interés
      const primerPunto = document.querySelector('.punto-interes-select')
      if (primerPunto) {
        primerPunto.value = ''
      }

      // Actualizar la vista previa
      actualizarVistaPreviaItinerario('Itinerario', '1', [], vistaPrevia)
      //console.log('Formulario limpiado')
    })
  } else {
    //console.error('No se encontró el botón de limpiar')
  }
})
