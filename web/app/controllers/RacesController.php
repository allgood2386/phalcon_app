<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class RacesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for races
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Races', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $races = Races::find($parameters);
        if (count($races) == 0) {
            $this->flash->notice("The search did not find any races");

            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $races,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a race
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $race = Races::findFirstByid($id);
            if (!$race) {
                $this->flash->error("race was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "races",
                    "action" => "index"
                ));
            }

            $this->view->id = $race->id;

            $this->tag->setDefault("id", $race->id);
            $this->tag->setDefault("track", $race->track);
            $this->tag->setDefault("laps", $race->laps);
            $this->tag->setDefault("distance", $race->distance);
            $this->tag->setDefault("start", $race->start);
            $this->tag->setDefault("end", $race->end);
            
        }
    }

    /**
     * Creates a new race
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "index"
            ));
        }

        $race = new Races();

        $race->track = $this->request->getPost("track");
        $race->laps = $this->request->getPost("laps");
        $race->distance = $this->request->getPost("distance");
        $race->start = $this->request->getPost("start");
        $race->end = $this->request->getPost("end");
        

        if (!$race->save()) {
            foreach ($race->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "new"
            ));
        }

        $this->flash->success("race was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "races",
            "action" => "index"
        ));
    }

    /**
     * Saves a race edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $race = Races::findFirstByid($id);
        if (!$race) {
            $this->flash->error("race does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "index"
            ));
        }

        $race->track = $this->request->getPost("track");
        $race->laps = $this->request->getPost("laps");
        $race->distance = $this->request->getPost("distance");
        $race->start = $this->request->getPost("start");
        $race->end = $this->request->getPost("end");
        

        if (!$race->save()) {

            foreach ($race->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "edit",
                "params" => array($race->id)
            ));
        }

        $this->flash->success("race was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "races",
            "action" => "index"
        ));
    }

    /**
     * Deletes a race
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $race = Races::findFirstByid($id);
        if (!$race) {
            $this->flash->error("race was not found");

            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "index"
            ));
        }

        if (!$race->delete()) {

            foreach ($race->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "races",
                "action" => "search"
            ));
        }

        $this->flash->success("race was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "races",
            "action" => "index"
        ));
    }

}
