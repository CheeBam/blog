<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 12.09.15
 * Time: 14:31
 */

namespace Framework\Model;

use Framework\DI\Service;

abstract class ActiveRecord
{
    /**
     * Column identifier.
     *
     * @var int.
     */
    public $id;

    /**
     * Returns table name.
     *
     * @return string table name.
     */
    abstract public static function getTable();

    /**
     * Returns column names.
     *
     * @return array
     */
    abstract public static function getColumns();

    /**
     * Returns id.
     *
     * @return int identifier.
     */
    abstract public static function getId();


    /**
     * Search need column in a table.
     *
     * @param string $col Column name.
     * @param mixed  $val Value.
     *
     * @return Object.
     * @throws \Framework\Exception\DIException
     */
    public static function find($col, $val)
    {
        $pdo = Service::get('pdo')->prepare(
            'select * from '.static::getTable().
            ' where '.$col.
            ' = \''.$val.'\''
        );
        $pdo->execute();
        return $pdo->fetchObject(static::class);
    }

    /**
     * Select all.
     *
     * @return Array of objects.
     * @throws \Framework\Exception\DIException
     */
    public static function findAll()
    {
        $tmp = Service::get('pdo');
        $pdo = Service::get('pdo')->query(
            'select * from '.static::getTable()
        );
        return $pdo->fetchAll($tmp::FETCH_CLASS, static::class);
    }

    /**
     * Insert data.
     *
     * @throws \Framework\Exception\DIException
     */
    public function save()
    {
        foreach ($this->getColumns() as $key) {
            $values[] = '\''.$this->$key.'\'';
        }
        Service::get('pdo')->query(
            'insert into '.static::getTable().'('.implode(',', $this->getColumns()).') values ('.implode(
                ',',
                $values
            ).')'
        );
    }


    /**
     * Update data
     *
     * @throws \Framework\Exception\DIException
     */
    public function update()
    {
        foreach ($this->getColumns() as $key) {
            $values[] = $key.' = \''.$this->$key.'\'';
        }

        Service::get('pdo')->query(
            'update '.static::getTable().' set '.implode(',', $values)
            .' where '.static::getId().' = '.$this->id
        );
    }

    /**
     * Delete data.
     *
     * @throws \Framework\Exception\DIException
     */
    public function delete()
    {
        Service::get('pdo')->query(
            'delete from '.static::getTable().
            ' where '.static::getId().
            ' = '.$this->id
        );
    }


}