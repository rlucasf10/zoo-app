# /home/vault/config.json (dentro del contenedor)
auto_auth {
  method "kubernetes" {
    mount_path = "auth/kubernetes"
    config {
      role = "zoo-app"
      # token_path = "/var/run/secrets/kubernetes.io/serviceaccount/token"
    }
  }

  sink "file" {
    config {
      path = "/home/vault/.vault-token"
    }
  }
}

vault {
  address = "http://192.168.1.102:8200" # ¡Confirma esta IP!
}

template {
  destination = "/vault/secrets/.env" # Aseguramos que el archivo se llame .env
  contents = <<EOF
{{- with secret "kv/zoo-app-static/google-creds" }}
GOOGLE_CLIENT_ID={{ .Data.data.client_id }}
GOOGLE_CLIENT_SECRET={{ .Data.data.client_secret }}
GOOGLE_REDIRECT_URI={{ .Data.data.redirect_uri }}
GOOGLE_DEVICE_ID={{ .Data.data.device_id }}
GOOGLE_DEVICE_NAME={{ .Data.data.device_name }}
{{- end }}

{{- with secret "database/creds/zoo-app-web-role" }}
DB_HOST=zoo-app-mysql
DB_PORT=3306
DB_NAME=zoo_app # La base de datos debe llamarse zoo_app
DB_USER={{ .Data.username }}
DB_PASS={{ .Data.password }}
{{- end }}
EOF
}

log_level = "info"
exit_after_auth = true
