<?php
    function readMenu($sql) {
        require_once "../config/config.php";
        $results = array();
        if ($result =  $mysqli->query($sql)) {
            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_array()) {
                    $results[$i]['idmenu'] = $row['idmenu'];
                    $results[$i]['menu_name'] = $row['menu_name'];
                    $results[$i]['menu_pictures'] = $row['menu_pictures'];
                    $results[$i]['menu_detail'] = $row['menu_detail'];
                    $results[$i]['menu_price'] = $row['menu_price'];
                    $results[$i]['menu_stock'] = $row['menu_stock'];
                    $i++;
                }        
                $result->free_result();
            }
        } else {
            die("ERROR: Tidak dapat menjalankan $sql:" . $mysqli->error);
        }

        // Close connection
        $mysqli->close();
        return $results;
    }
?>