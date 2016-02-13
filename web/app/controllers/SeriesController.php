<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class SeriesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $this->assets
          ->addJs('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js')
          ->addCss('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css', false)
          ->addJs('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js', false);
    }

    /**
     * Searches for series
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Series', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $series = Series::find($parameters);
        if (count($series) == 0) {
            $this->flash->notice("The search did not find any series");

            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $series,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->assets
          ->addJs('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js')
          ->addCss('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css', false)
          ->addJs('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js', false);
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->assets
          ->addJs('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js')
          ->addCss('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css', false)
          ->addJs('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js', false);
    }

    /**
     * Edits a serie
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $serie = Series::findFirstByid($id);
            if (!$serie) {
                $this->flash->error("serie was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "series",
                    "action" => "index"
                ));
            }
            $this->assets->addJs('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js');
            $this->assets->addCss('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css', false);
            $this->assets->addJs('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js', false);
            $this->view->id = $serie->id;

            $this->tag->setDefault("id", $serie->id);
            $this->tag->setDefault("name", $serie->name);
            $this->tag->setDefault("start", $serie->start);
            $this->tag->setDefault("end", $serie->end);
        }
    }

    /**
     * Creates a new serie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "index"
            ));
        }

        $serie = new Series();

        $serie->name = $this->request->getPost("name");
        $serie->start = $this->request->getPost("start");
        $serie->end = $this->request->getPost("end");
        

        if (!$serie->save()) {
            foreach ($serie->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "new"
            ));
        }

        $this->flash->success("serie was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "series",
            "action" => "index"
        ));
    }

    /**
     * Saves a serie edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $serie = Series::findFirstByid($id);
        if (!$serie) {
            $this->flash->error("serie does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "index"
            ));
        }

        $serie->name = $this->request->getPost("name");
        $serie->start = $this->request->getPost("start");
        $serie->end = $this->request->getPost("end");
        

        if (!$serie->save()) {

            foreach ($serie->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "edit",
                "params" => array($serie->id)
            ));
        }

        $this->flash->success("serie was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "series",
            "action" => "index"
        ));
    }

    /**
     * Deletes a serie
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $serie = Series::findFirstByid($id);
        if (!$serie) {
            $this->flash->error("serie was not found");

            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "index"
            ));
        }

        if (!$serie->delete()) {

            foreach ($serie->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "series",
                "action" => "search"
            ));
        }

        $this->flash->success("serie was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "series",
            "action" => "index"
        ));
    }

}
