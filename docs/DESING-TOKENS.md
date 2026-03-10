

### 📘 Nomenclatura y explicación de variables de color y estilos del proyecto

En el archivo de **tokens** se definen todos aquellos valores reutilizables del proyecto, como **colores, fuentes y estilos repetitivos**, así como la **paleta de la marca**.
El objetivo principal es **centralizar estos valores** para facilitar el mantenimiento y la consistencia visual.

> ⚠️ **No se deben usar colores “en crudo” directamente en el proyecto**.
> Todos los colores y valores deben declararse únicamente mediante **variables**.

---

### 🧩 Tipos de variables

#### 🔤 Fuentes globales

Estas variables definen todas las fuentes tipográficas utilizadas de manera global en el proyecto.

```css
/* --- FUENTES GLOBALES --- */
--font-main: "Kodchasan", sans-serif;
--font-body: "Inter", sans-serif;
--font-display: "Bruno Ace", sans-serif;
--font-alt: "League Spartan", sans-serif;
```

Las fuentes se organizan según su **nivel de uso o importancia** dentro del proyecto (principal, texto, títulos, alternativas, etc.).

---

#### 🎨 Paleta de colores (Primitivos)

Aquí se declaran **todos los colores base del proyecto en su valor original** (hex, rgb, etc.).
Estos colores funcionan como **primitivos**, es decir, no se usan directamente en los estilos, sino como referencia para otras variables.

```css
/* --- PALETA DE COLORES (PRIMITIVOS) --- */
```

Su función principal es servir como base para construir variables semánticas.

---

#### 🧠 Semántica compartida

Esta sección agrupa variables que representan **el uso funcional de los estilos dentro del proyecto**, como fondos, textos, bordes o valores repetidos.

Las variables se nombran según su **impacto o propósito**, no por su color específico.
Esto permite que, si en algún punto se desea cambiar la identidad visual, los cambios se realicen **directamente desde `variables.css`**, de forma más rápida y eficiente.

```css
/* --- SEMÁNTICA COMPARTIDA --- */

/* Fondos de página */
--bg-page-gradient: linear-gradient(
    180deg,
    var(--clr-blue-800) 0%,
    var(--clr-blue-900) 100%
);

/* Textos */
--text-primary: var(--clr-white);
--text-secondary: var(--clr-gray);
```

