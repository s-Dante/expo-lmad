# 🤝 Convenciones de Git y Trabajo en Equipo

### 1. Naming de Ramas
- `main/`    : Rama principal, solo se hacen merge cuando sea necesario.
- `develop`  : Segunda rama mas importante, de esta se deriva cada feature que se integra.
- `feature/` : Nuevas funcionalidades.
- `fix/`     : Corrección de errores en develop.

### 2. El flujo de Pull Request
1. **Sincroniza:** `git checkout develop && git pull origin develop`.
2. **Crea:** `git checkout -b feature/mi-tarea`.
3. **Commit:** Usa mensajes claros (ej. `feat: add login repository logic`).
|-> 3.1. *Recomendacion:* Utiliza la extencion Convencional Commits de VSCode para que cada commit siga una estructura adecuada y entendible
4. **Push & PR:** Sube tu rama y abre PR hacia `develop`. 
5. **Review:** Espera la revisión del Lead. Si hay cambios pedidos, hazlos en la misma rama.

### 3. Resolución de Conflictos
Si `develop` avanzó mientras trabajabas:
git checkout feature/mi-tarea
git merge develop
# Resuelve conflictos localmente, testea y sube de nuevo.