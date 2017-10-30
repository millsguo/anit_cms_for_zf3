<?php
namespace Device;

use Device\Controller\DeviceController;
use Device\Controller\DeviceControllerFactory;
use Zend\Router\Http\Segment;

return array(
    'controllers' => array(
        'invokables' => array(
            Controller\DeviceController::class => DeviceControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Device' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/device[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => DeviceController::class,
                        'action' => 'registerprod'),
                //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Device' => __DIR__ . '/../view',),
    ),
);
