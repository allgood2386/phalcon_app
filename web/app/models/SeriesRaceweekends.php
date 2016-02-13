<?php

class SeriesRaceweekends extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $series_id;

    public function initialize()
    {
        $this->belongsTo("series_id", "Series", "id");
        $this->belongsTo("raceweekend_id", "Raceweekends", "id");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'series_raceweekends';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SeriesRaceweekends[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SeriesRaceweekends
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
