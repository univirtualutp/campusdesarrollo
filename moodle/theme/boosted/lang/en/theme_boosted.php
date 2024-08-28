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
 * Language file - English
 *
 * @package   theme_boosted
 * @copyright 2022-2023 koditik.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['configtitle'] = 'Boosted';
$string['pluginname'] = 'Boosted';

$string['choosereadme'] = 'Boosted is a modern, highly-customisable theme based in Boost. You can easily configure some elements: colours, fonts, front page, login page, and many more, to deploy a site in minutes.';

// Generic strings ***************************************************.
$string['show'] = 'Show';
$string['hide'] = 'Hide';

$string['left'] = 'Left';
$string['centre'] = 'Centre';
$string['right'] = 'Right';
$string['top'] = 'Top';
$string['bottom'] = 'Bottom';

$string['prev_activity'] = 'Previous';
$string['next_activity'] = 'Next';


// Privacy ***********************************************************.
$string['privacy:metadata'] = 'The Boosted theme does not store any personal data about the user.';


// Settings **********************************************************.
$string['aboutsettings']   = 'About';
$string['generalsettings'] = 'General';
$string['colorsettings']  = 'Colours';
$string['fontsettings']   = 'Fonts';
$string['headersettings'] = 'Header';
$string['footersettings'] = 'Footer';
$string['frontpagesettings'] = 'Front Page';
$string['coursesettings'] = 'Course Page';
$string['loginsettings'] = 'Login Page';
$string['advancedsettings'] = 'Advanced';
$string['stylessettings'] = 'Styles';
$string['othersettings']   = 'Other';


// General settings ***********************************************************.
$string['backgroundimage'] = 'Background image';
$string['backgroundimage_desc'] = 'The image to be displayed as site background. The background image you upload here will override the background colour. This image is not displayed in mobile devices.';

$string['preset'] = 'Theme style';
$string['preset_desc'] = 'Select a style to modify the general appearance of the theme. After save the changes you have to purge the cache to avoid problems. Go to <a href="../admin/purgecaches.php">Purge Caches</a>';

$string['unaddableblocks'] = 'Unneeded blocks';
$string['unaddableblocks_desc'] = 'The blocks specified are not needed when using this theme and will not be listed in the \'Add a block\' menu.';

$string['favicon'] = 'Favicon';
$string['favicondesc'] = 'Upload a favicon image to identify your site in the browser. Otherwise, the default Boosted favicon will be displayed.';

$string['contentwidth'] = 'Content width';
$string['contentwidthdesc'] = 'The page width applied to the whole site. If set to 100% then the background image or colour will not shown.';

$string['noimage'] = 'Default course image';
$string['noimage_desc'] = 'The course image displayed in the courses that do not have any image set.';

// Color settings ***********************************************************.
$string['settingsmaincolors'] = 'Main';
$string['settingsheadercolors'] = 'Header';
$string['settingsfootercolors'] = 'Footer';
$string['settingsaccesscolors'] = 'Accessibility';
$string['settingsformscolors'] = 'Forms';

$string['colordesc'] = 'In this section you can select the main colours that would be applied in the theme. Use Hex format (recommended) or any other standard format as RGB or <a target="_blank" href="https://en.wikipedia.org/wiki/Web_colors#HTML_color_names">Standard colour names</a>.<br> As an alternate option you can use also <i>transparent</i> and <i>inherited</i> as a value';

$string['brandcolor'] = 'Brand colour';
$string['brandcolor_desc'] = 'Set the brand colour used in the whole site.';

$string['pagebgcolor'] = 'Background colour';
$string['pagebgcolordesc'] = 'Set the background colour for the whole site. This setting do not apply to mobile devices.';

$string['headertextcolor'] = 'Navigation bar text and link colour';
$string['headertextcolordesc'] = 'Set the navigation bar text and link colour. If you set a dark colour for background then remember to set the text to a light colour';

$string['homebg'] = 'Background Image';
$string['homebgdesc'] = 'Upload an image that will be a background image on the whole site.';

$string['formsbackgroundcolor'] = 'Forms background colour';
$string['formsbackgroundcolordesc'] = 'Set the background colour for forms elements: text area, text box and selects.';

$string['formstextcolor'] = 'Forms text colour';
$string['formstextcolordesc'] = 'Set the text colour for forms elements: text area, text box and selects.';

// Accessibility settings.
$string['focusborder'] = 'Focus border colour';
$string['focusborderdesc'] = 'Border colour when an element has the focus. Add a colour to improve the accessibility. Set the colour to <i>transparent</i> to hide the effect (not recommended)';

$string['selectiontext'] = 'Selection text colour';
$string['selectiontextdesc'] = 'Set the text colour when a text is selected.';

$string['selectionbg'] = 'Selection background colour';
$string['selectionbgdesc'] = 'Set the background colour when a text is selected.';


// Fonts settings ***********************************************************.
$string['fontdesc'] = 'In this section you can select the main font and the headings font used in the site.';

$string['settingsmainfont'] = 'Main';
$string['settingsheaderfont'] = 'Headings';

$string['customfontmain'] = 'Custom main font file';
$string['customfontmaindesc'] = 'Select a font to be used as a main font.';

$string['customfontheader'] = 'Custom headings font';
$string['customfontheaderdesc'] = 'Select a font to be used as a headings font.';

$string['fontsize'] = 'Main font size';
$string['fontsizedesc'] = 'Select the default main font size used in the whole site (the standard value is 1rem = 16px).';

$string['fontweight'] = 'Main font weight';
$string['fontweightdesc'] = 'Font weight used by the main font. Select a value from 100 to 900 depending on the font. 400 is the common value for normal weight';

$string['fontmaincolor'] = 'Main font colour';
$string['fontmaincolordesc'] = 'Set the colour of the main font in the theme.';

$string['fontheaderweight'] = 'Headings font weight';
$string['fontheaderweightdesc'] = 'Headings font weight used in the site. Select a value from 100 to 900 depending on font. 700 is the common value for bold weight.';

$string['fontheadercolor'] = 'Headings font colour';
$string['fontheadercolordesc'] = 'Set the colour of the font used in the theme headings.';


// Header ************************************************************.
$string['headerdesc'] = 'In this section you can set the header layout, styles and content';

$string['headerbgcolor'] = 'Navigation bar background colour';
$string['headerbgcolordesc'] = 'Set the navigation bar background colour.';


// Front Page ********************************************************.
$string['frontpagedesc'] = 'In this section you can configure the front page adding an image banner, Info Blocks and the courses catalogue';

$string['bannerimage'] = 'Banner image';
$string['bannerimagedesc'] = 'A banner image displayed in the top of the front page. Image should be at least 1600×400 pixels (1900×400 pixels for best display) and can be in .jpg, .png format and even a .gif animated. The image is displayed centered and cropped around.';

$string['bannertext'] = 'Banner text';
$string['bannertextdesc'] = 'Banner text. If empty, the text will not be displayed.<br>You can insert HTML tags to format the text like &lt;u&gt;, &lt;em&gt;, &lt;i&gt; or &lt;br&gt;, and also a &lt;span&gt; tag to add styles per word or phrase. ';

$string['bannerbutton'] = 'Banner CTA button';
$string['bannerbuttondesc'] = 'Text for the CTA button located in the top banner. If empty, the button will not be displayed.';

$string['bannerbuttonlink'] = 'Banner CTA button link';
$string['bannerbuttonlinkdesc'] = 'Add the link to redirect users when click the CTA button. The link will be always open in a new tab.';

$string['bannertextvalign'] = 'Banner text vertical alignment';
$string['bannertextvaligndesc'] = 'Align the banner text and the button vertically: top, centre or bottom.';

$string['infoblock'] = 'Information Blocks';
$string['infoblockdesc'] = 'Add Information Blocks in the front page. You can add one row with up to four blocks and insert any content, text or media, even embed a video.<br>
Select first the number of blocks to display, then press &#8220;Save changes&#8221; button and the number of blocks selected will be displayed.<br>
If you do not want to show any block, then select one and keep the content empty.<br>
<b>Example</b> (copy the snippet and paste it in the editor using the menu <b>Tools</b> &#8680; <b><> Source Code</b>):
<pre><code>
&lt;div style="width: 100%; height: 16rem; background:#2979a0; color: white; padding: 1rem; border-radius:1rem;"&gt;
    &lt;div style="text-align: center; padding: 10px;"&gt;
        &lt;i class="fa fa-4x fa-wrench" aria-hidden="true" style="text-align: center;"&gt;&lt;/i&gt;
    &lt;/div&gt;
    &lt;h5 style="color: white; text-align: center;"&gt;Enter the Title&lt;/h5&gt;
    &lt;p style="text-align: center;"&gt;Enter here the information to show&lt;/p&gt;
&lt;/div&gt;
</code></pre><br>';

$string['infoblockcontent'] = 'Information Block content';
$string['infoblockcontentdesc'] = 'Enter the content of the Information Block. You can add any content using HTML/CSS like text, images or video.';

$string['infoblockslayout'] = 'Number of Information Blocks';
$string['infoblockslayoutdesc'] = 'Select the number of Information Blocks to be displayed in the front page.<br><br>If you do not want to show the Information Blocks, just select one block and keep the content empty.';


// Footer ************************************************************.
$string['footerdesc'] = 'In this section you can set the footer layout, styles and content';
$string['socialheading'] = 'Social Icon Settings';

$string['footertextcolor'] = 'Footer text colour';
$string['footertextcolordesc'] = 'Set the footer text colour.';

$string['footerbgcolor'] = 'Footer background colour';
$string['footerbgcolordesc'] = 'Set the footer background colour.';

$string['socialiconslist'] = 'Social Icon List';
$string['socialiconslistdesc'] = 'Enter a delimited list to setup the social icons in the footer.<br>
The format is:

url|title|icon

<b>Example:</b>
<pre>
https://facebook.com/|Facebook|fa-facebook-square
https://twitter.com/|Twitter|fa-twitter-square
https://instagram.com|Instagram|fa-instagram
https://example.com|My Web|fa-globe
</pre>
For icons reference you can find the full list of <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">Font Awesome Icons</a> with most of the social networks available. You can add any number of icons.';

$string['footnote'] = 'Footnote';
$string['footnotedesc'] = 'Add a footnote text such as copyright, disclaimer, trademark, ...';


// Footer Blocks *******************************************************.
$string['footerblocks'] = 'Blocks';
$string['footerblocksdesc'] = 'Add blocks to insert content in the footer. You can add up to four blocks and insert any content, text or media, even embed a map.<br>
Select first the number of blocks to display, then press &#8220;Save changes&#8221; button and the number of blocks selected will be displayed.<br><br>
<b>Example (copy the snippet and paste it in the HTML editor using the </> button):</b>
<pre><code>
&lt;ul&gt;
    &lt;li&gt;About Us&lt;/li&gt;
    &lt;li&gt;Find Us&lt;/li&gt;
    &lt;li&gt;Contact&lt;/li&gt;
    &lt;li&gt;Store&lt;/li&gt;
&lt;/ul&gt;
</code></pre><br>';

$string['footerlayout'] = 'Number of blocks';
$string['footerlayoutdesc'] = 'Set the number of blocks. If you do not want to show any block, then select one and keep the title and content empty.';

$string['footerheader'] = 'Title block ';
$string['footerdesc'] = 'Add a title for the block ';

$string['footercontent'] = 'Content block ';
$string['footercontentdesc'] = 'Add content for the block ';

$string['hidefootersocial'] = 'Show social icons';
$string['hidefootersocialdesc'] = 'Show social icons in the footer below the blocks.';


// Login page ******************************************************.
$string['logindesc'] = 'In this section you can configure the login page adding a background image and positioning the login box in the screen.
<br>The logo displayed in the top of the login box is the one you set as &#8220;Logo&#8221; in the <a href="../admin/settings.php?section=logos">Logos section</a>';

$string['loginboxalign'] = 'Login Box alignment';
$string['loginboxaligndesc'] = 'Set the Login Box horizontal alignment in the screen.';

$string['loginbackgroundimage'] = 'Background image for the login page';
$string['loginbackgroundimage_desc'] = 'Upload the image to be displayed as a background for the login page only. The image is not displayed in mobile devices.';


// Advanced page ******************************************************.
$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Use this field to provide SCSS or CSS code which will be injected at the end of the style sheet.';
$string['rawscsspre'] = 'Raw initial SCSS';
$string['rawscsspre_desc'] = 'In this field you can provide initialising SCSS code, it will be injected before everything else. Most of the time you will use this setting to define variables.';


// About page ******************************************************.
$string['about']   = 'About';
$string['support'] = '<br><b>Support:</b><p>Post your questions in the <a href="https://moodle.org/mod/forum/view.php?id=46" target="_blank">Moodle themes forum</a>.
<br>Please, indicate the above information about Moodle and Boosted versions.</p></br>';
$string['information'] = '<b>Report bugs and improvements:</b><p>In our Github repository: <a href="https://github.com/koditik/moodle-theme_boosted" target="_blank">https://github.com/koditik/moodle-theme_boosted</a>
<br><u>Please, only bugs and improvements. Any other topic will be deleted.</u></p>';
$string['demo'] = 'Visit our demo site: ';


// Styles page ******************************************************.
$string['styles']   = 'Styles';
$string['stylesdesc'] = 'In this section you can check how the styles are applied to the different elements of the theme: text, background, buttons, ...';

// Course tiles *****************************************************.
$string['course'] = 'course';
$string['searchcourses'] = 'Search Courses';
$string['enrollcoursecard'] = 'Enroll';
$string['nomycourses'] = 'No My Courses';

