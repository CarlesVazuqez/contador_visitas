<?php
    $user = "ciber";
    $password = "P@ssw0rd";
    $database = "Contador_visitas";

    try {

        $db = new PDO("mysql:host=mysql;dbname=$database", $user, $password);

        $siteVisitsMap  = 'siteStats';
        $visitorHashKey = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

           $visitorHashKey = $_SERVER['HTTP_CLIENT_IP'];

        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

           $visitorHashKey = $_SERVER['HTTP_X_FORWARDED_FOR'];

        } else {

           $visitorHashKey = $_SERVER['REMOTE_ADDR'];
        }

        $totalVisits = 0;

        $sql="SELECT direccion_ip, visitas FROM contador WHERE direccion_ip=:direccion_ip";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':direccion_ip', $visitorHashKey);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->execute();

        if ($result) {

            $row = $stmt->fetch();
            $totalVisits = $row['visitas'] + 1;
            $sql = "INSERT INTO contador SET visitas = visitas+1 WHERE direccion_ip=:direccion_ip";

        } else {

            $totalVisits = 1;
            $sql = "INSERT INTO contador (direccion_ip, visitas) VALUES (:direccion_ip, :visitas) ON DUPLICATE KEY UPDATE visitas=:visitas";

        }

        $sql = "INSERT INTO contador (direccion_ip, visitas) VALUES (:direccion_ip, :visitas) ON DUPLICATE KEY UPDATE visitas=:visitas";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':direccion_ip', $visitorHashKey);
        $stmt->bindParam(':visitas', $totalVisits);

        $stmt->execute();


        echo "Welcome, you've visited this page " .  $totalVisits . " times\n";

    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>
