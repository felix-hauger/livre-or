<?php

function is_user_in_db($user, $db):bool {

    $sql = "SELECT login FROM users";
    
    $query = $db->query($sql);
    
    $row = $query->fetch_assoc();
    
    $result = false;
    
    while ($row != null) {
    
        foreach ($row as $db_user) {
            if ($user === $db_user) {
                $result = true;
                break;
            }
        }
        $row = $query->fetch_assoc();
    
    }
    return $result;
}
