<?php

namespace Pagews\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Rubrique\Model\RubriqueDao;
use Sousrubrique\Model\Sousrubriquedao;
use Pagearrangement\Model\PagearrangementDao;

<<<<<<< HEAD
class PagewsController extends AbstractActionController {

    public function getallpagesAction() {
=======
class PagewsController extends AbstractActionController
{

    public function getallpagesAction()
    {
>>>>>>> admin_publishing
        $rubriqueDao = new RubriqueDao();
        $allPagesBySpace = $rubriqueDao->getAllRubriques("array");

        return new JsonModel(array(
            'data' => $allPagesBySpace
        ));
    }

<<<<<<< HEAD
    public function getallpagesbyspaceidAction() {
=======
    public function getallpagesbyspaceidAction()
    {
>>>>>>> admin_publishing
        $spaceId = $this->params()->fromRoute('id');
        $rubriqueDao = new RubriqueDao();
        $allPagesBySpace = $rubriqueDao->getAllRubriquesBySpaceId($spaceId, "array");

        return new JsonModel(array(
            'data' => $allPagesBySpace
        ));
    }

<<<<<<< HEAD
    public function getallsectionsbypageidAction() {
        $pageId = $this->params()->fromRoute('id');
        $sousrubriqueDao = new Sousrubriquedao();
        $sousrubriques = $sousrubriqueDao->getSousrubriquesByRubrique($pageId, "array");
        return new JsonModel(array(
            'data' => $sousrubriques
        ));
    }

    public function getpagearrangementbypagenameAction() {
=======
    /*
        public function getallsectionsbypageidAction() {
            $pageId = $this->params()->fromRoute('id');
            $sousrubriqueDao = new Sousrubriquedao();
            $sousrubriques = $sousrubriqueDao->getSousrubriquesByRubrique($pageId, "array");
            return new JsonModel(array(
                'data' => $sousrubriques
            ));
        }
    */
    public function getpagearrangementbypagenameAction()
    {
>>>>>>> admin_publishing
        $filename = $this->params()->fromRoute('id');
        // var_dump($filename);
        $rubriqueDao = new RubriqueDao();
        $rubrique = $rubriqueDao->getRubriqueByFilename($filename, "array");
        $rubriqueId = (int)$rubrique['id'];
        // var_dump($rubriqueId);
        // exit;
        $pageArrangementDao = new PagearrangementDao();
        $pageArrangement = $pageArrangementDao->getPage($rubriqueId, "asc", "array");

        return new JsonModel(array(
            'data' => $pageArrangement
        ));
    }

    public function getpagearrangementbypageidAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        $pageArrangementDao = new PagearrangementDao();
        $pageArrangement = $pageArrangementDao->getPage($id, "asc", "array");

        return new JsonModel(array(
            'data' => $pageArrangement
        ));
    }

}
