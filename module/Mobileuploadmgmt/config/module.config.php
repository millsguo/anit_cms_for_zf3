<?php
namespace Mobileuploadmgmt;

use Zend\Router\Http\Segment;

return array(
    'controllers' => array(
        'factories' => array(
            Controller\MobileuploadmgmtController::class => MobileuploadmgmtControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Mobileuploadmgmt' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/uploadmgmt[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => Controller\MobileuploadmgmtController::class,
                        'action' => 'index'),
                //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Mobileuploadmgmt' => __DIR__ . '/../view',
		),
    ),
);
