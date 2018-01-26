<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBiosTest\Theme\Controller;

use MSBios\Theme\Controller\IndexController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class IndexControllerTest
 * @package MSBiosTest\Theme\Controller
 */
class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('msbios');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

    public function testIndexActionViewModelTemplateRenderedWithinLayout()
    {
        $this->dispatch('/', 'GET');
        $this->assertQuery('.container .jumbotron');
    }

    public function testBlogActionCanBeAccessed()
    {
        $this->dispatch('/blog', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('msbios');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home/blog');
    }

    public function testBlogActionViewModelTemplateRenderedWithinLayout()
    {
        $this->dispatch('/blog', 'GET');
        $this->assertQuery('.h2');
    }

    public function testViewActionCanBeAccessed()
    {
        $this->dispatch('/blog/1-some-slug.html', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('msbios');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home/blog/view');
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
