<?php

namespace Mapcontent\Form;


use Contenu\Form\ContenuInputFilter;
use ExtLib\Utils;
//use Zend\Filter\StripTags;
//use Zend\Filter\StringTrim;

class MapcontentInputFilter extends ContenuInputFilter {

    protected $translator;
    
    public function __construct()
    {
        parent::__construct();
        $this->translator = new Utils();
    }
}
