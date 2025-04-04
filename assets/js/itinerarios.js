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

  // Manejo del formulario
  const formItinerario = document.getElementById('formItinerario')
  formItinerario.addEventListener('submit', async function (e) {
    e.preventDefault()

    const nombre = document.getElementById('nombreItinerario').value
    const duracion = document.getElementById('duracion').value
    const puntosInteres = Array.from(
      document.querySelectorAll('.puntos-interes input:checked')
    ).map(checkbox => checkbox.nextElementSibling.textContent)

    try {
      const response = await fetch('/zoo-app/api/crear-itinerario.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify({
          nombre,
          duracion: parseInt(duracion),
          puntosInteres
        })
      })

      const data = await response.json()

      if (response.ok) {
        alert('¡Itinerario creado con éxito!')
        formItinerario.reset()
        actualizarVistaPreviaPersonalizada()
      } else {
        alert(data.error || 'Error al crear el itinerario')
      }
    } catch (error) {
      console.error('Error:', error)
      alert('Error al crear el itinerario. Por favor, intenta de nuevo.')
    }
  })
})
