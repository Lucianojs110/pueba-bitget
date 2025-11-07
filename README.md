# Simplifica ServiceFlow

## Especificación de Proyecto


### 🧭 1. Descripción general
**Simplifica ServiceFlow** es una aplicación web destinada a talleres de servicios (chapistas, mecánicos, tapiceros, etc.) que permite:
- Registrar y gestionar **órdenes de trabajo**.
- Documentar el avance de cada vehículo mediante **etapas, controles y fotos**.
- Brindar a los clientes un **enlace web público** donde pueden seguir el estado de su vehículo.

El objetivo es contar con un **sistema funcional en producción dentro de un mes**, instalable por cliente, simple de operar y con capacidad de generar valor inmediato al taller.

---

### 🎯 2. Objetivo del MVP
Construir un sistema web con el que un taller pueda:
1. Registrar clientes y vehículos.
2. Generar órdenes de trabajo con etapas y controles.
3. Cargar fotos y observaciones de cada etapa.
4. Compartir con el cliente un enlace público con el estado de avance.
5. Guardar el historial completo del vehículo.

Debe ser **instalable, personalizable y usable desde un navegador**, sin requerir apps móviles ni dependencias externas.

---

### 🧱 3. Stack tecnológico
- **Backend:** Laravel 12 + Livewire 3  
- **Frontend:** Blade + Bootstrap 5 (panel interno) / Tailwind (vista pública)  
- **Base de datos:** MariaDB  
- **Servidor:** Debian Trixie (LEMP: Nginx + PHP-FPM)  
- **Storage:** sistema de archivos local (`/storage/app/public/`)  
- **Configuración:** `.env` por cliente (nombre, logo, colores, dominio o subdominio)

---

### ⚙️ 4. Funcionalidades principales

#### 4.1. Autenticación
- Acceso mediante email y contraseña (Laravel Breeze).
- Roles mínimos: `admin` y `técnico`.
- El administrador puede crear, editar o desactivar usuarios.

#### 4.2. Clientes y vehículos
- CRUD de clientes (`Customer`) y vehículos (`Asset`).
- Cada cliente puede tener varios vehículos.
- Campos del vehículo: marca, modelo, año, patente/VIN, notas y último odómetro registrado.

#### 4.3. Órdenes de trabajo
- CRUD de órdenes (`WorkOrder`) con:
  - Cliente y vehículo asociados.
  - Fechas de ingreso, promesa y entrega.
  - Estado (`pendiente`, `en proceso`, `entregado`).
  - Campo de resumen del servicio (`service_summary`).
  - Lectura de odómetro (`odometer_at_service`).
- Cada orden debe generar automáticamente las etapas asociadas.

#### 4.4. Etapas (stages)
- Secuencia fija (definida por seed o `.env`) que representa el flujo de trabajo del taller.
  Ejemplo: *Ingreso → Diagnóstico → Reparación → Prueba → Entrega*.
- En cada etapa se debe poder marcar:
  - Estado (`pendiente`, `en proceso`, `completada`).
  - Técnico asignado.
  - Fecha de inicio y fin.

#### 4.5. Checklists
- Lista de ítems de control por etapa.
- Cada ítem puede marcarse como **OK** o **pendiente**.
- Sin bloqueo obligatorio (solo informativo).

#### 4.6. Carga de fotos / evidencias
- Carga de imágenes asociadas a una etapa.
- Varias fotos por orden, almacenadas en `storage/public`.
- Vista simple en la interfaz (sin thumbnails ni editor).

#### 4.7. Link público de seguimiento
- Generación de un enlace único con token, sin login.
- Visualización del estado de la orden:
  - Etapas con progreso visual.
  - Fotos cargadas.
  - Fecha estimada de entrega.
- Diseño adaptable con el logo y colores del taller (definidos en `.env`).

#### 4.8. Feedback del cliente
- Formulario público asociado al token de seguimiento.
- Calificación de 1 a 5 estrellas y comentario opcional.
- Registro en la tabla `feedback`, visible para el taller.

#### 4.9. Historial del vehículo
- Cada vehículo muestra el listado de órdenes cerradas.
- Cada entrada incluye: fecha, odómetro, resumen, fotos y rating.
- Permite ver la evolución del mantenimiento a lo largo del tiempo.

---

### 💾 5. Estructura de datos (resumen)
| Tabla | Propósito | Relación principal |
|--------|------------|--------------------|
| `users` | Usuarios internos | pertenece a empresa |
| `customers` | Clientes del taller | — |
| `assets` | Vehículos o equipos | FK cliente |
| `work_orders` | Órdenes de trabajo | FK cliente + vehículo |
| `stages` | Etapas del proceso | FK orden |
| `checklist_items` | Controles por etapa | FK etapa |
| `media` | Fotos o adjuntos | FK orden/etapa |
| `feedback` | Opiniones de clientes | FK orden |
| `odometer_logs` *(opcional)* | Historial de kilometraje | FK vehículo |

---

### 🧩 6. Personalización por cliente
Cada instalación debe permitir:
- Cambiar nombre del taller, logo y color principal.
- Definir las etapas de trabajo (vía seed o `.env`).
- Configurar dominio o subdominio propio.
- Activar/desactivar módulo de feedback según preferencia.

---

### 🚫 7. Fuera de alcance del MVP
- Multi-tenant o panel global de administración.
- Envío automático de notificaciones (WhatsApp, correo o SMS).
- Integración con APIs de mensajería o facturación.
- Reportes avanzados o dashboards estadísticos.
- Control de stock o repuestos.
- Aplicaciones móviles nativas.

---

### 🚀 8. Publicación
El sistema debe estar **instalado y operativo en producción dentro del mes de inicio del proyecto**, con al menos un taller piloto activo y funcionando.
Se considera completado cuando:
1. Un taller puede registrar órdenes y etapas.
2. El cliente puede consultar el avance desde el enlace público.
3. El sistema guarda correctamente fotos y feedback.
4. El historial de vehículos funciona de forma completa.