<?php

namespace Rubrique\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Rubrique\Model\Rubrique;
use Rubrique\Form\RubriqueForm;
use Rubrique\Form\RubriqueInputFilter as InputFilter;
use Rubrique\Model\RubriqueDao;
use Rubrique\Model\Meta;
use Rubrique\Form\MetaForm;
use Rubrique\Form\MetaInputFilter;
use Rubrique\Model\MetaDao;
use Application\Factory\CacheDataListener;
use Zend\Mvc\I18n\Translator;
use ExtLib\Utils;
use ExtLib\FileManager;

class RubriqueController extends AbstractActionController {

    private $cache;
    private $translator;

    public function __construct(CacheDataListener $cacheDataListener, Translator $translator){
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    public function indexAction() {

        $rubriqueDao = new RubriqueDao();

        return new ViewModel(array(
            'rubriques' => $rubriqueDao->getAllRubriques("object")
        ));
    }

    // Add content to this method:
    public function addAction() {

        $form = new RubriqueForm();
        //$path = BASE_PATH . "/module/Siteprivate/view/siteprivate/siteprivate/";

        // $this->translator = $this->getServiceLocator()->get('translator');
        $form->get('submit')->setAttribute('value', $this->translator->translate('Ajouter'));

        $rubriqueDao = new RubriqueDao();
        $rubrique = new Rubrique();

        //$form->bind($rubrique);
        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $utils = new Utils();
                $filemanager = new FileManager();
                //$request->getPost()->set('libelle', $utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                $rubrique->setLibelle($utils->stripTags_replaceHtmlChar_trim($rubrique->getLibelle(), true, true, true));
                $rubrique = Rubrique::fromArray($form->getData());
                $filename = $filemanager->formatNameFile($rubrique->getFilename());
                $rubrique->setFilename($filename);
                
                $idInserted = $rubriqueDao->saveRubrique($rubrique);
                
                /* TO DO create phtml file
                if(strcmp($rubrique->getScope(),'private') == 0){
                    //
                    $filemanager->createFile($path, $filename);
                }
                 * 
                 */
                
                //flush cache
                $this->cache->getCacheService()->flush();
                // Redirect to list of rubriques
                return $this->redirect()->toRoute('rubrique', array('action' => 'edit', 'id' => $idInserted));
            } else {
                return array(
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }

        return array('form' => $form,
            'error' => '');
    }

    public function editAction() {

        $rubriqueDao = new RubriqueDao();
        $metaDao = new MetaDao();
        //$path = BASE_PATH . "/module/Siteprivate/view/siteprivate/siteprivate/";
        // $this->translator = $this->getServiceLocator()->get('translator');

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('rubrique', array(
                        'action' => 'add'
            ));
        }

        $rubrique = $rubriqueDao->getRubrique($id);

        $rubriqueId = $rubrique->getId();
        if (!empty($id)) {
            if (empty($rubriqueId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }

        $form = new RubriqueForm();

        $form->get('libelle')->setAttribute('value', $rubrique->getLibelle());
        $form->get('id')->setAttribute('value', $rubrique->getId());
        $form->get('rang')->setAttribute('value', $rubrique->getRang());
        $form->get('scope')->setAttribute('value', $rubrique->getScope());
        $form->get('spaceId')->setAttribute('value', $rubrique->getSpaceId());
        $form->get('filename')->setAttribute('value', $rubrique->getFilename());
        $form->get('contactForm')->setAttribute('value', (int) $rubrique->getHasContactForm());
        $form->get('messageForm')->setAttribute('value', (int) $rubrique->getHasMessageForm());
        $form->get('updateForm')->setAttribute('value', (int) $rubrique->getHasUpdateForm());
        $form->get('submit')->setAttribute('value', $this->translator->translate('Modifier'));

        $metaForm = new MetaForm();
        $metaForm->get('rubriqueid')->setAttribute('value', $rubrique->getId());
        $metas = $metaDao->getAllMetasByRubrique($id, 'object');

        $request = $this->getRequest();

        if ($request->isPost()) {

            //$form->setInputFilter($rubrique->getInputFilter());
            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $utils = new Utils();
                $fileManager = new FileManager();
                $request->getPost()->set('libelle', $utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                $rubrique = Rubrique::fromArray($form->getData());
                $filename = $fileManager->formatNameFile($rubrique->getFilename());
                $rubrique->setFilename($filename);

                if (strcmp($rubrique->getScope(), "public") == 0) {
                    $rubrique->setSpaceId(-1);
                }
                
                /*TODO renamefile
                $rubriqueOld = $rubriqueDao->getRubrique($rubrique->getId());
                else{
                    if (strcmp($rubriqueOld->getFilename(), $rubrique->getFilename()) != 0) {
                        $fileManager->renameExistingFile($path, $rubriqueOld->getFilename(), $rubrique->getFilename());
                    }
                }
                 * 
                 */

                $rubriqueDao->saveRubrique($rubrique);

                //flush cache
                $this->cache->getCacheService()->flush();

                // Redirect to list of rubriques
                return $this->redirect()->toRoute('rubrique');
            } else {

                return array(
                    'id' => $id,
                    'form' => $form,
                    'metaform' => $metaForm,
                    'metas' => $metas,
                    'error' => $form->getMessages());
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'metaform' => $metaForm,
            'metas' => $metas,
            'error' => ''
        );
    }

    public function deleteAction() {

        //$this->getServiceLocator()->get('CacheListener')->getCacheService()->flush();

        $rubriqueDao = new RubriqueDao();
        $fileManager = new FileManager();

        // $this->translator = $this->getServiceLocator()->get('translator');

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('rubrique');
        }

        $rubrique = $rubriqueDao->getRubrique($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');

                $rubriqueDao->deleteRubrique($id);
                $fileManager->deletefile($rubrique->getFileName(), $this->path);
                //flush cache
                $this->cache->getCacheService()->flush();
            }

            // Redirect to list of rubriques
            return $this->redirect()->toRoute('rubrique');
        }

        return array(
            'id' => $id,
            'rubrique' => $rubrique
        );
    }

    function addmetaajaxAction() {

        $form = new MetaForm();
        $metaDao = new MetaDao();
        $meta = new Meta();
        // $this->translator = $this->getServiceLocator()->get('translator');
        //$form->bind($meta);
        $request = $this->getRequest();

        if ($request->isPost()) {

            //$form->setInputFilter($rubrique->getInputFilter());
            $form->setInputFilter(new MetaInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $utils = new Utils();
                $request->getPost()->set('metakey', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metakey'), true, true, true));
                $request->getPost()->set('metavalue', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metavalue'), true, true, true));
                $meta->setMetakey($request->getPost('metakey'));
                $meta->setMetavalue($request->getPost('metavalue'));
                $meta->setRubriqueid($request->getPost('rubriqueid'));
                //get number of row inserted
                $row = $metaDao->saveMeta($meta);

                $result = array();

                if ($row == 0) {
                    $result['error'] = $this->translator->translate("Un problème est survenu, veuillez recommencer");
                } else if ($row > 0) {
                    $result['result'] = "OK";
                    $result['metaId'] = $row;
                }

                return new JsonModel(
                        $result
                );
            } else {
                return new JsonModel(array(
                    'error' => $form->getMessages()
                ));
            }
        }

        return array('form' => $form,
            'error' => '');
    }

    function updatemetaajaxAction() {

        $id = (int) $this->params()->fromRoute('id', 0);
        $meta = new Meta();
        // $this->translator = $this->getServiceLocator()->get('translator');
        $metaDao = new MetaDao();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $utils = new Utils();
            //$meta->setMetakey($request->getPost()->set('metakey', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metakey'), true, true, true)));
            //$meta->setMetavalue($request->getPost()->set('metavalue', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metavalue'), true, true, true)));
            $meta->setMetakey($utils->stripTags_replaceHtmlChar_trim($request->getPost('metakey'), true, true, true));
            $meta->setMetavalue($utils->stripTags_replaceHtmlChar_trim($request->getPost('metavalue'), true, true, true));
            $meta->setMetaid($id);
            $meta->setRubriqueid((int) $request->getPost('rubriqueid'));
            //get number of row inserted
            $row = $metaDao->saveMeta($meta);
            $result = array();

            //if ($row == 0 || $row > 1) {
            if ($row > 1) {
                $result['error'] = $this->translator->translate("Un problème est survenu, veuillez recommencer");
            } else if ($row == 1) {
                $result['result'] = "OK";
            }

            return new JsonModel(
                    $result
            );
        }
    }

    function deletemetaajaxAction() {

        $metaid = (int) $this->params()->fromRoute('id', 0);
        // $this->translator = $this->getServiceLocator()->get('translator');
        $metaDao = new MetaDao();
        $request = $this->getRequest();

        if ($request->isPost()) {

            //get number of deleted row
            $row = $metaDao->deleteMeta($metaid);

            $result = array();

            if ($row == 0 || $row > 1) {
                $result['error'] = $this->translator->translate("Un problème est survenu, veuillez recommencer");
            } else if ($row == 1) {
                $result['result'] = "OK";
            }

            return new JsonModel(
                    $result
            );
        }
    }

}
