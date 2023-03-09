<?php

function getContact (mysqli $db,string $contactId ): ?array {
    try {

        $query = $db ->prepare("SELECT * FROM contacts WHERE id = ?");

        $query ->execute([$contactId]);

        $result = $query->get_result();

        return $result->fetch_assoc() ;

    } catch ( Exception $exception ) {

        addErrorToLog($exception->getMessage());

        return null;
    }

}

function getContacts(mysqli $db): mysqli_result|bool{
    return  $db->query('SELECT * FROM contacts WHERE active = 1' );
}












