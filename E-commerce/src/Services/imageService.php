<?php

class ImageDto {

    public string $name;

    public string $type;

    public string $tmp_name;

    public function __construct( string $name, string $type, string $tmp_name ) {
        $this->name     = $name;
        $this->type     = $type;
        $this->tmp_name = $tmp_name;
    }
}

interface ImageService {

    public function set( ImageDto $image ): string|null;

    public function get( string $imageReference ): string|null;

}

class ImageDbService implements ImageService {

    const TABLE_NAME = 'pictures';
    const TABLE_RELATED_FIELD = 'picture_id';

    private mysqli $db;

    public function __construct( mysqli $db ) {
        $this->db = $db;
    }

    public function set( ImageDto $image ): string|null {

        if ( ! strlen( $image->tmp_name ) > 0 ) {
            return null;
        }

        $file = file_get_contents( $image->tmp_name );

        return $this->insertImage( $file, $image );
    }

    public function get( string|null $imageReference ): string|null {

        if ( is_null( $imageReference ) ) {
            return null;
        }

        $imageRow = $this->getImage( $imageReference );

        if ( is_null( $imageRow ) ) {
            return null;
        }

        $content = base64_encode( $imageRow['content'] );

        $type = $imageRow['type'];

        return "data:{$type};base64,{$content}";

    }

    public static function CreateImageTable( mysqli $db, string $aggregateTableName = null ) {

        $imageTable = self::TABLE_NAME;

        $query = "CREATE TABLE IF NOT EXISTS {$imageTable} (
                  id int  not null auto_increment primary key,
                  content longblob not null,
                  type varchar(150),
                  created_at timestamp default CURRENT_TIMESTAMP);";

        $stmt = $db->prepare( $query );
        $stmt->execute();

        if ( ! is_null( $aggregateTableName ) ) {

            self::TryCreateField( $db, $aggregateTableName );

            self::TryCreateFieldConstraint( $db, $aggregateTableName, $imageTable );

        }

    }

    private function insertImage( string $image, ImageDto $image_dto ): int|null {

        try {
            $query = 'INSERT INTO pictures(content, type) VALUES(?, ?)';

            $stmt = $this->db->prepare( $query );

            $stmt->execute( [
                $image,
                $image_dto->type
            ] );

            return $this->db->insert_id;
        } catch ( Exception ) {

            // ignored

            return null;
        }

    }

    private function getImage( int $imageId ): ?array {

        try {

            $query = $this->db->prepare( "SELECT * FROM pictures  WHERE id = ?" );

            $query->execute( [ $imageId ] );

            $result = $query->get_result();

            return $result->fetch_assoc();

        } catch ( Exception $exception ) {

            return null;
        }

    }

    private static function TryCreateField( mysqli $db, string $table): void {
        try {
            $field = self::TABLE_RELATED_FIELD;
            $query = "ALTER TABLE {$table} ADD {$field} INT null ;";
            $stmt  = $db->prepare( $query );
            $stmt->execute();
        } catch ( Exception $e ) {
            // ignored
            var_dump( $e->getMessage() );
        }
    }

    private static function TryCreateFieldConstraint( mysqli $db, string $table, string $imageTable ) {
        try {
            $field = self::TABLE_RELATED_FIELD;
            $query = "ALTER TABLE {$table} ADD CONSTRAINT fk_picture_id FOREIGN KEY ({$field}) references {$imageTable}(id);";
            $stmt  = $db->prepare( $query );
            $stmt->execute();
        } catch ( Exception $e ) {
            // ignored
            var_dump( $e->getMessage() );
        }
    }
}

class ImageLocalStorageService implements ImageService {

    public function set( ImageDto $image ): string|null {
        // TODO: Implement set() method.
    }

    public function get( string $imageReference ): string|null {
        // TODO: Implement get() method.
    }
}

class ImageRemoteStorageService implements ImageService
{

    public function set(ImageDto $image): string|null
    {
        // TODO: Implement set() method.
    }

    public function get(string $imageReference): string|null
    {
        // TODO: Implement get() method.
    }
}