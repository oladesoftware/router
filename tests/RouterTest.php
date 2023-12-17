<?php
use Oladesoftware\Router\Router;
use PHPUnit\Framework\TestCase;
class RouterTest extends TestCase
{
    private Router $router;

    /*
     * @before
     * */
    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }

    public function testAddRoute()
    {
        $result = $this->router->addRoute("GET", "/test", function (){
            return "Test";
        });
        $this->assertInstanceOf(Router::class, $result);
    }

    public function testAddRouteWithMiddleware()
    {
        $result = $this->router
            ->addRoute("GET", "/test", function (){
                return "Test";
            })->middleware("authenticated");
        $this->assertInstanceOf(Router::class, $result);
    }

    public function testRouteMatched()
    {
        $this->router->addRoute("GET", "/test", function (){
            return "It works!";
        });
        $result = $this->router->match("/test", "GET");
        $this->assertIsArray($result, "The router match result should be an array.");
    }

    public function testRouteNotMatched()
    {
        $result = $this->router->match("/this-route-doesnot-exist", "GET");
        $this->assertIsBool($result, "The router match result should be an boolean.");
    }

    public function testRunCallback()
    {
        $this->router->addRoute("GET", "/test", function (){
            return "It works!";
        });
        $result = $this->router->match("/test", "GET");
        $this->assertEquals("It works!", $this->router->run($result));
    }

    public function testRunCallbackWithMiddleware()
    {
        $this->router->addRoute("GET", "/test", function (){
            return "It works!";
        })->middleware("authentificated");
        $result = $this->router->match("/test", "GET");
        $this->assertArrayHasKey("middleware", $result);
        $this->assertEquals("It works!", $this->router->run($result));
    }
}