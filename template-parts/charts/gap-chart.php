<?php
/**
 * Conceptual chart: AI potential against organisational readiness.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
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
