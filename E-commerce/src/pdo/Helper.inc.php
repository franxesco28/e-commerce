<?php

use JetBrains\PhpStorm\NoReturn;

function hasData (?string $str ): bool {

    if (is_null($str) ) {
        return false;
    }

    if (strlen ($str) == 0 ) {
        return false;
    }

    return true;
}

function getPageTitle( ?string $sectionTitle = null ): string {

    $pageTitle   = "Contacts";
    $scriptName  = getScriptNameFromServerVariables();
    $sectionName = hasData( $sectionTitle ) ? $sectionTitle : $scriptName;
    $sectionName = ucfirst( $sectionName );
    $pageTitle   .= " | $sectionName";

    return $pageTitle;
}

function getPageHeader(string $title): string {
    $template = HEADER ;
    return str_replace( '#title', $title, $template );
}

function getPageFooter(string $scripts = ""): string {
    $template = FOOTER;
    return str_replace( '#scripts', $scripts, $template );
}

function getValue( string $fieldName, array $values ): ?string {

    if ( array_key_exists( $fieldName, $values ) ) {
        return $values[ $fieldName ];
    }

    return null;
}

function getScriptNameFromServerVariables(): array|string {
    $scriptArr  = explode( '\\', $_SERVER['SCRIPT_FILENAME'] );
    $scriptName = str_replace( '.php', '', $scriptArr[ array_key_last( $scriptArr ) ] );

    return $scriptName;
}

/*require_once "src/Services/imageService.php";

startSession( $_POST );

function getProfileImage( array $contact ): string | null {

    $nameInitial        = $contact['name'][0];
    $surnameInitial     = substr( $contact['surname'], 0, 1 );
    $placeHolderContent = "https://via.placeholder.com/150/0000FF/808080?text={$nameInitial}{$surnameInitial}";

    $db = connectMySQLi( HOST,PORT, USER ,PASSWORD ,DB  );

    $imageService = new ImageDbService($db);

    $profileImage = $imageService->get($contact['picture_id']) ?? $placeHolderContent;

    $db->close();

    return $profileImage;
}
*/

function  addErrorToLog(string $error): void {

    if (!array_key_exists('errors', $_SESSION) || is_null($_SESSION['errors'])){
        $_SESSION['errors'] = [];
    }

    $_SESSION['errors'][] = $error;
}

function getLog():string {

    if (!array_key_exists('errors', $_SESSION)) {
        return '';
    }

    return implode('<br>',$_SESSION['errors']);
}

#[NoReturn]
function dieWith404(): void {
    $headerContent = $_SERVER['SERVER_PROTOCOL'] . "404 Not Found";

    header($headerContent);

    include "404.php";

    die();
}