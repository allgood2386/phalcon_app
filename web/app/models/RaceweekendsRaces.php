<?php

class RaceweekendsRaces extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $raceweekends_id;

    /**
     *
     * @var integer
     */
    public $races_id;

    public function initialize()
    {
        $this->hasMany("id", "RobotsParts", "robots_id");
    }
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'raceweekends_races';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RaceweekendsRaces[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RaceweekendsRaces
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
