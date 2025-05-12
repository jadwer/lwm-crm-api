
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

### 5. Facturación del proveedor:
- Registro y validación de facturas contra orden y recepción.
- Soporte para facturación electrónica.
- Registro en cuentas por pagar con vencimientos y retenciones.

### 6. Condiciones comerciales:
- Historial de precios por proveedor y producto.
- Descuentos por volumen, condiciones por contrato.
- Comparación automática entre cotizaciones.

### 7. Control presupuestal (si aplica):
- Validación contra presupuestos aprobados por departamento.
- Alertas por sobrepaso de límites.

### 8. Reportes y análisis:
- Compras por proveedor, producto, categoría.
- Tiempos de entrega promedio.
- Cumplimiento de proveedores.
- Órdenes pendientes de entrega o facturación.
- Análisis de costos y variaciones de precios.

---

## 🔄 Flujo operativo típico

1. **Solicitud de Compra (requisición interna)**  
2. **Autorización del responsable o gerente**  
3. **Generación de Orden de Compra**  
4. **Recepción de Productos**  
5. **Entrada a Inventario (y validación de lotes/series)**  
6. **Registro de Factura del Proveedor**  
7. **Integración con Cuentas por Pagar y Contabilidad**  

---

## 🔁 Integración con otros módulos

- **Inventario:**
  - Afecta niveles de stock al recibir.
  - Puede generar solicitudes automáticas por bajo inventario.
  - Registro de ubicación, lote, caducidad o serie.

- **Finanzas / Cuentas por Pagar:**
  - Generación de pasivos con vencimiento.
  - Impacto en flujo de efectivo y reportes contables.

- **Producción (si aplica):**
  - Requiere insumos o materiales no disponibles.
  - Genera requisiciones automáticas según orden de producción.

- **Presupuestos / Planeación:**
  - Validación contra presupuestos de compra.
  - Registro para auditoría y seguimiento.

---

## 🎯 Objetivo del módulo

> _“¿Qué debo comprar, cuándo, a quién, a qué costo y cómo afecta eso mis inventarios, cuentas por pagar y cumplimiento de producción o ventas?”_
