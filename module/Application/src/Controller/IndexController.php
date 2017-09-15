<?php
namespace Application\Controller;

use Application\Factory\CacheDataListener;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\I18n\Translator;

class IndexController extends AbstractActionController
{

    private $cache;
    private $translator;

    public function __construct(CacheDataListener $cacheDataListener, Translator $translator){
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    public function indexAction()
    {
        return $this->redirect()->toRoute('Sitepublic', array('action' => 'displaypublicpage'));
    }
}
