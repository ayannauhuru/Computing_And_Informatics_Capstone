<?php 


error_reporting (E_ALL); 
ini_set ('display_errors', 'on');
echo ("> ~~~~~~~~~~~Germany Stadium Review App~~~~~~~~~~~~");

function getData($place_id) {       
    $curl = curl_init();

    $id = $place_id;
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://maps.googleapis.com/maps/api/place/details/json?fields=name%2Crating%2Cformatted_phone_number%2Caddress_component%2Creview%2Crating%2Cformatted_address&place_id=$id&key=AIzaSyCzhrVxHxEL68wwGLs9b9Ouoa0dpgmGIJQ",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);

    curl_close($curl);
    return $response;
}

echo("> \nEnter a google place id from Germany\n");

$handle = fopen ("php://stdin","r");

$id = fgets($handle);

fclose($handle);

$data = getData(trim($id));

echo("> \nRetrieving Data from Google\n");

echo("> \nWriting data to Database\n");

class Database {
    private static $dsn = "mysql:host=sql5.freemysqlhosting.net;dbname=sql5475001";
    private static $username = 'sql5475001';
    private static $password = 'EkPC5F21V8';
    private static $db;
    private function __construct() {}
    public static function getDB () {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$password);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                echo $error_message;
                exit();
            }
        }
        return self::$db;
    }
}

function flushTable() {
    $db = Database::getDB();
    $query = 'DELETE FROM sql5475001.stadiumReviews';
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
    echo("flushed");
}

function write($data, $id) {
    $db = Database::getDB();
    $query = 'INSERT INTO sql5475001.stadiumReviews (id, formatted_address, name, profile_photo_url, author_name, rating, text, relative_time_description) VALUES (:id, :formatted_address, :name, :profile_photo_url, :author_name, :rating, :text, :relative_time_description)';
    
    for($i = 0; $i < count($data['result']['reviews']); $i++) {
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':formatted_address', $data['result']['formatted_address']);
        $statement->bindValue(':name', $data['result']['name']);
        $statement->bindValue(':profile_photo_url', $data['result']['reviews'][$i]['profile_photo_url']);
        $statement->bindValue(':author_name', $data['result']['reviews'][$i]['author_name']);
        $statement->bindValue(':rating', $data['result']['reviews'][$i]['rating']);
        $statement->bindValue(':text', $data['result']['reviews'][$i]['text']);
        $statement->bindValue(':relative_time_description', $data['result']['reviews'][$i]['relative_time_description']);
        $statement->execute();
        $statement->closeCursor();
    }
    echo("write");

}


function read() {
    $db = Database::getDB();
    $query = 'SELECT * FROM sql5475001.stadiumReviews';
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();
    echo("read");
    return $rows;
}


//   ChIJJUECKky_uEcRZ6IqXw5F3ts

// Removing no need to delete table
// flushTable();

write($data, $id);

print_r(read());
