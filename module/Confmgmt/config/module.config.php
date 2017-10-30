<?php
namespace Confmgmt;
// module/Album/config/module.config.php:
use Confmgmt\Controller\ConfmgmtController;
use ConfmgmtController\Controller\ConfmgmtControllerFactory;
use Zend\Router\Http\Segment;

return array(
    'controllers' => array(
        'factories' => array(
            ConfmgmtController::class => ConfmgmtControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Confmgmt' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/confmgmt[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => ConfmgmtController::class,
                        'action' => 'index'),
                //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Confmgmt' => __DIR__ . '/../view',),
    ),
);
