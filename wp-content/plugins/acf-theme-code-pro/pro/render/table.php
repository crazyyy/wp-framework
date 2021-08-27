<?php
// Table field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Support for table field
echo $this->indent . htmlspecialchars(" <?php \$table = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ")."\n";
echo $this->indent . htmlspecialchars(" if ( \$table ) { ")."\n";
echo $this->indent . htmlspecialchars("     echo '<table>'; ")."\n";
echo $this->indent . htmlspecialchars("         if ( \$table['header'] ) { ")."\n";
echo $this->indent . htmlspecialchars("             echo '<thead><tr>'; ")."\n";
echo $this->indent . htmlspecialchars("                 echo ''; ")."\n";
echo $this->indent . htmlspecialchars("                     foreach ( \$table['header'] as \$th ) { ")."\n";
echo $this->indent . htmlspecialchars("                         echo '<th>'; ")."\n";
echo $this->indent . htmlspecialchars("                             echo \$th['c']; ")."\n";
echo $this->indent . htmlspecialchars("                         echo '</th>'; ")."\n";
echo $this->indent . htmlspecialchars("                     } ")."\n";
echo $this->indent . htmlspecialchars("                 echo '</tr>'; ")."\n";
echo $this->indent . htmlspecialchars("             echo '</thead>'; ")."\n";
echo $this->indent . htmlspecialchars("         } ")."\n";
echo $this->indent . htmlspecialchars("")."\n";
echo $this->indent . htmlspecialchars("         echo '<tbody>'; ")."\n";
echo $this->indent . htmlspecialchars("             foreach ( \$table['body'] as \$tr ) { ")."\n";
echo $this->indent . htmlspecialchars("                 echo '<tr>'; ")."\n";
echo $this->indent . htmlspecialchars("                     foreach ( \$tr as \$td ) { ")."\n";
echo $this->indent . htmlspecialchars("                         echo '<td>'.\$td['c'].'</td>'; ")."\n";
echo $this->indent . htmlspecialchars("                     } ")."\n";
echo $this->indent . htmlspecialchars("                 echo '</tr>'; ")."\n";
echo $this->indent . htmlspecialchars("             } ")."\n";
echo $this->indent . htmlspecialchars("         echo '</tbody>'; ")."\n";
echo $this->indent . htmlspecialchars("     echo '</table>'; ")."\n";
echo $this->indent . htmlspecialchars(" } ?> ")."\n";
