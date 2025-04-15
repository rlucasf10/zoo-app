/**
 * Gestión de cookies para el sitio web del zoológico
 */

document.addEventListener('DOMContentLoaded', function () {
  // Verificar si el usuario ya ha aceptado las cookies
  if (!localStorage.getItem('cookiesAceptadas')) {
    mostrarAvisoCookies()
  }
})

/**
 * Muestra el aviso de cookies en la página
 */
function mostrarAvisoCookies () {
  // Crear el elemento del aviso
  const avisoCookies = document.createElement('div')
  avisoCookies.id = 'aviso-cookies'
  avisoCookies.className = 'aviso-cookies'

  // Contenido del aviso
  avisoCookies.innerHTML = `
        <div class="aviso-cookies-contenido">
            <div class="aviso-cookies-texto">
                <h4>Política de Cookies</h4>
                <p>Utilizamos cookies para mejorar tu experiencia en nuestro sitio web. Al navegar por este sitio, aceptas el uso de cookies para análisis y personalización.</p>
            </div>
            <div class="aviso-cookies-botones">
                <button id="aceptar-cookies" class="btn-cookies aceptar">Aceptar todas</button>
                <button id="rechazar-cookies" class="btn-cookies rechazar">Rechazar</button>
                <button id="configurar-cookies" class="btn-cookies configurar">Configurar</button>
            </div>
        </div>
    `

  // Añadir el aviso al final del body
  document.body.appendChild(avisoCookies)

  // Añadir estilos dinámicamente
  const estilos = document.createElement('style')
  estilos.textContent = `
        .aviso-cookies {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(33, 37, 41, 0.95);
            color: #fff;
            padding: 1rem;
            z-index: 9999;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }
        
        .aviso-cookies-contenido {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }
        
        .aviso-cookies-texto {
            flex: 1;
            min-width: 300px;
            margin-right: 1rem;
        }
        
        .aviso-cookies-texto h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        
        .aviso-cookies-texto p {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        .aviso-cookies-botones {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .btn-cookies {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        .btn-cookies.aceptar {
            background-color: #28a745;
            color: white;
            border-radius: 10px;
        }
        
        .btn-cookies.rechazar {
            background-color: #dc3545;
            color: white;
            border-radius: 10px;
        }
        
        .btn-cookies.configurar {
            background-color: #6c757d;
            color: white;
            border-radius: 10px;
        }
        
        .btn-cookies:hover {
            opacity: 0.9;
        }
        
        @media (max-width: 768px) {
            .aviso-cookies-contenido {
                flex-direction: column;
                text-align: center;
            }
            
            .aviso-cookies-texto {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .aviso-cookies-botones {
                justify-content: center;
            }
        }
    `
  document.head.appendChild(estilos)

  // Eventos para los botones
  document
    .getElementById('aceptar-cookies')
    .addEventListener('click', function () {
      aceptarCookies()
    })

  document
    .getElementById('rechazar-cookies')
    .addEventListener('click', function () {
      rechazarCookies()
    })

  document
    .getElementById('configurar-cookies')
    .addEventListener('click', function () {
      mostrarConfiguracionCookies()
    })
}

/**
 * Acepta todas las cookies y guarda la preferencia
 */
function aceptarCookies () {
  // Guardar la preferencia en localStorage
  localStorage.setItem('cookiesAceptadas', 'true')
  localStorage.setItem(
    'cookiesPreferencias',
    JSON.stringify({
      necesarias: true,
      analiticas: true,
      marketing: true
    })
  )

  // Ocultar el aviso
  ocultarAvisoCookies()

  // Mostrar mensaje de confirmación
  mostrarMensajeConfirmacion('Has aceptado todas las cookies. ¡Gracias!')
}

/**
 * Rechaza todas las cookies excepto las necesarias
 */
function rechazarCookies () {
  // Guardar la preferencia en localStorage
  localStorage.setItem('cookiesAceptadas', 'true')
  localStorage.setItem(
    'cookiesPreferencias',
    JSON.stringify({
      necesarias: true,
      analiticas: false,
      marketing: false
    })
  )

  // Ocultar el aviso
  ocultarAvisoCookies()

  // Mostrar mensaje de confirmación
  mostrarMensajeConfirmacion('Has rechazado las cookies no esenciales.')
}

/**
 * Muestra el panel de configuración de cookies
 */
function mostrarConfiguracionCookies () {
  // Crear el panel de configuración
  const panelConfig = document.createElement('div')
  panelConfig.id = 'panel-config-cookies'
  panelConfig.className = 'panel-config-cookies'

  // Obtener preferencias guardadas o usar valores por defecto
  const preferencias = JSON.parse(
    localStorage.getItem('cookiesPreferencias')
  ) || {
    necesarias: true,
    analiticas: false,
    marketing: false
  }

  // Contenido del panel
  panelConfig.innerHTML = `
        <div class="panel-config-contenido">
            <h3>Configuración de Cookies</h3>
            <p>Selecciona qué tipos de cookies aceptas:</p>
            
            <div class="config-opcion">
                <label>
                    <input type="checkbox" id="cookies-necesarias" ${
                      preferencias.necesarias ? 'checked' : ''
                    } disabled>
                    Cookies Necesarias
                </label>
                <p class="config-descripcion">Estas cookies son necesarias para el funcionamiento del sitio web y no pueden ser desactivadas.</p>
            </div>
            
            <div class="config-opcion">
                <label>
                    <input type="checkbox" id="cookies-analiticas" ${
                      preferencias.analiticas ? 'checked' : ''
                    }>
                    Cookies Analíticas
                </label>
                <p class="config-descripcion">Nos ayudan a entender cómo interactúas con nuestro sitio web.</p>
            </div>
            
            <div class="config-opcion">
                <label>
                    <input type="checkbox" id="cookies-marketing" ${
                      preferencias.marketing ? 'checked' : ''
                    }>
                    Cookies de Marketing
                </label>
                <p class="config-descripcion">Utilizadas para mostrarte anuncios relevantes.</p>
            </div>
            
            <div class="config-botones">
                <button id="guardar-config-cookies" class="btn-cookies aceptar">Guardar Preferencias</button>
                <button id="cerrar-config-cookies" class="btn-cookies configurar">Cerrar</button>
            </div>
        </div>
    `

  // Añadir estilos para el panel
  const estilosPanel = document.createElement('style')
  estilosPanel.textContent = `
        .panel-config-cookies {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            max-width: 500px;
            width: 90%;
        }
        
        .panel-config-contenido h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        
        .config-opcion {
            margin: 1.5rem 0;
        }
        
        .config-opcion label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .config-opcion input[type="checkbox"] {
            margin-right: 0.5rem;
        }
        
        .config-descripcion {
            margin: 0.5rem 0 0 1.5rem;
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        .config-botones {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        
        .overlay-cookies {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }
    `
  document.head.appendChild(estilosPanel)

  // Añadir overlay
  const overlay = document.createElement('div')
  overlay.className = 'overlay-cookies'
  document.body.appendChild(overlay)

  // Añadir el panel al body
  document.body.appendChild(panelConfig)

  // Eventos para los botones
  document
    .getElementById('guardar-config-cookies')
    .addEventListener('click', function () {
      guardarPreferenciasCookies()
    })

  document
    .getElementById('cerrar-config-cookies')
    .addEventListener('click', function () {
      cerrarPanelConfiguracion()
    })

  // Cerrar al hacer clic en el overlay
  overlay.addEventListener('click', function () {
    cerrarPanelConfiguracion()
  })
}

/**
 * Guarda las preferencias de cookies seleccionadas
 */
function guardarPreferenciasCookies () {
  const preferencias = {
    necesarias: true, // Siempre true
    analiticas: document.getElementById('cookies-analiticas').checked,
    marketing: document.getElementById('cookies-marketing').checked
  }

  // Guardar preferencias
  localStorage.setItem('cookiesAceptadas', 'true')
  localStorage.setItem('cookiesPreferencias', JSON.stringify(preferencias))

  // Cerrar el panel
  cerrarPanelConfiguracion()

  // Ocultar el aviso
  ocultarAvisoCookies()

  // Mostrar mensaje de confirmación
  mostrarMensajeConfirmacion('Has guardado tus preferencias de cookies.')
}

/**
 * Cierra el panel de configuración de cookies
 */
function cerrarPanelConfiguracion () {
  const panel = document.getElementById('panel-config-cookies')
  const overlay = document.querySelector('.overlay-cookies')

  if (panel) {
    panel.remove()
  }

  if (overlay) {
    overlay.remove()
  }
}

/**
 * Oculta el aviso de cookies
 */
function ocultarAvisoCookies () {
  const aviso = document.getElementById('aviso-cookies')
  if (aviso) {
    aviso.style.transform = 'translateY(100%)'
    setTimeout(() => {
      aviso.remove()
    }, 300)
  }
}

/**
 * Muestra un mensaje de confirmación temporal
 */
function mostrarMensajeConfirmacion (mensaje) {
  const notificacion = document.createElement('div')
  notificacion.className = 'notificacion-cookies'
  notificacion.textContent = mensaje

  // Estilos para la notificación
  const estilosNotif = document.createElement('style')
  estilosNotif.textContent = `
        .notificacion-cookies {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 1rem;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            animation: fadeInOut 3s forwards;
        }
        
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
    `
  document.head.appendChild(estilosNotif)

  // Añadir al DOM
  document.body.appendChild(notificacion)

  // Eliminar después de la animación
  setTimeout(() => {
    notificacion.remove()
  }, 3000)
}
