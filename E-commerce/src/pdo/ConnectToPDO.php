<?php

$host = 'localhost' ;
$dbName = 'e_commerce_db';
$user = "root";
$password = '2802';
$option = [];
?>

<?php /*function connectPDO($host,$dbName,$user,$password, ) : ?PDO {
    try {
        return new PDO("mysql:host={$host};dbname={$dbName}",
            $user,
            $password,
            []);
    } catch (Exception $e) {

        var_dump($e -> getMessage());

        return null;

    }
}
function closePDO(PDO $db ): void {
    $db = null ;
}
*/?>

<?php

/**
 * Create new UserData // create contact
 *
 * @param PDO $db
 * @param array $_params
 * @return bool
 */
function createContact(PDO $db, array $_params): bool { //createContact

    try {

        $statement = $db->prepare(
            "INSERT INTO contacts (name,surname,email,phone_number,picture)
                       VALUES (?,?,?,?,?)");

        $name = array_key_exists('name', $_params) ? $_params['name'] : throw new Exception('Name is mandatory');
        $surname = array_key_exists('surname', $_params) ? $_params['surname'] : null ;
        $email = array_key_exists('email', $_params) ? $_params['email'] : throw new Exception('Email is mandatory');
        $phone_number = array_key_exists('phone', $_params) ? $_params['phone'] : throw new Exception('Phone is mandatory');
        $picture_id = array_key_exists('picture_id', $_params) ? $_params['picture_id'] : null;
        $statement->execute( [
            $name,
            $surname,
            $email,
            $phone_number,
            $picture_id
        ]);

        return true;

    } catch (Exception $e) {

        //var_dump($e->getMessage());
        //var_dump($_params);

        return false;

    }

}