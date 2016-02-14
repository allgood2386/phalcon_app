<?php

class Races extends \Phalcon\Mvc\Model
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
    public $track;

    /**
     *
     * @var string
     */
    public $laps;

    /**
     *
     * @var string
     */
    public $distance;

    /**
     *
     * @var string
     */
    public $start;

    /**
     *
     * @var string
     */
    public $end;

    /**
     *
     * @var integer
     */
    public $raceweekends_id;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function initialize() {
        $this->belongsTo("raceweekends_id", "Raceweekends", "id");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Races[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Races
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'races';
    }

}
