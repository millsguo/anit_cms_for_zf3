<?php
namespace Pushnotif;

use Pushnotif\Controller\PushnotifController;
use Pushnotif\Controller\PushnotifControllerFactory;
use Zend\Router\Http\Segment;

return array(
    'controllers' => array(
        'factories' => array(
            PushnotifController::class => PushnotifControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Pushnotif' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/pushnotif[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => PushnotifController::class,
                        'action' => 'index'),
                //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Pushnotif' => __DIR__ . '/../view',),
    ),
);
