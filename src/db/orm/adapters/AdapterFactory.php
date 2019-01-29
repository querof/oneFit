<?php

namespace src\db\orm\adapters;

use src\db\orm\adapters\MySqlAdapter;

/*
 * An implementation of the factory pattern; to create the Dabase Adapter objects.
 */

class AdapterFactory
{

  /**
   * Method thats create the Adapters objects.
   */

    public function create()
    {
        $params = json_decode(file_get_contents(__DIR__.'/../../../../conf/database.json'), true);

        switch ($params['provider']) {
          case 'mysql':
            return new MySqlAdapter();
            break;
        }
    }
}
