
# 🛒 Especificaciones del Módulo de Compras — ERP

El módulo de **Compras** permite gestionar todo el proceso de adquisición de productos o servicios, desde la solicitud interna hasta la recepción y afectación del inventario y finanzas. Es esencial para asegurar la disponibilidad de stock y mantener relaciones eficientes con proveedores.

---

## ✅ Funciones clave

### 1. Gestión de proveedores:
- Alta y mantenimiento de proveedores.
- Clasificación por categoría (materia prima, insumo, servicio, etc.).
- Registro de datos fiscales, contacto, condiciones de pago, historial comercial.
- Evaluación de proveedores por precio, cumplimiento, calidad y tiempos de entrega.

### 2. Solicitudes de compra (requisiciones internas):
- Generación por usuarios autorizados desde inventario, producción u otros módulos.
- Aprobaciones jerárquicas por monto, urgencia o tipo de insumo.
- Agrupación de solicitudes para pedidos.

### 3. Órdenes de compra:
- Generación automática desde solicitud aprobada o manual.
- Detalle de productos, cantidades, precios, fechas de entrega, condiciones de pago.
- Validación de existencia de proveedor y condiciones preestablecidas.
- Envío automatizado de orden por correo o integración EDI.

### 4. Recepción de productos o servicios:
- Validación de entrega contra orden de compra.
- Registro de diferencias: faltantes, sobrantes, daños.
- Integración con inventarios para generar:
  - Entrada al almacén.
  - Actualización de niveles de stock.
  - Registro de lote, caducidad o número de serie (si aplica).
- Integración con cuentas por pagar (se genera pasivo al recibir o facturar).

---

## 🔄 Flujo operativo típico

1. **Solicitud de Compra (requisición interna)**  
2. **Autorización del responsable o gerente**  
3. **Generación de Orden de Compra**  
4. **Recepción de Productos**  
5. **Entrada a Inventario (y validación de lotes/series)**  
## 🔁 Integración con otros módulos

- **Inventario:**
  - Afecta niveles de stock al recibir.
  - Puede generar solicitudes automáticas por bajo inventario.
  - Registro de ubicación, lote, caducidad o serie.


## 🎯 Objetivo del módulo

> _“¿Qué debo comprar, cuándo, a quién, a qué costo y cómo afecta eso mis inventarios, cuentas por pagar y cumplimiento de producción o ventas?”_
