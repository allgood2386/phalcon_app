<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class RaceweekendsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for raceWeekends
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Raceweekends', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $raceWeekends = Raceweekends::find($parameters);
        if (count($raceWeekends) == 0) {
            $this->flash->notice("The search did not find any raceWeekends");

            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $raceWeekends,
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
     * Edits a raceWeekend
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $raceWeekend = Raceweekends::findFirstByid($id);
            if (!$raceWeekend) {
                $this->flash->error("raceWeekend was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "raceWeekends",
                    "action" => "index"
                ));
            }

            $this->view->id = $raceWeekend->id;

            $this->tag->setDefault("id", $raceWeekend->id);
            $this->tag->setDefault("name", $raceWeekend->name);
            $this->tag->setDefault("location", $raceWeekend->location);
            $this->tag->setDefault("start", $raceWeekend->start);
            $this->tag->setDefault("end", $raceWeekend->end);
            
        }
    }

    /**
     * Creates a new raceWeekend
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "index"
            ));
        }

        $raceWeekend = new Raceweekends();

        $raceWeekend->name = $this->request->getPost("name");
        $raceWeekend->location = $this->request->getPost("location");
        $raceWeekend->start = $this->request->getPost("start");
        $raceWeekend->end = $this->request->getPost("end");
        $raceWeekend->series_id = $this->request->get("series_id");
        

        if (!$raceWeekend->save()) {
            foreach ($raceWeekend->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "new"
            ));
        }

        $this->flash->success("raceWeekend was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "raceWeekends",
            "action" => "index"
        ));
    }

    /**
     * Saves a raceWeekend edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $raceWeekend = Raceweekends::findFirstByid($id);
        if (!$raceWeekend) {
            $this->flash->error("raceWeekend does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "index"
            ));
        }

        $raceWeekend->name = $this->request->getPost("name");
        $raceWeekend->location = $this->request->getPost("location");
        $raceWeekend->start = $this->request->getPost("start");
        $raceWeekend->end = $this->request->getPost("end");
        $raceWeekend->series_id = $this->request->getPost("series_id");
        

        if (!$raceWeekend->save()) {

            foreach ($raceWeekend->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "edit",
                "params" => array($raceWeekend->id)
            ));
        }

        $this->flash->success("raceWeekend was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "raceWeekends",
            "action" => "index"
        ));
    }

    /**
     * Deletes a raceWeekend
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $raceWeekend = Raceweekends::findFirstByid($id);
        if (!$raceWeekend) {
            $this->flash->error("raceWeekend was not found");

            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "index"
            ));
        }

        if (!$raceWeekend->delete()) {

            foreach ($raceWeekend->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "raceWeekends",
                "action" => "search"
            ));
        }

        $this->flash->success("raceWeekend was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "raceWeekends",
            "action" => "index"
        ));
    }

}
