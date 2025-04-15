document.addEventListener('DOMContentLoaded', () => {
  const animals = [
    { image: 'tigre-bengala.jpeg', name: 'Tigre de Bengala' },
    { image: 'bufalo-africano.jpeg', name: 'Búfalo Africano' },
    { image: 'cebra-planicie.jpeg', name: 'Cebra Planicie' },
    { image: 'elefante-africano.jpeg', name: 'Elefante Africano' },
    { image: 'jirafa-masai.jpeg', name: 'Jirafa Masai' },
    { image: 'leon-africano.jpeg', name: 'León Africano' },
    { image: 'oso-polar-occidental.jpeg', name: 'Oso Polar Occidental' },
    { image: 'oso-polar-oriental.jpeg', name: 'Oso Polar Oriental' },
    { image: 'canguro-norte.jpeg', name: 'Canguro Rojo del Norte' },
    { image: 'tigre-siberiano.jpeg', name: 'Tigre Siberiano' }
  ]

  const items = document.querySelectorAll('#animal-gallery .animal-item')

  function getRandomAnimal (exclude) {
    let newAnimal
    do {
      newAnimal = animals[Math.floor(Math.random() * animals.length)]
    } while (exclude.includes(newAnimal.image))
    return newAnimal
  }

  function rotateImages () {
    let usedImages = []

    items.forEach(item => {
      const img = item.querySelector('img')
      const nameTag = item.querySelector('.animal-name')

      const newAnimal = getRandomAnimal(usedImages)
      usedImages.push(newAnimal.image)

      // Efecto fade-out antes de cambiar
      img.style.transition = 'opacity 0.5s ease, transform 0.5s ease'
      img.style.opacity = '0'
      img.style.transform = 'scale(0.9)'
      nameTag.style.transition = 'opacity 0.5s ease'
      nameTag.style.opacity = '0'

      setTimeout(() => {
        // Usar la variable BASE_URL definida en el header
        img.src = `${BASE_URL}/assets/images/${newAnimal.image}`
        nameTag.textContent = newAnimal.name

        // Fade-in después de cambiar
        img.style.opacity = '1'
        img.style.transform = 'scale(1)'
        nameTag.style.opacity = '1'
      }, 500) // Tiempo de espera antes de cambiar la imagen (coincide con la duración de la transición de salida)
    })
  }

  setInterval(rotateImages, 5000) // transición de 5 segundos
})
