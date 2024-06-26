<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'home']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        //$builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    $routes->prefix('Student', ['_namePrefix' => 'student:'], function (RouteBuilder $builder) {
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index', 'plugin' => false], ['_name' => 'home']);

        $builder->connect('/register', ['controller' => 'Register', 'action' => 'edit', 'plugin' => false], ['_name' => 'register']);

        $builder->connect('/tracking', ['controller' => 'Tracking', 'action' => 'index', 'plugin' => false], ['_name' => 'tracking']);
        $builder->connect('/tracking/add/*', ['controller' => 'Tracking', 'action' => 'add', 'plugin' => false], ['_name' => 'tracking:add']);
        $builder->connect('/tracking/delete/*', ['controller' => 'Tracking', 'action' => 'delete', 'plugin' => false], ['_name' => 'tracking:delete']);
        $builder->connect('/tracking/validate/*', ['controller' => 'Tracking', 'action' => 'validate', 'plugin' => false], ['_name' => 'tracking:validate']);
        $builder->connect('/tracking/close/*', ['controller' => 'Adscriptions', 'action' => 'close', 'plugin' => false], ['_name' => 'tracking:close']);

        $builder->fallbacks(DashedRoute::class);
    });


    $routes->prefix('Admin', ['_namePrefix' => 'admin:'], function (RouteBuilder $builder) {
        $builder->connect('/', ['controller' => 'Reports', 'action' => 'dashboard', 'plugin' => false], ['_name' => 'home']);
        $builder->connect('/students', ['controller' => 'Students', 'action' => 'index', 'plugin' => false], ['_name' => 'student:index']);
        $builder->connect('/student/view/*', ['controller' => 'Students', 'action' => 'view', 'plugin' => false], ['_name' => 'student:view']);

        $builder->connect('/student/adscriptions/*', ['controller' => 'Students', 'action' => 'adscriptions', 'plugin' => false], ['_name' => 'student:adscriptions']);
        $builder->connect('/student/prints/*', ['controller' => 'Students', 'action' => 'prints', 'plugin' => false], ['_name' => 'student:prints']);

        $builder->connect('/student/tracking/*', ['controller' => 'Students', 'action' => 'tracking', 'plugin' => false], ['_name' => 'student:tracking']);

        $builder->prefix('Stage', ['_namePrefix' => 'stage:'], function (RouteBuilder $builder) {

            $builder->connect('/tracking/add/*', ['controller' => 'Tracking', 'action' => 'add', 'plugin' => false], ['_name' => 'tracking:add']);
            $builder->connect('/tracking/delete/*', ['controller' => 'Tracking', 'action' => 'delete', 'plugin' => false], ['_name' => 'tracking:delete']);
            $builder->connect('/tracking/validate/*', ['controller' => 'Tracking', 'action' => 'validate', 'plugin' => false], ['_name' => 'tracking:validate']);

            $builder->connect('/adscription/change-status/*', ['controller' => 'Adscriptions', 'action' => 'changeStatus', 'plugin' => false], ['_name' => 'adscription:changeStatus']);

            $builder->fallbacks(DashedRoute::class);
        });

        $builder->fallbacks(DashedRoute::class);
    });

    $routes->plugin('Manager', ['path' => '/manager', '_namePrefix' => 'manager:'], function (RouteBuilder $builder) {
        // Add custom routes here

        $builder->connect('/', ['controller' => 'Areas', 'action' => 'index'], ['_name' => 'home']);

        $builder->fallbacks(DashedRoute::class);
    });

    $routes->scope('/uploads', function ($routes) {
        $routes->registerMiddleware('glide', new \ADmad\Glide\Middleware\GlideMiddleware([
            'path' => null,

            'server' => [
                'source' => ROOT . DS . 'files',
                'cache' => ROOT . DS . 'tmp' . DS . 'cache' . DS . 'glide',
                'base_url' => '/uploads/',
                'response' => null,
            ],
            'security' => [
                'secureUrls' => false,
                'signKey' => null,
            ],
            'cacheTime' => '+1 days',
            'allowedParams' => null
        ]));

        $routes->applyMiddleware('glide');

        $routes->connect('/*');
    });
};
