=== Cypher-One ===
Contributors: cypher-one
Requires at least: 6.3
Tested up to: 6.8
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Custom WordPress theme for Cypher-One, converted from the "website-new" build and the AI Readiness public assessment (v5).

== Installation ==

1. Install and activate the free "Secure Custom Fields" plugin (Plugins → Add New → search "Secure Custom Fields").
   (Advanced Custom Fields PRO also works, as SCF shares its API.)
2. Upload cypher-one.zip under Appearance → Themes → Add New → Upload Theme, then activate it.
3. Open any admin screen once. The theme then automatically:
   * creates the pages Home, Why AI fails, Our Approach, About, Contact, Privacy, Thank you, AI Readiness Assessment,
     Score one idea, Cost of waiting, The readiness gap, AI Adoption Review and How we work, with their templates;
   * sets Home as the homepage and Privacy as the privacy policy page;
   * builds the main menu and the three footer menus;
   * fills every field with the original site content and imports the team photos and sharing image into the Media Library.
   You can re-run this at any time from Appearance → Cypher-One setup ("Run setup" keeps your edits; "Reset content" restores the originals).
4. Settings → Permalinks: "Post name" is set for you if permalinks were plain.

== Editing content ==

* Pages → Home / Why AI fails / Our Approach / About / Contact / Thank you / AI Readiness Assessment /
  Score one idea / Cost of waiting / The readiness gap / AI Adoption Review / How we work:
  every section has its own tab. Repeaters let you add, remove and reorder cards, figures, stages, team members, questions, etc.
* Cypher-One (left menu): logo word mark, contact details, footer, contact form recipient, assessment saving, default SEO and the 404 page.
* Appearance → Menus: main navigation and the footer columns. Add the CSS class "nav-assess" to a menu item to style it as the red Assessment button.
* Privacy uses the "Legal / text page" template: the body is written in the block editor.
* Link fields accept page tokens so links survive slug changes: {home} {why} {approach} {about} {contact} {privacy} {assessment} {thanks} {score} {cost} {gap} {discovery} {howwework}, optionally followed by an anchor, e.g. {contact}#contact.
* Calculator texts accept live values: {hours} {lost} {save} {year} {left} {fte} {pct}.
* Each page has a "Search & sharing" box (title, description, image, noindex). It is skipped when Yoast, Rank Math, SEOPress, AIOSEO or The SEO Framework is active.

Without Secure Custom Fields the theme still renders the original content (from the built-in defaults); it just cannot be edited.

== Forms and data ==

* Contact form: submissions are emailed to the address set in Cypher-One → Contact form and stored under "Enquiries". Includes a nonce, a honeypot and a rate limit. Configure SMTP on the server (or an SMTP plugin) for reliable delivery.
* AI Readiness Assessment: visitors see their readiness snapshot in the browser. Nothing is sent unless they fill in the "Let's dive deeper" form at the end; that request, with their full results, is saved under "Assessments" and emailed to the address in Cypher-One → Assessment (endpoint /wp-json/cypher-one/v1/assessment/request). No Web3Forms key is needed; if you prefer Web3Forms, paste a key in Cypher-One → Assessment and requests go there instead.

== Translation ==

Text domain: cypher-one. The template is languages/cypher-one.pot (all theme strings, the default content, the JavaScript strings for the idea scorer and calculator, and the SVG chart labels).
Translate it with Poedit or Loco Translate and save as languages/{locale}.mo (for example ar.mo), or in wp-content/languages/themes/cypher-one-{locale}.mo.
Right-to-left languages load assets/css/rtl.css automatically.
Note: default content is written into the fields in the site language at the time setup runs. To switch an existing site's content to another language, set the site language, then use "Reset content to the original" (or edit the fields).
The AI Readiness Assessment app keeps its own built-in English / Arabic switch (assets/js/assessment.js); its page chrome (header, footer, back button, name, tagline, contact details) is editable in the page fields.

== Updating from 1.0 ==

Upload the new version over the old one. A notice offers "Update content now": it creates the five new pages, replaces the content of Home, Why AI fails and Our Approach with the new design's content, renames the contact-form option, and rebuilds the theme's menus. About, Contact, Privacy and your settings keep your edits. (Also available under Appearance → Cypher-One setup.)

== Files ==

* front-page.php, template-parts/home/* — homepage sections
* page-templates/* — Why AI fails, Our Approach, About, Contact, Legal / text page, Thank you, AI Readiness Assessment,
  Score one idea, Cost of waiting, The readiness gap, AI Adoption Review, How we work
* inc/fields/sections.php — reusable section field sets (scorer, calculator, gap, report, how we work, scorecard, talk to us)
* assets/css/pages/* — page-specific component styles
* inc/fields/* — the SCF field groups, with the original content as defaults
* inc/schema.php — turns the field definitions into SCF groups
* inc/template-functions.php — helpers (c1_f, c1_e, c1_h, c1_url…)
* inc/contact-form.php, inc/assessment.php — form handler and REST endpoints
* inc/setup-content.php — one-click setup
* assets/css/main.css, assets/js/main.js — site styles and script
* assets/css/assessment.css, assets/js/assessment.js, assets/fonts/* — assessment app

== Credits ==

Photographs: Unsplash (https://unsplash.com/), loaded from images.unsplash.com until replaced in the Photo band fields.
Fonts in the assessment: Inter and JetBrains Mono (SIL Open Font License).
