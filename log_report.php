<!DOCTYPE html>
<html>

  <head>
    <title>Site Visits Report</title>
  </head>

  <body>

      <h1>Site Visits Report</h1>

      <table border = '1'>
        <tr>
          <th>No.</th>
          <th>Visitor</th>
          <th>Total Visits</th>
        </tr>

        <?php
            $user = "ciber";
            $password = "P@ssw0rd";
            $database = "contador_visitas";

            try {

                $db = new PDO("mysql:host=mysql;dbname=$database", $user, $password);

                $siteVisitsMap = 'siteStats';

                $i = 1;
                foreach($db->query("SELECT direccion_ip, visitas FROM contador") as $row) {
                    echo "<tr>";
                      echo "<td align = 'left'>"   . $i . "."     . "</td>";
                      echo "<td align = 'left'>"   . $row['direccion_ip']     . "</td>";
                      echo "<td align = 'right'>"  . $row['visitas'] . "</td>";
                    echo "</tr>";

                    $i++;
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }

        ?>

      </table>
  </body>

</html>
