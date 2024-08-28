<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language file - Spanish - Spain
 *
 * @package   theme_boosted
 * @copyright 2022-2023 koditik.com
 * @author    2023 Fernando Acedo
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['choosereadme'] = 'Boosted es un tema moderno y altamente personalizable basado en Boost.
 Puedes configurar fácilmente algunos elementos: colores, fuentes, portada, página de inicio de sesión y muchos más, para desplegar un sitio atractivo en minutos.';

// Cadenas genéricas ***************************************************.
$string['show'] = 'Mostrar';
$string['hide'] = 'Ocultar';

$string['left'] = 'Izquierda';
$string['centre'] = 'Centro';
$string['right'] = 'Derecha';
$string['top'] = 'Arriba';
$string['bottom'] = 'Abajo';

$string['prev_activity'] = 'Anterior';
$string['next_activity'] = 'Siguiente';

// Privacy ***********************************************************.
$string['privacy:metadata'] = 'El tema Boosted no almacena ningún dato personal sobre el usuario';

// Settings **********************************************************.
$string['aboutsettings'] = 'Acerca de';
$string['generalsettings'] = 'General';
$string['colorsettings'] = 'Colores';
$string['fontsettings'] = 'Fuentes';
$string['headersettings'] = 'Cabecera';
$string['footersettings'] = 'Pie de página';
$string['frontpagesettings'] = 'Portada';
$string['coursesettings'] = 'Página del curso';
$string['loginsettings'] = 'Página de inicio de sesión';
$string['advancedsettings'] = 'Avanzado';
$string['stylessettings'] = 'Estilos';
$string['othersettings'] = 'Otros';


// Configuración general ***********************************************************.
$string['backgroundimage'] = 'Imagen de fondo';
$string['backgroundimage_desc'] = 'La imagen que se mostrará como fondo del sitio. La imagen que subas aquí sustituirá al color de fondo. Esta imagen no se muestra en dispositivos móviles';

$string['preset'] = 'Estilo del tema';
$string['preset_desc'] = 'Selecciona un estilo para modificar la apariencia general del tema. Después de guardar los cambios tienes que purgar la caché para evitar problemas. Ves a <a href="../admin/purgecaches.php">Purgar Cachés</a>';

$string['unaddableblocks'] = 'Bloques innecesarios';
$string['unaddableblocks_desc'] = 'Los bloques especificados no son necesarios al utilizar este tema y no aparecerán en el menú \'Añadir un bloque\'.';

$string['favicon'] = 'Favicon';
$string['favicondesc'] = 'Sube una imagen tipo favicon para identificar tu sitio en el navegador. De lo contrario, se mostrará el favicon predeterminado de Boosted';

$string['contentwidth'] = 'Ancho del contenido';
$string['contentwidthdesc'] = 'El ancho de página aplicado a todo el sitio. Si se establece en 100%, la imagen de fondo o el color no se mostrarán';

$string['noimage'] = 'Imagen por defecto del curso';
$string['noimage_desc'] = 'La imagen del curso que se muestra en los cursos que no tienen ninguna imagen configurada';

// Ajustes de color ***********************************************************.
$string['settingsmaincolors'] = 'Principal';
$string['settingsheadercolors'] = 'Barra de navegación';
$string['settingsfootercolors'] = 'Pie de página';
$string['settingsaccesscolors'] = 'Accesibilidad';
$string['settingsformscolors'] = 'Formularios';

$string['colordesc'] = 'En esta sección puedes seleccionar los colores principales que se aplicarían en el tema.
 Utiliza el formato hexadecimal (recomendado) o cualquier otro formato estándar como RGB o
 <a target="_blank" href="https://en.wikipedia.org/wiki/Web_colors#HTML_color_names">Nombres de colores estándar</a>.
 <br> Como opción alternativa puedes utilizar también <i>transparent</i> y <i>inherited</i> como valor';

$string['brandcolor'] = 'Color principal';
$string['brandcolor_desc'] = 'Establece el color principal (o primario) utilizado en todo el sitio.';

$string['pagebgcolor'] = 'Color de fondo';
$string['pagebgcolordesc'] = 'Establece el color de fondo para todo el sitio. Este ajuste no se aplica a los dispositivos móviles.';

$string['homebg'] = 'Imagen de fondo';
$string['homebgdesc'] = 'Sube una imagen que se mostrará de fondo de todas las páginas del sitio, excepto en la página de inicio de sesión que dispone de una propia.';

$string['formsbackgroundcolor'] = 'Color de fondo de los formularios';
$string['formsbackgroundcolordesc'] = 'Establece el color de fondo para los elementos de formularios: área de texto, caja de texto y selects.';

$string['formstextcolor'] = 'Color del texto del formulario';
$string['formstextcolordesc'] = 'Establece el color del texto para los elementos de formularios: área de texto, caja de texto y selects.';

// Configuración de accesibilidad.
$string['focusborder'] = 'Color del borde de enfoque';
$string['focusborderdesc'] = 'Establece el color del borde cuando un elemento tiene el foco. Añade un color para mejorar la accesibilidad. Establece el color a <i>transparente</i> para ocultar el efecto (no recomendado)';

$string['selectiontext'] = 'Color del texto de selección';
$string['selectiontextdesc'] = 'Establece el color del texto cuando se selecciona un texto';

$string['selectionbg'] = 'Color de fondo de la selección';
$string['selectionbgdesc'] = 'Establece el color de fondo cuando se selecciona un texto';


// Configuración de fuentes ***********************************************************.
$string['fontdesc'] = 'En esta sección puedes seleccionar la fuente principal y la fuente de los encabezados utilizada en el sitio';

$string['settingsmainfont'] = 'Principal';
$string['settingsheaderfont'] = 'Encabezados';

$string['customfontmain'] = 'Fuente principal';
$string['customfontmaindesc'] = 'Selecciona una fuente para usar como fuente principal';

$string['customfontheader'] = 'Fuente para encabezados';
$string['customfontheaderdesc'] = 'Selecciona una fuente para utilizarla en los encabezados.';

$string['fontsize'] = 'Tamaño de la fuente principal';
$string['fontsizedesc'] = 'Selecciona el tamaño por defecto de la fuente principal utilizada en todo el sitio (el valor estándar es 1rem = 16px)';

$string['fontweight'] = 'Peso de la fuente principal';
$string['fontweightdesc'] = 'Establece el peso usado por la fuente principal. Selecciona un valor de 100 a 900 dependiendo de la fuente. 400 es el valor común para un peso normal';

$string['fontmaincolor'] = 'Color de la fuente principal';
$string['fontmaincolordesc'] = 'Establece el color de la fuente principal en todo el tema';

$string['fontheaderweight'] = 'Peso de la fuente de los encabezados';
$string['fontheaderweightdesc'] = 'Establece el peso de la fuente de los encabezados usados en el sitio. Seleccione un valor de 100 a 900 dependiendo de la fuente. 700 es el valor común para la negrita.';

$string['fontheadercolor'] = 'Color de la fuente de los encabezados';
$string['fontheadercolordesc'] = 'Establece el color de la fuente utilizada en los encabezados del tema.';


// Header ************************************************************.
$string['headerdesc'] = 'En esta sección puedes configurar el diseño, los estilos y el contenido de la cabecera';

$string['headerbgcolor'] = 'Color de fondo de la barra de navegación';
$string['headerbgcolordesc'] = 'Establecer el color de fondo de la barra de navegación';

$string['headertextcolor'] = 'Color del texto y de los enlaces de la barra de navegación';
$string['headertextcolordesc'] = 'Establece el texto de la barra de navegación y el color del enlace. Si utilizas un color oscuro para el fondo, recuerda establecer el texto en un color claro';


// Portada ********************************************************.
$string['frontpagedesc'] = 'En esta sección puede configurar la portada añadiendo una imagen, bloques de información y el catálogo de cursos.';

$string['bannerimage'] = 'Imagen (banner)';
$string['bannerimagedesc'] = 'La imagen se mostrará en la parte superior de la portada. La imagen debe tener al menos 1600×400 píxeles (1900×400 píxeles para una mejor visualización) y puede estar en formato .jpg, .png e incluso un .gif animado. La imagen se muestra centrada y recortada alrededor';

$string['bannertext'] = 'Texto del banner';
$string['bannertextdesc'] = 'Si está vacío, el texto no se mostrará.<br>Puedes insertar etiquetas HTML para dar formato al texto como &lt;u&gt;, &lt;em&gt;, &lt;i&gt; o &lt;br&gt;, y también &lt;span&gt; para añadir estilos por palabra o frase. ';

$string['bannerbutton'] = 'Botón CTA';
$string['bannerbuttondesc'] = 'Texto para el botón CTA (Call To Action) situado en el banner superior. Si está vacío, el botón no se mostrará';

$string['bannerbuttonlink'] = 'Enlace del botón CTA del banner';
$string['bannerbuttonlinkdesc'] = 'Añade el enlace para redirigir a los usuarios cuando hagan clic en el botón CTA. El enlace se abrirá siempre en una nueva pestaña';

$string['bannertextvalign'] = 'Alineación vertical del texto del banner';
$string['bannertextvaligndesc'] = 'Alinear el texto del banner y el botón verticalmente: arriba, centro o abajo';

$string['infoblock'] = 'Bloques de información';
$string['infoblockdesc'] = 'Añade Bloques de Información en la portada. Puedes añadir una fila con hasta cuatro bloques e insertar cualquier contenido, texto o multimedia, incluso incrustar un vídeo.<br>
Selecciona primero el número de bloques que deseas mostrar y, a continuación, pulsa el botón &#8220;Guardar cambios&#8221; y se mostrará el número de bloques seleccionado.<br>
Si no deseas mostrar ningún bloque, seleccione uno y manten el contenido vacío.<br>
<b>Ejemplo</b> (copia el fragmento y pégalo en el editor HTML con el botón </>):
<pre><code>
&lt;div style="width: 100%; height: 16rem; background:#2979a0; color: white; padding: 1rem; border-radius:1rem;"&gt;
    &lt;div style="text-align: center; padding: 10px;"&gt;
        &lt;i class="fa fa-4x fa-wrench" aria-hidden="true" style="text-align: center;"&lt;/i&gt;
    &lt;/div&gt;
    &lt;h5 style="color: white; text-align: center;"&gt;Introduzca el Título&lt;/h5&gt;
    &lt;p style="text-align: center;"&gt;Introduzca aquí la información a mostrar&lt;/p&gt;
&lt;/div&gt;
</code></pre><br>';

$string['infoblockcontent'] = 'Contenido del bloque de información';
$string['infoblockcontentdesc'] = 'Introduce el contenido del Bloque de Información. Puedes añadir cualquier contenido usando HTML/CSS como texto, imágenes o vídeo.';

$string['infoblockslayout'] = 'Número de Bloques de Información';
$string['infoblockslayoutdesc'] = 'Selecciona el número de Bloques de Información que se mostrarán en la portada (hasta cuatro).<br><br>Si no quieres mostrar los Bloques de Información, sólo selecciona un bloque y mantén el contenido vacío.';


// Footer ************************************************************.
$string['footerdesc'] = 'En esta sección puedes configurar el diseño, los estilos y el contenido del pie de página';
$string['socialheading'] = 'Configuración de iconos sociales';

$string['footertextcolor'] = 'Color del texto';
$string['footertextcolordesc'] = 'Establece el color del texto del pie de página';

$string['footerbgcolor'] = 'Color de fondo';
$string['footerbgcolordesc'] = 'Establece el color de fondo del pie de página';

$string['socialiconslist'] = 'Iconos de redes sociales';
$string['socialiconslistdesc'] = 'Introduce una lista delimitada para configurar los iconos sociales en el pie de página.<br>
El formato es:

url|título|icono

<b>Ejemplo:</b>
<pre>
https://facebook.com/|Facebook|fa-facebook-square
https://twitter.com/|Twitter|fa-twitter-square
https://instagram.com|Instagram|fa-instagram
https://example.com|Mi Web|fa-globe
</pre>
La lista completa de los iconos se puede encontrar en <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">Font Awesome Icons</a> con la mayoría de las redes sociales disponibles. Puedes añadir cualquier número de iconos.';

$string['footnote'] = 'Nota al pie';
$string['footnotedesc'] = 'Añade una nota al pie de página como copyright, disclaimer, marca registrada, ...';


// Bloques de pie de página *******************************************************.
$string['footerblocks'] = 'Bloques';
$string['footerblocksdesc'] = 'Añade bloques para insertar contenido en el pie de página. Puedes añadir hasta cuatro bloques e insertar cualquier contenido, texto o multimedia, incluso incrustar un mapa.<br>
Selecciona primero el número de bloques que deseas mostrar, después pulsa el botón &#8220;Guardar cambios&#8221; y se mostrará el número de bloques seleccionados.<br><br>
<b>Ejemplo (copia el fragmento y pégalo en el editor HTML con el botón </>):</b>
<pre><code>
&lt;ul&gt;
    &lt;li&gt;Sobre nosotros&lt;/li&gt;
    &lt;li&gt;Encuéntrenos&lt;/li&gt;
    Contacto
    &lt;li&gt;Tienda&lt;/li&gt;
&lt;/ul&gt;
</code></pre><br>';

$string['footerlayout'] = 'Número de bloques';
$string['footerlayoutdesc'] = 'Establece el número de bloques. Si no desea mostrar ningún bloque, seleccione uno y mantenga el título y el contenido vacíos.';

$string['footerheader'] = 'Bloque de título ';
$string['footerdesc'] = 'Añadir un título para el bloque ';

$string['footercontent'] = 'Bloque de contenido ';
$string['footercontentdesc'] = 'Añadir contenido para el bloque ';

$string['hidefootersocial'] = 'Mostrar iconos sociales';
$string['hidefootersocialdesc'] = 'Mostrar iconos sociales en el pie de página debajo de los bloques';


// Página de inicio de sesión ******************************************************.
$string['logindesc'] = 'En esta sección puedes configurar la página de inicio de sesión agregando una imagen de fondo y posicionando el cuadro en la pantalla.
<br>El logo que se muestra en la parte superior del cuadro es el que estableció como &#8220;Logo&#8221; en la sección <a href="../admin/settings.php?section=logos">Logotipos</a>';

$string['loginboxalign'] = 'Alineación del cuadro de inicio de sesión';
$string['loginboxaligndesc'] = 'Establece la alineación horizontal de la caja de inicio de sesión en la pantalla';

$string['loginbackgroundimage'] = 'Imagen de fondo para la página de inicio de sesión';
$string['loginbackgroundimage_desc'] = 'Sube la imagen que se mostrará como fondo sólo para la página de inicio de sesión. La imagen no se muestra en dispositivos móviles.';


// Página avanzada ******************************************************.
$string['rawscsspre'] = 'SCSS inicial sin procesar';
$string['rawscsspre_desc'] = 'En este campo puedes proporcionar código SCSS inicializador, que se inyectará antes que cualquier otro estilo. Se utiliza principalmente para definir variables';
$string['rawscss'] = 'SCSS personalizable';
$string['rawscss_desc'] = 'Utiliza este campo para proporcionar el código SCSS, o CSS, que se inyectará al final de la hoja de estilo y personalizar los estilos del sitio.';


// Acerca de la página ******************************************************.
$string['about'] = 'Acerca de';
$string['support'] = '<br><b>Soporte:</b><p>Publica tus dudas y cuestiones en el <a href="https://moodle.org/mod/forum/view.php?id=696" target="_blank">Foro de Nuevos Módulos, Apariencia y Personalización de Moodle en Español</a>
<br>Por favor, indica la información mostrada sobre las versiones de Moodle y de Boosted.</p><br>';
$string['information'] = '<b>Informa de errores y mejoras:</b><p> Utiliza nuestro repositorio en Github: <a href="https://github.com/koditik/moodle-theme_boosted" target="_blank">https://github.com/koditik/moodle-theme_boosted</a>
<br><u>Por favor, solo errores y mejoras. Cualquier otra cuestión será eliminada.</u></p>';
$string['demo'] = 'Visita nuestra demo: ';

// Estilos ******************************************************.
$string['stylesdesc'] = 'En esta sección puedes comprobar como se aplican los estilos a los diferentes elementos del tema: texto, fondo, botones, ...';

// Cuadros del curso *****************************************************.
$string['course'] = 'curso';
$string['searchcourses'] = 'Buscar cursos';
$string['enrollcoursecard'] = 'Inscríbete';
$string['nomycourses'] = 'No hay cursos';
