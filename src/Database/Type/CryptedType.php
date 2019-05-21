<?php
namespace App\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type;
use Cake\Utility\Security;
use PDO;

class CryptedType extends Type
{

    public $key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';


    public function toDatabase($value, Driver $driver)
    {
        return Security::encrypt($value, $this->key);
    }

    public function toPHP($value, Driver $driver)
    {
        if ($value === null) {
            return $value;
        }

        var_dump(Security::decrypt($value, $this->key));
        return Security::decrypt($value, $this->key);
    }

    public function toStatement($value, Driver $driver)
    {
        if ($value === null) {
            return PDO::PARAM_NULL;
        }
        return PDO::PARAM_STR;
    }

    public function marshal($value)
    {
        if (is_array($value) || $value === null) {
            return $value;
        }
        return Security::decrypt($value, Security::salt());
    }
}
