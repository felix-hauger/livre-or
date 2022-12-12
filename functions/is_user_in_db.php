<?php

function is_user_in_db($user, $db):bool {

    $sql = "SELECT login FROM users";
    
    $select = $db->prepare($sql);

    $select->execute();

    // return an associative array with one entry: login
    $row = $select->fetch(PDO::FETCH_ASSOC);
    
    // user is not in db until proven wrong
    $result = false;
    
    // while the fetched row isn't null
    while ($row != null) {
        foreach ($row as $db_user) {
            
            // test if db_user & user are equals
            if ($db_user === $user) {
                $result = true;
                break;
            }
        }
        // then fetch a row
        $row = $select->fetch(PDO::FETCH_ASSOC);
        
    }

    return $result;
}

// function is_user_in_db($user, $db):bool {

//     $sql = "SELECT login FROM users";
    
//     $query = $db->query($sql);
    
//     $row = $query->fetch_assoc();
    
//     $result = false;
    
//     while ($row != null) {
    
//         foreach ($row as $db_user) {
//             if ($user === $db_user) {
//                 $result = true;
//                 break;
//             }
//         }
//         $row = $query->fetch_assoc();
    
//     }
//     return $result;
// }
