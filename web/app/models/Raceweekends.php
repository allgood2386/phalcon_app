<?php

class Raceweekends extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $location;

    public function initialize()
    {
        $this->belongsTo("series_id", "Series", "id");
        $this->hasMany("id", "Races", "raceweekends_id");
    }
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'raceweekends';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Raceweekends[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Raceweekends
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
