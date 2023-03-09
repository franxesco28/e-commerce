<?php

function startSession( ?array $initialSessionData = null ): void {
    session_start();

    if ( any( $initialSessionData ) ) {
        foreach ( $initialSessionData as $key => $value ) {
            $_SESSION[ $key ] = $value;
        }
    }

}

function endSession(): void {
   // session_destroy();
}

function any( ?array $array ) {
    return ( ! is_null( $array ) && count( $array ) > 0 );
}

//var_dump($_POST);