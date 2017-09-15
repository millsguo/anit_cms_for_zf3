<?php

namespace Siteprivate\Form;

use Login\Form\LoginForm;

//use Zend\Captcha\Image as CaptchaImage;
//use Zend\Stdlib\Hydrator\ClassMethods;

class IndexLoginForm extends LoginForm {
    
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('login');
        
        $this->add(array(
            'name' => 'token',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'tokenId'
            ),
        ));
    }

}
