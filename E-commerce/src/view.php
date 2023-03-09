<?php

require_once "pdo/config.inc.php";
require_once "pdo/Helper.inc.php";
require_once  "mysqli/mysqli.php";
require_once "mysqli/query.php";
require_once "pdo/session.php";

const CONTACT_ID = 'contactId';
const ACTION = 'action';

if (array_key_exists(ACTION ,$_POST) && array_key_exists(CONTACT_ID,$_POST)) {

    $db = connectDb();

    if ( ! deleteContact($db, $_POST[CONTACT_ID] ) ) {

        echo "CANCELLAZZIONE FALLITA";

    } else {

        echo 'CONTATTO CANCELLATO';

    }

}

if ( ! array_key_exists( CONTACT_ID , $_GET ) ) {

    dieWith404();

}

$contactId = $_GET[ CONTACT_ID ];


$db = connectDb();

$contact = getContact($db, $contactId);

if ( is_null ($contact) )   {

    dieWith404();

}


var_dump($contact);

function connectDb(): ?mysqli {
    return connectMySQLi(HOST, PORT, USER, PASSWORD, DB);
}

?>

<form method="post">
    <input type="hidden" name="<?=CONTACT_ID?>" value="<?= $contactId?>">
    <input type="submit" name="<?=ACTION?>" value="DELETE">
</form>

<a href="list.php">Torna alla lista</a>


































