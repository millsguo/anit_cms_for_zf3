<?php

// module/SousRubrique/src/SousRubrique/Form/SousRubriqueForm.php:
namespace Blogcontent\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Rubrique\Model\RubriqueDao;
use Galerie\Form\GalerieForm;

//use Zend\Stdlib\Hydrator\ClassMethods;

class BlogcontentForm extends GalerieForm {

    protected function getRubriques() {

        $rubriquesDao = new RubriqueDao();

        $rubriques = $rubriquesDao->getAllRubriques("array");

        $rubriqueArray = array();

        foreach ($rubriques as $value) {

            $rubriqueArray[$value['id']] = $value['libelle'];
        }

        return $rubriqueArray;
    }

    /*
      protected function getSousRubriques($rubid){

      $sousrubriquesDao=  new SousRubriqueDao();

      $sousrubriques = $sousrubriquesDao->getSousrubriquesByRubrique($rubid,"array");

      $sousrubriqueArray = array();

      foreach($sousrubriques as $value){

      $sousrubriqueArray[$value['id']]=$value['libelle'];

      }

      return $sousrubriqueArray;
      }
     */
    /* TODO : get All Sous Rubriques by Id pour le select */

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('blogcontentform');
        //$this->setHydrator(new ClassMethods);
        $this->add(array(
            'name' => 'themes',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Themes abordés')
            ),
        ));
        
        $this->add(array(
            'name' => 'author',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Auteur')
            ),
        ));
        
        $this->add(array(
            'name' => 'blogdate',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Date format AAAA-MM-JJ HH:MM:SS'
            )
        ));
        
        $this->add(array(
            'name' => 'text1',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Autre texte ligne 1')
            ),
        ));
        
        $this->add(array(
            'name' => 'text2',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Autre texte ligne 2')
            ),
        ));
        
        $this->add(array(
            'name' => 'text3',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Autre texte ligne 3')
            ),
        ));
    }

}
