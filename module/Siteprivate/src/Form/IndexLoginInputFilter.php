<?php

namespace Siteprivate\Form;

use Login\Form\LoginInputFilter;

class IndexLoginInputFilter extends LoginInputFilter {

    public function __construct() {
        parent::__construct();
        
        $this->add(array(
            'name' => 'token',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 256,),),
            ),
        ));
    }

}
