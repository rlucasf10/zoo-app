document.addEventListener('DOMContentLoaded', () => {
  const animals = [
    { image: 'bengala.jpeg', name: 'Tigre de Bengala' },
    { image: 'bufalo.jpeg', name: 'Búfalo' },
    { image: 'cebra.jpeg', name: 'Cebra' },
    { image: 'cebra2.jpeg', name: 'Cebra' },
    { image: 'elefante.jpeg', name: 'Elefante' },
    { image: 'jirafa.jpeg', name: 'Jirafa' },
    { image: 'jirafa2.jpeg', name: 'Jirafa' },
    { image: 'leon.jpeg', name: 'León' },
    { image: 'leon2.jpeg', name: 'León' },
    { image: 'mono.jpeg', name: 'Mono' },
    { image: 'mono2.jpeg', name: 'Mono' },
    { image: 'oso.jpeg', name: 'Oso' },
    { image: 'tigre.jpeg', name: 'Tigre' },
    { image: 'tigre2.jpeg', name: 'Tigre' },
    { image: 'tigre3.jpeg', name: 'Tigre' }
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
        img.src = `/zoo-app/assets/images/${newAnimal.image}`
        nameTag.textContent = newAnimal.name

        // Fade-in después de cambiar
        img.style.opacity = '1'
        img.style.transform = 'scale(1)'
        nameTag.style.opacity = '1'
      }, 1000) // Tiempo de espera antes de cambiar la imagen (coincide con la duración de la transición de salida)
    })
  }

  setInterval(rotateImages, 10000) // Cambiar cada 10 segundos
})
