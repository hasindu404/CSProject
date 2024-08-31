<?php

namespace Backpack\CRUD\app\Models\Traits;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Methods for working with the Enum column in MySQL.
|--------------------------------------------------------------------------
*/
trait HasEnumFields
{
    public static function getPossibleEnumValues($field_name)
    {
        $instance = new static(); // create an instance of the model to be able to get the table name

        $connection = $instance->getConnection();

        $table_prefix = Config::get('database.connections.'.$connection->getName().'.prefix');

        try {
            $select = app()->version() < 10 ?
                        DB::raw('SHOW COLUMNS FROM `'.$table_prefix.$instance->getTable().'` WHERE Field = "'.$field_name.'"') :
                        DB::raw('SHOW COLUMNS FROM `'.$table_prefix.$instance->getTable().'` WHERE Field = "'.$field_name.'"')->getValue($connection->getQueryGrammar());

            $type = $connection->select($select)[0]->Type;
        } catch (\Exception $e) {
            abort(500, 'Enum field type is not supported - it only works on MySQL. Please use select_from_array instead.');
        }

        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }

        return $enum;
    }

    public static function getEnumValuesAsAssociativeArray($field_name)
    {
        $instance = new static();
        $enum_values = $instance->getPossibleEnumValues($field_name);

        $array = array_flip($enum_values);

        foreach ($array as $key => $value) {
            $array[$key] = $key;
        }

        return $array;
    }
}
