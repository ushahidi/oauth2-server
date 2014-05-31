<?php

class Request_test extends PHPUnit_Framework_TestCase
{
    private $request;

    function setUp()
    {
        $this->request = new League\OAuth2\Server\Util\Request(
            array('foo' => 'bar'),
            array('foo' => 'bar'),
            array('foo' => 'bar'),
            array('foo' => 'bar'),
            array('HTTP_HOST' => 'foobar.com')
        );
    }

    function test_buildFromIndex()
    {
        $r = new League\OAuth2\Server\Util\Request();
        $r->buildFromGlobals();

        $this->assertTrue($r instanceof League\OAuth2\Server\Util\Request);
    }

    function test_get()
    {
        $this->assertEquals('bar', $this->request->get('foo'));
        $this->assertEquals(array('foo' => 'bar'), $this->request->get());
    }

    function test_post()
    {
        $this->assertEquals('bar', $this->request->post('foo'));
        $this->assertEquals(array('foo' => 'bar'), $this->request->post());
    }

    function test_file()
    {
        $this->assertEquals('bar', $this->request->file('foo'));
        $this->assertEquals(array('foo' => 'bar'), $this->request->file());
    }

    function test_cookie()
    {
        $this->assertEquals('bar', $this->request->cookie('foo'));
        $this->assertEquals(array('foo' => 'bar'), $this->request->cookie());
    }

    function test_server()
    {
        $this->assertEquals('foobar.com', $this->request->server('HTTP_HOST'));
        $this->assertEquals(array('HTTP_HOST' => 'foobar.com'), $this->request->server());
    }

    function test_header()
    {
        $this->assertEquals('foobar.com', $this->request->header('Host'));
        $this->assertEquals(array('Host' => 'foobar.com'), $this->request->header());
    }

    function test_canonical_header()
    {
        $request = new League\OAuth2\Server\Util\Request(
            array('foo' => 'bar'),
            array('foo' => 'bar'),
            array('foo' => 'bar'),
            array('foo' => 'bar'),
            array('HTTP_HOST' => 'foobar.com'),
            array('authorization' => 'Bearer ajdfkljadslfjasdlkj')
        );

        $this->assertEquals('Bearer ajdfkljadslfjasdlkj', $request->header('Authorization'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    function test_unknownProperty()
    {
        $reflector = new ReflectionClass($this->request);
        $method = $reflector->getMethod('getPropertyValue');
        $method->setAccessible(true);

        $method->invoke($this->request, 'blah');
    }
}
