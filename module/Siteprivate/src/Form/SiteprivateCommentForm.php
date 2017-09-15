<?php
namespace Siteprivate\Form;

use Sitepublic\Form\SitepublicCommentForm;

class SiteprivateCommentForm extends SitepublicCommentForm {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('commentform');
    }

}
