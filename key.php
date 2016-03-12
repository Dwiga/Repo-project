<?php

/**
 * Created by PhpStorm.
 * User: avos
 * Date: 2/27/2016
 * Time: 4:39 PM
 */
function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']);
}

function seo_title($str, $options = array()) {
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    // $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => false,
    );

    // Merge options
    $options = array_merge($defaults, $options);

    $char_map = array(
        // Latin
        '\C0' => 'A', '\C1' => 'A', '\C2' => 'A', '\C3' => 'A', '\C4' => 'A', '\C5' => 'A', '\C6' => 'AE', '\C7' => 'C',
        '\C8' => 'E', '\C9' => 'E', '\CA' => 'E', '\CB' => 'E', '\CC' => 'I', '\CD' => 'I', '\CE' => 'I', '\CF' => 'I',
        '\D0' => 'D', '\D1' => 'N', '\D2' => 'O', '\D3' => 'O', '\D4' => 'O', '\D5' => 'O', '\D6' => 'O', 'O' => 'O',
        '\D8' => 'O', '\D9' => 'U', '\DA' => 'U', '\DB' => 'U', '\DC' => 'U', 'U' => 'U', '\DD' => 'Y', '\DE' => 'TH',
        '\DF' => 'ss',
        '\E0' => 'a', '\E1' => 'a', '\E2' => 'a', '\E3' => 'a', '\E4' => 'a', '\E5' => 'a', '\E6' => 'ae', '\E7' => 'c',
        '\E8' => 'e', '\E9' => 'e', '\EA' => 'e', '\EB' => 'e', '\EC' => 'i', '\ED' => 'i', '\EE' => 'i', '\EF' => 'i',
        '\F0' => 'd', '\F1' => 'n', '\F2' => 'o', '\F3' => 'o', '\F4' => 'o', '\F5' => 'o', '\F6' => 'o', 'o' => 'o',
        '\F8' => 'o', '\F9' => 'u', '\FA' => 'u', '\FB' => 'u', '\FC' => 'u', 'u' => 'u', '\FD' => 'y', '\FE' => 'th',
        '\FF' => 'y',

        // Latin symbols
        '\A9' => '(c)',

        // Greek
        '?' => 'A', '?' => 'B', 'G' => 'G', '?' => 'D', '?' => 'E', '?' => 'Z', '?' => 'H', 'T' => '8',
        '?' => 'I', '?' => 'K', '?' => 'L', '?' => 'M', '?' => 'N', '?' => '3', '?' => 'O', '?' => 'P',
        '?' => 'R', 'S' => 'S', '?' => 'T', '?' => 'Y', 'F' => 'F', '?' => 'X', '?' => 'PS', 'O' => 'W',
        '?' => 'A', '?' => 'E', '?' => 'I', '?' => 'O', '?' => 'Y', '?' => 'H', '?' => 'W', '?' => 'I',
        '?' => 'Y',
        'a' => 'a', '\DF' => 'b', '?' => 'g', 'd' => 'd', 'e' => 'e', '?' => 'z', '?' => 'h', '?' => '8',
        '?' => 'i', '?' => 'k', '?' => 'l', '\B5' => 'm', '?' => 'n', '?' => '3', '?' => 'o', 'p' => 'p',
        '?' => 'r', 's' => 's', 't' => 't', '?' => 'y', 'f' => 'f', '?' => 'x', '?' => 'ps', '?' => 'w',
        '?' => 'a', '?' => 'e', '?' => 'i', '?' => 'o', '?' => 'y', '?' => 'h', '?' => 'w', '?' => 's',
        '?' => 'i', '?' => 'y', '?' => 'y', '?' => 'i',

        // Turkish
        'S' => 'S', 'I' => 'I', '\C7' => 'C', '\DC' => 'U', '\D6' => 'O', 'G' => 'G',
        's' => 's', 'i' => 'i', '\E7' => 'c', '\FC' => 'u', '\F6' => 'o', 'g' => 'g',

        // Russian
        '?' => 'A', '?' => 'B', '?' => 'V', '?' => 'G', '?' => 'D', '?' => 'E', '?' => 'Yo', '?' => 'Zh',
        '?' => 'Z', '?' => 'I', '?' => 'J', '?' => 'K', '?' => 'L', '?' => 'M', '?' => 'N', '?' => 'O',
        '?' => 'P', '?' => 'R', '?' => 'S', '?' => 'T', '?' => 'U', '?' => 'F', '?' => 'H', '?' => 'C',
        '?' => 'Ch', '?' => 'Sh', '?' => 'Sh', '?' => '', '?' => 'Y', '?' => '', '?' => 'E', '?' => 'Yu',
        '?' => 'Ya',
        '?' => 'a', '?' => 'b', '?' => 'v', '?' => 'g', '?' => 'd', '?' => 'e', '?' => 'yo', '?' => 'zh',
        '?' => 'z', '?' => 'i', '?' => 'j', '?' => 'k', '?' => 'l', '?' => 'm', '?' => 'n', '?' => 'o',
        '?' => 'p', '?' => 'r', '?' => 's', '?' => 't', '?' => 'u', '?' => 'f', '?' => 'h', '?' => 'c',
        '?' => 'ch', '?' => 'sh', '?' => 'sh', '?' => '', '?' => 'y', '?' => '', '?' => 'e', '?' => 'yu',
        '?' => 'ya',

        // Ukrainian
        '?' => 'Ye', '?' => 'I', '?' => 'Yi', '?' => 'G',
        '?' => 'ye', '?' => 'i', '?' => 'yi', '?' => 'g',

        // Czech
        'C' => 'C', 'D' => 'D', 'E' => 'E', 'N' => 'N', 'R' => 'R', '\8A' => 'S', 'T' => 'T', 'U' => 'U',
        '\8E' => 'Z',
        'c' => 'c', 'd' => 'd', 'e' => 'e', 'n' => 'n', 'r' => 'r', '\9A' => 's', 't' => 't', 'u' => 'u',
        '\9E' => 'z',

        // Polish
        'A' => 'A', 'C' => 'C', 'E' => 'e', 'L' => 'L', 'N' => 'N', '\D3' => 'o', 'S' => 'S', 'Z' => 'Z',
        'Z' => 'Z',
        'a' => 'a', 'c' => 'c', 'e' => 'e', 'l' => 'l', 'n' => 'n', '\F3' => 'o', 's' => 's', 'z' => 'z',
        'z' => 'z',

        // Latvian
        'A' => 'A', 'C' => 'C', 'E' => 'E', 'G' => 'G', 'I' => 'i', 'K' => 'k', 'L' => 'L', 'N' => 'N',
        '\8A' => 'S', 'U' => 'u', '\8E' => 'Z',
        'a' => 'a', 'c' => 'c', 'e' => 'e', 'g' => 'g', 'i' => 'i', 'k' => 'k', 'l' => 'l', 'n' => 'n',
        '\9A' => 's', 'u' => 'u', '\9E' => 'z'
    );

    /* Make custom replacements*/
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }

    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

    // Truncate slug to max. characters
    $str = substr($str, 0, ($options['limit'] ? $options['limit'] : strlen($str)));

    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? strtolower($str) : $str;
}



class adminPage extends koneksi{
    public function __construct(){
        parent::__construct();
    }
}
?>
<?php
date_default_timezone_set('Asia/Jakarta');

class koneksi {
    private $db_host = 'localhost';
    private $db_root = 'root';
    private $db_pass = '';
    private $db_base = 'zeta';

    public $db;
    private $stmt;
    private $errDB;

    public function __construct() {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->db = new PDO( "mysql:host={$this->db_host};dbname={$this->db_base}", $this->db_root, $this->db_pass, $options);
        } catch( PDOException $e ) {
            echo $errDB = $e->getMessage();
            exit();
        }
    }

    public function __destruct() {
        $this->db = null;
    }

    public function query( $sql ) {
        $this->stmt = $this->db->prepare($sql);
    }

    public function bind( $param, $value, $type = null ) {
        if ( is_null($type) === true ) {
            switch (true) {
                case is_int( $value ):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool( $value ):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null( $value ):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue( $param, $value, $type );
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function fetchAll() {
        $this->execute();
        return $this->stmt->fetchAll( PDO::FETCH_OBJ );
    }

    public function fetch() {
        $this->execute();
        return $this->stmt->fetch( PDO::FETCH_OBJ );
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }

    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    public function endTransaction() {
        return $this->db->commit();
    }

    public function cancelTransaction() {
        return $this->db->rollBack();
    }

    public function debugDumpParams() {
        return $this->stmt->debugDumpParams();
    }
}