
# 🚧 Roadmap - ERP LaborWasser (Actualizado al 2025-05-11)

Este roadmap representa el estado real del proyecto basado en análisis estructural y de código. Cada etapa se marcará como ✅ Completada, 🟡 En progreso o ❌ Pendiente.

---

## 1. Análisis y Diseño Inicial
| Estado | Tarea |
|--------|-------|
| ✅ | Diseño conceptual del sistema y arquitectura base del ERP |
| ✅ | Definición de relaciones entre entidades |
| 🟡 | Arquitectura C4 (documentada en ARCHITECTURE.md; faltan visuales interactivos finales) |

---

## 2. Base Técnica y Sistema de Usuarios
| Estado | Tarea |
|--------|-------|
| ✅ | Instalación de Laravel 11 y Next.js (App Router) |
| ✅ | Configuración de Laravel Sanctum (CSRF, cookies, login, logout, registro, verificación) |
| ✅ | Aplicación de `Policies` y roles a endpoints sensibles |
| ✅ | Hook de autenticación `useAuth` en Next.js con SWR |
| ✅ | Axios configurado con `withCredentials` y control de sesión |
| ✅ | Frontend protegido con middleware (auth, guest) |
| ✅ | Interfaz de login, registro y verificación |

---

## 3. Módulo Inventarios
| Estado | Tarea |
|--------|-------|
| ✅ | Modelos: Producto, Marca, Categoría, Unidad |
| ✅ | Controladores, Requests y Resources JSON:API |
| ✅ | CRUD funcional desde el dashboard |
| 🟡 | Falta documentación técnica en formato Markdown |
| ❌ | Pruebas unitarias y de integración completas |

---

## 4. Módulo Compras
| Estado | Tarea |
|--------|-------|
| 🟡 | Modelos y controladores detectados parcialmente |
| ❌ | Flujo de integración con Inventarios no completado |
| ❌ | Dashboard para compras aún no implementado |
| ❌ | Pruebas automatizadas del módulo |

---

## 5. Módulo Ventas
| Estado | Tarea |
|--------|-------|
| ❌ | Sin implementación actual (modelos o rutas no detectados) |
| ❌ | Integración con Inventarios y Facturación |

---

## 6. Módulo E-commerce
| Estado | Tarea |
|--------|-------|
| 🟡 | Catálogo público disponible |
| ❌ | Carrito, cotización, integración con ventas no implementado aún |

---

## 7. Finanzas, Contabilidad, Facturación, CRM
| Estado | Tarea |
|--------|-------|
| ❌ | Sin estructura aún definida para estos módulos |
| 🟡 | Considerados en la arquitectura general (ARCHITECTURE.md) |

---

## 8. Pruebas y Validaciones
| Estado | Tarea |
|--------|-------|
| 🟡 | Estructura de tests en Laravel presente |
| ❌ | Sin cobertura clara por módulo ni en frontend |
| ❌ | Vitest no detectado en frontend |

---

## 9. Documentación y Automatización
| Estado | Tarea |
|--------|-------|
| ✅ | `.env` configurado correctamente para local y despliegue |
| ✅ | Configuración de CORS, middleware, rutas protegidas |
| ✅ | Documentación del modelo C4 (ARCHITECTURE.md + .drawio + .png) |
| 🟡 | Falta documentación por módulo y uso de Swagger u OpenAPI |
| ❌ | Scripts de deploy para CPanel aún no definidos

