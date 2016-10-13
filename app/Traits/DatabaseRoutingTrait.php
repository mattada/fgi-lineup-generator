<?php
/**
 * Created by PhpStorm.
 * User: daltongibbs
 * Date: 4/18/16
 * Time: 10:45 PM
 */

namespace App\Traits;

use \Illuminate\Support\Facades\Config;

trait DatabaseRoutingTrait {

    /**
     * Sets the default database connection to be used
     *
     * @param $connection
     */
    public function setDatabaseConnection( $connection ) {

        Config::set('database.default', $connection);

    }

}