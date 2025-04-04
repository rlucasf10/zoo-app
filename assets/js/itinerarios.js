document.addEventListener('DOMContentLoaded', function () {
  // Datos de las rutas predefinidas
  const rutasPredefinidas = {
    mamiferos: {
      nombre: 'Ruta de Mamíferos',
      duracion: '2.5 horas',
      puntos: [
        'Tigre de Bengala',
        'León Africano',
        'Elefante Africano',
        'Jirafa Masai',
        'Panda Gigante',
        'Oso Polar'
      ],
      horario: '10:00 - 12:30',
      distancia: '2.5 km'
    },
    aves: {
      nombre: 'Ruta de Aves',
      duracion: '2 horas',
      puntos: ['Águila Real', 'Flamenco Rosa', 'Pingüino Emperador'],
      horario: '11:00 - 13:00',
      distancia: '2 km'
    },
    familiar: {
      nombre: 'Ruta Familiar',
      duracion: '3 horas',
      puntos: [
        'Panda Gigante',
        'Koala',
        'Canguro Rojo',
        'Delfín Mular',
        'Tortuga Marina',
        'Flamenco Rosa',
        'Cebra de Planicie',
        'Búfalo Africano'
      ],
      horario: '10:30 - 13:30',
      distancia: '3 km'
    }
  }

  // Función para mostrar la vista previa de una ruta predefinida
  function mostrarVistaPreviaRuta (ruta) {
    const vistaPrevia = document.getElementById('vistaPrevia')
    const datosRuta = rutasPredefinidas[ruta]

    let html = `
            <h4>${datosRuta.nombre}</h4>
            <p><strong>Duración:</strong> ${datosRuta.duracion}</p>
            <p><strong>Horario:</strong> ${datosRuta.horario}</p>
            <p><strong>Distancia:</strong> ${datosRuta.distancia}</p>
            <h5>Puntos de Interés:</h5>
            <ul>
        `

    datosRuta.puntos.forEach(punto => {
      html += `<li>${punto}</li>`
    })

    html += '</ul>'
    vistaPrevia.innerHTML = html
  }

  // Evento click para los botones de rutas predefinidas
  const botonesRuta = document.querySelectorAll('.btn-itinerario')
  botonesRuta.forEach(boton => {
    boton.addEventListener('click', function () {
      const ruta = this.getAttribute('data-ruta')
      mostrarVistaPreviaRuta(ruta)
    })
  })

  // Función para actualizar la vista previa del itinerario personalizado
  function actualizarVistaPreviaPersonalizada () {
    const nombre = document.getElementById('nombreItinerario').value
    const duracion = document.getElementById('duracion').value
    const puntosInteres = Array.from(
      document.querySelectorAll('.puntos-interes input:checked')
    ).map(checkbox => checkbox.nextElementSibling.textContent)

    const vistaPrevia = document.getElementById('vistaPrevia')

    if (!nombre) {
      vistaPrevia.innerHTML =
        '<p class="text-muted">Tu itinerario personalizado aparecerá aquí...</p>'
      return
    }

    let html = `
            <h4>${nombre}</h4>
            <p><strong>Duración Estimada:</strong> ${duracion} ${
      duracion === '1' ? 'hora' : 'horas'
    }</p>
        `

    if (puntosInteres.length > 0) {
      html += `
                <h5>Puntos de Interés Seleccionados:</h5>
                <ul>
            `
      puntosInteres.forEach(punto => {
        html += `<li>${punto}</li>`
      })
      html += '</ul>'
    }

    vistaPrevia.innerHTML = html
  }

  // Eventos para actualizar la vista previa en tiempo real
  document
    .getElementById('nombreItinerario')
    .addEventListener('input', actualizarVistaPreviaPersonalizada)
  document
    .getElementById('duracion')
    .addEventListener('change', actualizarVistaPreviaPersonalizada)
  document.querySelectorAll('.puntos-interes input').forEach(checkbox => {
    checkbox.addEventListener('change', actualizarVistaPreviaPersonalizada)
  })

  // Función para guardar el itinerario personalizado
  function guardarItinerarioPersonalizado () {
    const nombre = document.getElementById('nombreItinerario').value
    const duracion = document.getElementById('duracion').value
    const puntosInteres = Array.from(
      document.querySelectorAll('.puntos-interes input:checked')
    ).map(checkbox => checkbox.nextElementSibling.textContent)

    if (!nombre || !duracion || puntosInteres.length === 0) {
      alert(
        'Por favor, completa todos los campos y selecciona al menos un punto de interés.'
      )
      return
    }

    const datos = {
      nombre: nombre,
      duracion: parseInt(duracion),
      puntosInteres: puntosInteres
    }

    console.log('Enviando datos:', datos)

    fetch('/zoo-app/views/itinerarios.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json'
      },
      credentials: 'same-origin',
      body: JSON.stringify(datos)
    })
      .then(response => {
        console.log('Estado de la respuesta:', response.status)
        console.log(
          'Headers de la respuesta:',
          Object.fromEntries(response.headers.entries())
        )

        return response.text().then(text => {
          console.log('Respuesta del servidor:', text)
          try {
            return JSON.parse(text)
          } catch (e) {
            console.error('Error al parsear JSON:', e)
            throw new Error('Error del servidor: ' + text)
          }
        })
      })
      .then(data => {
        if (data.error) {
          throw new Error(data.error)
        }
        alert('¡Itinerario creado con éxito!')
        // Limpiar el formulario
        document.getElementById('nombreItinerario').value = ''
        document.getElementById('duracion').value = ''
        document.querySelectorAll('.puntos-interes input').forEach(checkbox => {
          checkbox.checked = false
        })
        actualizarVistaPreviaPersonalizada()
      })
      .catch(error => {
        console.error('Error completo:', error)
        if (error.message === 'Failed to fetch') {
          alert(
            'Error de conexión. Por favor, verifica tu conexión a internet e intenta de nuevo.'
          )
        } else {
          alert('Error al crear el itinerario: ' + error.message)
        }
      })
  }

  // Manejo del formulario
  const formItinerario = document.getElementById('formItinerario')
  formItinerario.addEventListener('submit', guardarItinerarioPersonalizado)
})
