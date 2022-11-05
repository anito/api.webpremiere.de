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

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
  /**
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

  $routes->scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware());
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
    $routes->connect('/pages/*', 'Pages::display');

    $routes->prefix('v1', function (RouteBuilder $builder) {
      // Only controllers explicitly enabled for API use will be accessible through API
      $builder->setExtensions(['json']);

      $builder->resources('Todos');
      $builder->resources('Users');

      $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
      $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

      $builder->fallbacks(DashedRoute::class);
    });

    /**
     * Connect catchall routes for all controllers.
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/{controller}', ['action' => 'index']);
     * $routes->connect('/{controller}/{action}/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
  });

  /**
   * If you need a different set of middleware or none at all,
   * open new scope and define routes there.
   *
   * ```
   * $routes->scope('/api', function (RouteBuilder $routes) {
   *     // No $routes->applyMiddleware() here.
   *
   *     // Parse specified extensions from URLs
   *     // $routes->setExtensions(['json', 'xml']);
   *
   *     // Connect API actions here.
   * });
   * ```
   */
};
