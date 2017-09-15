<?php
namespace Siteprivate\Form;

use Sitepublic\Form\SitepublicContactForm;

class SiteprivateContactForm extends SitepublicContactForm {
    
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('contactform');
    }
}
