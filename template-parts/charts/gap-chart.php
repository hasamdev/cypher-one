<?php
/**
 * Conceptual chart: AI potential against organisational readiness.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;

$c1_dark = isset( $args['variant'] ) && 'dark' === $args['variant'];
?>
<?php if ( $c1_dark ) : ?>
<svg viewBox="0 0 640 400" role="img" aria-labelledby="gap-t gap-d">
          <title id="gap-t"><?php esc_html_e( 'Chart: AI potential against organisational readiness', 'cypher-one' ); ?></title>
          <desc id="gap-d"><?php esc_html_e( 'Across four stages, tools, automation, agents and autonomy, the AI potential line rises steeply while the organisational readiness line rises slowly. The hatched area between them is the opportunity gap.', 'cypher-one' ); ?></desc>
          <defs>
            <pattern id="gaphatch" width="10" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(45)"><line x1="0" y1="0" x2="0" y2="10" stroke="#ec3013" stroke-width="2" stroke-opacity=".45"/></pattern>
            <filter id="gapglow" x="-10%" y="-10%" width="120%" height="120%"><feGaussianBlur stdDeviation="6" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
          </defs>
          <g stroke="rgba(255,255,255,.1)"><line x1="60" y1="90" x2="600" y2="90"/><line x1="60" y1="170" x2="600" y2="170"/><line x1="60" y1="250" x2="600" y2="250"/></g>
          <path class="gfill" d="M60 330 C 220 322, 380 250, 560 70 L560 262 C 380 290, 220 316, 60 330 Z" fill="url(#gaphatch)"/>
          <path class="gdraw" d="M60 330 C 220 322, 380 250, 560 70" fill="none" stroke="#ec3013" stroke-width="6" stroke-linecap="round" filter="url(#gapglow)"/>
          <path class="gdraw g2" d="M60 330 C 220 316, 380 290, 560 262" fill="none" stroke="#f3f2f2" stroke-width="3.5" stroke-linecap="round"/>
          <line x1="60" y1="331" x2="600" y2="331" stroke="rgba(255,255,255,.4)" stroke-width="2"/>
          <line x1="60" y1="60" x2="60" y2="331" stroke="rgba(255,255,255,.4)" stroke-width="2"/>
          <g class="gfade" font-family="Helvetica Neue, Helvetica, Arial, sans-serif">
            <circle cx="560" cy="70" r="7" fill="#ec3013"/><circle cx="560" cy="262" r="7" fill="#f3f2f2"/>
            <text x="548" y="54" text-anchor="end" fill="#ff9783" font-size="16" font-weight="800"><?php esc_html_e( 'AI potential', 'cypher-one' ); ?></text>
            <text x="564" y="292" text-anchor="end" fill="#f3f2f2" font-size="15" font-weight="700"><?php echo esc_html_x( 'Organisational', 'chart label, line 1 of "Organisational readiness"', 'cypher-one' ); ?></text>
            <text x="564" y="310" text-anchor="end" fill="#f3f2f2" font-size="15" font-weight="700"><?php echo esc_html_x( 'readiness', 'chart label, line 2 of "Organisational readiness"', 'cypher-one' ); ?></text>
            <text x="330" y="232" text-anchor="middle" fill="#ff9783" font-size="21" font-weight="800"><?php esc_html_e( 'Opportunity gap', 'cypher-one' ); ?></text>
            <text x="330" y="252" text-anchor="middle" fill="#f3f2f2" font-size="12" font-weight="500"><?php esc_html_e( 'risk on one side, return on the other', 'cypher-one' ); ?></text>
          </g>
          <g font-family="Helvetica Neue, Helvetica, Arial, sans-serif" fill="#bab6b6" font-size="13" font-weight="700" text-anchor="middle"><text x="120" y="362"><?php esc_html_e( 'Tools', 'cypher-one' ); ?></text><text x="265" y="362"><?php esc_html_e( 'Automation', 'cypher-one' ); ?></text><text x="410" y="362"><?php esc_html_e( 'Agents', 'cypher-one' ); ?></text><text x="555" y="362"><?php esc_html_e( 'Autonomy', 'cypher-one' ); ?></text></g>
        </svg>
<?php else : ?>
<svg viewBox="0 0 700 420" role="img" aria-labelledby="gap-t gap-d">
          <title id="gap-t"><?php esc_html_e( 'Chart: AI potential against organisational readiness', 'cypher-one' ); ?></title>
          <desc id="gap-d"><?php esc_html_e( 'Across four stages, tools, automation, agents and autonomy, the AI potential line rises steeply while the organisational readiness line rises slowly. The shaded area between them is the opportunity gap.', 'cypher-one' ); ?></desc>
          <g stroke="#d7d3d3" stroke-width="1"><line x1="60" y1="110" x2="640" y2="110"/><line x1="60" y1="170" x2="640" y2="170"/><line x1="60" y1="230" x2="640" y2="230"/><line x1="60" y1="290" x2="640" y2="290"/></g>
          <path d="M60,318 C200,312 420,230 600,95 L600,245 C450,265 250,300 60,322 Z" fill="#ffe0d9"/>
          <path d="M60,318 C200,312 420,230 600,95" fill="none" stroke="#201e1d" stroke-width="4"/>
          <path d="M60,322 C250,300 450,265 600,245" fill="none" stroke="#605d5d" stroke-width="3"/>
          <circle cx="600" cy="95" r="6" fill="#201e1d"/><circle cx="600" cy="245" r="6" fill="#605d5d"/>
          <line x1="60" y1="330" x2="660" y2="330" stroke="#201e1d" stroke-width="2"/>
          <line x1="60" y1="60" x2="60" y2="330" stroke="#201e1d" stroke-width="2"/>
          <g font-family="Helvetica Neue, Helvetica, Arial, sans-serif">
            <text x="596" y="82" text-anchor="end" fill="#201e1d" font-size="16" font-weight="800"><?php esc_html_e( 'AI potential', 'cypher-one' ); ?></text>
            <text x="604" y="282" text-anchor="end" fill="#605d5d" font-size="15" font-weight="700"><?php echo esc_html_x( 'Organisational', 'chart label, line 1 of "Organisational readiness"', 'cypher-one' ); ?></text>
            <text x="604" y="300" text-anchor="end" fill="#605d5d" font-size="15" font-weight="700"><?php echo esc_html_x( 'readiness', 'chart label, line 2 of "Organisational readiness"', 'cypher-one' ); ?></text>
            <text x="500" y="222" text-anchor="middle" fill="#ae1800" font-size="19" font-weight="800"><?php esc_html_e( 'Opportunity gap', 'cypher-one' ); ?></text>
            <text x="500" y="240" text-anchor="middle" fill="#ae1800" font-size="12" font-weight="500"><?php esc_html_e( 'risk on one side, return on the other', 'cypher-one' ); ?></text>
            <g fill="#605d5d" font-size="15" font-weight="600" text-anchor="middle"><text x="115" y="366"><?php esc_html_e( 'Tools', 'cypher-one' ); ?></text><text x="270" y="366"><?php esc_html_e( 'Automation', 'cypher-one' ); ?></text><text x="430" y="366"><?php esc_html_e( 'Agents', 'cypher-one' ); ?></text><text x="570" y="366"><?php esc_html_e( 'Autonomy', 'cypher-one' ); ?></text></g>
          </g>
        </svg>
<?php endif; ?>
