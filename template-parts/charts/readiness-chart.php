<?php
/**
 * Illustrative readiness chart: five columns of readiness against AI potential.
 *
 * @package Cypher_One
 */

defined( 'ABSPATH' ) || exit;
?>
<svg viewBox="0 0 600 400" role="img" aria-labelledby="sys-t sys-d">
          <title id="sys-t"><?php esc_html_e( 'Diagram: organisational readiness against what AI potential now demands, in five parts', 'cypher-one' ); ?></title>
          <desc id="sys-d"><?php esc_html_e( 'Five columns, strategy and direction, data and technology foundation, governance and risk management, processes and operating model, and people, skills and change, show how far an organisation\'s readiness reaches. A red line near the top marks what current AI potential demands. The red dashed space above each column is the readiness gap.', 'cypher-one' ); ?></desc>
          <g stroke="#4a4747" stroke-width="1"><line x1="0" y1="40" x2="600" y2="40"/><line x1="0" y1="80" x2="600" y2="80"/><line x1="0" y1="120" x2="600" y2="120"/><line x1="0" y1="160" x2="600" y2="160"/><line x1="0" y1="200" x2="600" y2="200"/><line x1="0" y1="240" x2="600" y2="240"/><line x1="0" y1="280" x2="600" y2="280"/><line x1="0" y1="320" x2="600" y2="320"/><line x1="0" y1="360" x2="600" y2="360"/><line x1="40" y1="0" x2="40" y2="400"/><line x1="80" y1="0" x2="80" y2="400"/><line x1="120" y1="0" x2="120" y2="400"/><line x1="160" y1="0" x2="160" y2="400"/><line x1="200" y1="0" x2="200" y2="400"/><line x1="240" y1="0" x2="240" y2="400"/><line x1="280" y1="0" x2="280" y2="400"/><line x1="320" y1="0" x2="320" y2="400"/><line x1="360" y1="0" x2="360" y2="400"/><line x1="400" y1="0" x2="400" y2="400"/><line x1="440" y1="0" x2="440" y2="400"/><line x1="480" y1="0" x2="480" y2="400"/><line x1="520" y1="0" x2="520" y2="400"/><line x1="560" y1="0" x2="560" y2="400"/></g>
          <line x1="0" y1="340" x2="600" y2="340" stroke="#f3f2f2" stroke-width="2"/>
          <g fill="none" stroke="#ec3013" stroke-width="2" stroke-dasharray="4 4"><rect x="37" y="81" width="96" height="98"/><rect x="149" y="81" width="96" height="160"/><rect x="260" y="81" width="96" height="181"/><rect x="372" y="81" width="96" height="139"/><rect x="483" y="81" width="96" height="77"/></g>
          <line x1="0" y1="80" x2="600" y2="80" stroke="#ec3013" stroke-width="2"/>
          <text x="40" y="68" fill="#ff9783" font-family="Helvetica Neue, Helvetica, Arial, sans-serif" font-size="11" font-weight="700" letter-spacing="1.5"><?php esc_html_e( 'AI POTENTIAL', 'cypher-one' ); ?></text>
          <g fill="#f3f2f2"><rect x="36" y="179" width="98" height="161"/><rect x="148" y="241" width="98" height="99"/><rect x="259" y="262" width="98" height="78"/><rect x="371" y="220" width="98" height="120"/><rect x="482" y="158" width="98" height="182"/></g>
          <rect class="sys-pulse" x="300" y="234" width="16" height="16" fill="#ec3013"/>
          <g fill="#bab6b6" font-family="Helvetica Neue, Helvetica, Arial, sans-serif" font-size="10.5" font-weight="700" letter-spacing=".8" text-anchor="middle"><text x="85" y="362"><?php echo esc_html_x( 'Strategy and', 'chart label, line 1', 'cypher-one' ); ?></text><text x="85" y="378"><?php echo esc_html_x( 'direction', 'chart label, line 2', 'cypher-one' ); ?></text><text x="196" y="362"><?php echo esc_html_x( 'Data and', 'chart label, line 1', 'cypher-one' ); ?></text><text x="196" y="378"><?php echo esc_html_x( 'technology', 'chart label, line 2', 'cypher-one' ); ?></text><text x="308" y="362"><?php echo esc_html_x( 'Governance', 'chart label, line 1', 'cypher-one' ); ?></text><text x="308" y="378"><?php echo esc_html_x( 'and risk', 'chart label, line 2', 'cypher-one' ); ?></text><text x="420" y="362"><?php echo esc_html_x( 'Processes and', 'chart label, line 1', 'cypher-one' ); ?></text><text x="420" y="378"><?php echo esc_html_x( 'operating model', 'chart label, line 2', 'cypher-one' ); ?></text><text x="531" y="362"><?php echo esc_html_x( 'People, skills', 'chart label, line 1', 'cypher-one' ); ?></text><text x="531" y="378"><?php echo esc_html_x( 'and change', 'chart label, line 2', 'cypher-one' ); ?></text></g>
          </svg>
