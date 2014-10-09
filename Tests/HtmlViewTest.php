<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-08
 * Time: 00:35
 */

namespace Tests;

require_once ("./ImportFiles.php");

use view\HtmlView;

class HtmlViewTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException \Exception
     */
    public function testExceptionForNullBody(){
        $htmlView = new HtmlView();
        $body = null;
        $htmlView->echoHTML($body);
    }

}
 