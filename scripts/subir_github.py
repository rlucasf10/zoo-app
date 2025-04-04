"""
Script para subir automáticamente los cambios del proyecto a GitHub.

- Comprueba si hay cambios en el repositorio local.
- Si hay cambios, los agrega, hace commit con fecha/hora y los sube a GitHub.
- Puede automatizarse con el Programador de Tareas en Windows.

Autor: Ricardo Lucas Fernández
"""

import os
import subprocess
from datetime import datetime

# Detectar la carpeta en la que está el script
REPO_DIR = os.path.dirname(os.path.abspath(__file__))
BRANCH = "main"  # Cambia a "master" si es necesario

# Ir al directorio del repositorio
os.chdir(REPO_DIR)


def ejecutar_comando(comando):
    """Ejecuta un comando en la terminal y maneja errores."""
    try:
        resultado = subprocess.run(
            comando, shell=True, check=True, capture_output=True, text=True
        )
        return resultado
    except subprocess.CalledProcessError as e:
        print(f"❌ Error ejecutando '{comando}':\n{e.stderr}")
        return None


# Comprobar estado del repositorio
status = ejecutar_comando("git status --porcelain")

if not status or not status.stdout.strip():  # Si no hay cambios
    print("✅ No hay cambios nuevos para subir.")
else:
    # Añadir archivos al commit
    resultado_add = ejecutar_comando("git add .")

    if resultado_add is None:
        print("❌ Error al agregar los archivos para el commit.")
    else:
        # Mensaje de commit con fecha y hora
        fecha_hora = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        commit_msg = f"Actualización automática: {fecha_hora}"  # pylint: disable=invalid-name
        resultado_commit = ejecutar_comando(f'git commit -m "{commit_msg}"')

        if resultado_commit is None:
            print("❌ Error al hacer commit de los cambios.")
        else:
            # Subir cambios
            push_result = ejecutar_comando(f"git push origin {BRANCH}")

            if push_result is None:
                print("❌ Error al intentar subir los cambios a GitHub.")
            else:
                print(
                    f"🚀 Cambios subidos correctamente a GitHub en la rama {BRANCH} 🎉"
                )
