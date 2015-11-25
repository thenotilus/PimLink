<?php


/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:22
 */

namespace Notilus\PimLinkBundle\Map;


use Monolog\Logger;
use Notilus\PimLinkBundle\Helper\CsvHelper;

class WekaMap extends ADestinationMap
{

    private $_csvhelper;
    private $_logger;

    function __construct() {
        parent::__construct("weka");

        $this->_csvhelper = new CsvHelper();
        $this->_logger = new Logger("WEKA");
        $this->_logger->info("Instantiate class");
    }

    public function setDataSource($data)
    {
        // TODO: Implement setDataSource() method.
    }

    public function updateSource($new_data)
    {
        // TODO: Implement updateSource() method.
        return null;
    }
}