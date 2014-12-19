<?php

class ExampleAssertsCode extends Zend_Test_PHPUnit_ControllerTestCase {

    public function testPHPUNitAsserts(){
        
        $key = '';
        $array = '';
        $attributeName = '';
        $className = '';
        $needle = '';
        $haystack = '';
        $haystackAttributeName = '';
        $haystackClassOrObject = '';
        $type = '';
        $actual = '';
        $actualAttributeName = '';
        $actualClassOrObject = '';
        $expected = '';
        $condition = '';
        $filename = '';
        $classOrObject = '';
        $object = '';
        $pattern = '';
        $string = '';
        $format = '';
        $formatFile = '';
        $selector = '';
        $count = '';
        $content = '';
        $suffix = '';
        $expectedFile = '';
        $actualString = '';
        $prefix = '';
        $matcher = '';
        $value = '';
        $constraint = '';
        $actualFile = '';
        $actualXml = '';
        $expectedXml = '';
        
        $this->assertArrayHasKey($key, $array);
        $this->assertArrayNotHasKey($key, $array);
        
        $this->assertClassHasAttribute($attributeName, $className);
        $this->assertClassNotHasAttribute($attributeName, $className);
        
        $this->assertClassHasStaticAttribute($attributeName, $className);
        $this->assertClassNotHasStaticAttribute($attributeName, $className);
        
        $this->assertContains($needle, $haystack);
        $this->assertNotContains($needle, $haystack);
        $this->assertAttributeContains($needle, $haystackAttributeName, $haystackClassOrObject);
        $this->assertAttributeNotContains($needle, $haystackAttributeName, $haystackClassOrObject);
        
        $this->assertContainsOnly($type, $haystack);
        $this->assertNotContainsOnly($type, $haystack);
        $this->assertAttributeContainsOnly($type, $haystackAttributeName, $haystackClassOrObject);
        $this->assertAttributeNotContainsOnly($type, $haystackAttributeName, $haystackClassOrObject);
        
        $this->assertCount($needle, $haystack); // ab Version 3.7
        $this->assertNotCount($needle, $haystack); // ab Version 3.7
        
        $this->assertEmpty($actual);
        $this->assertNotEmpty($actual);
        $this->assertAttributeEmpty($haystackAttributeName, $haystackClassOrObject);
        $this->assertAttributeNotEmpty($haystackAttributeName, $haystackClassOrObject);
        
        $this->assertEqualXMLStructure(); // ab Version 3.7
        $this->assertNotEqualXMLStructure(); // ab Version 3.7
        
        $this->assertEquals($expected, $actual);
        $this->assertNotEquals($expected, $actual);
        $this->assertAttributeEquals($expected, $actualAttributeName, $actualClassOrObject);
        $this->assertAttributeNotEquals($expected, $actualAttributeName, $actualClassOrObject);
        
        $this->assertFalse($condition);
        
        $this->assertFileEquals($expected, $actual);
        $this->assertFileNotEquals($expected, $actual);
        
        $this->assertFileExists($filename);
        $this->assertFileNotExists($filename);
        
        $this->assertGreaterThan($expected, $actual);
        $this->assertAttributeGreaterThan($expected, $actualAttributeName, $actualClassOrObject);
        
        $this->assertGreaterThanOrEqual($expected, $actual);
        $this->assertAttributeGreaterThanOrEqual($expected, $actualAttributeName, 
                $actualClassOrObject);
        
        $this->assertInstanceOf($expected, $actual);
        $this->assertNotInstanceOf($expected, $actual);
        $this->assertAttributeInstanceOf($expected, $attributeName, $classOrObject);
        $this->assertAttributeNotInstanceOf($expected, $attributeName, $classOrObject);
        
        $this->assertInternalType($expected, $actual);
        $this->assertNotInternalType($expected, $actual);
        $this->assertAttributeInternalType($expected, $attributeName, $classOrObject);
        $this->assertAttributeNotInternalType($expected, $attributeName, $classOrObject);
        
        $this->assertLessThan($expected, $actual);
        $this->assertAttributeLessThan($expected, $actualAttributeName, $actualClassOrObject);
        
        $this->assertLessThanOrEqual($expected, $actual);
        $this->assertAttributeLessThanOrEqual($expected, $actualAttributeName, $actualClassOrObject);
        
        $this->assertNull($actual);
        $this->assertNotNull($actual);
        
        $this->assertObjectHasAttribute($attributeName, $object);
        $this->assertObjectNotHasAttribute($attributeName, $object);
        
        $this->assertRegExp($pattern, $string);
        $this->assertNotRegExp($pattern, $string);
        
        $this->assertStringMatchesFormat($format, $string);
        $this->assertStringNotMatchesFormat($format, $string);
        
        $this->assertStringMatchesFormatFile($formatFile, $string);
        $this->assertStringNotMatchesFormatFile($formatFile, $string);
        
        $this->assertSame($expected, $actual);
        $this->assertNotSame($expected, $actual);
        $this->assertAttributeSame($expected, $actualAttributeName, $actualClassOrObject);
        $this->assertAttributeNotSame($expected, $actualAttributeName, $actualClassOrObject);
        
        $this->assertSelectCount($selector, $count, $actual);
        $this->assertSelectEquals($selector, $content, $count, $actual);
        $this->assertSelectRegExp($selector, $pattern, $count, $actual);
        
        $this->assertStringEndsWith($suffix, $string);
        $this->assertStringEndsNotWith($suffix, $string);
        
        $this->assertStringEqualsFile($expectedFile, $actualString);
        $this->assertStringNotEqualsFile($expectedFile, $actualString);
        
        $this->assertStringStartsWith($prefix, $string);
        $this->assertStringStartsNotWith($prefix, $string);
        
        $this->assertTag($matcher, $actual);
        $this->assertNotTag($matcher, $actual);
        
        $this->assertThat($value, $constraint);
        
        $this->assertTrue($condition);
        
        $this->assertAttributeType($expected, $attributeName, $classOrObject);
        $this->assertAttributeNotType($expected, $attributeName, $classOrObject);
        
        $this->assertXmlFileEqualsXmlFile($expectedFile, $actualFile);
        $this->assertXmlFileNotEqualsXmlFile($expectedFile, $actualFile);
        
        $this->assertXmlStringEqualsXmlFile($expectedFile, $actualXml);
        $this->assertXmlStringNotEqualsXmlFile($expectedFile, $actualXml);
        
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);
        $this->assertXmlStringNotEqualsXmlString($expectedXml, $actualXml);
    }

    public function testZendPHPUnitAsserts(){
        
        $path = '';
        $match = '';
        $pattern = '';
        $count = '';
        $url = '';
        $coder = '';
        $header = '';
        $code = '';
        $module = '';
        $controller = '';
        $action = '';
        $route = '';
        
        
        // CSS Selektoren
        $this->assertQuery($path);
        $this->assertNotQuery($path);
        
        $this->assertQueryContentContains($path, $match);
        $this->assertNotQueryContentContains($path, $match);
        
        $this->assertQueryContentRegex($path, $pattern);
        $this->assertNotQueryContentRegex($path, $pattern);
        
        $this->assertQueryCount($path, $count);
        $this->assertNotQueryCount($path, $count);
        
        $this->assertQueryCountMin($path, $count);
        $this->assertQueryCountMax($path, $count);
        
        // xpath zusicherungen fehlen noch / sind alternativ ezu CSS Selektoren
        
        // Umleitungszusicherungen
        
        $this->assertRedirect();
        $this->assertNotRedirect();
        
        $this->assertRedirectTo($url);
        $this->assertNotRedirectTo($url);
        
        $this->assertRedirectRegex($pattern);
        $this->assertNotRedirectRegex($pattern);
        
        // Antwort-Header-Zusicherungen
        
        $this->assertResponseCode($code);
        $this->assertNotResponseCode($code);
        
        $this->assertHeader($header);
        $this->assertNotHeader($header);
        
        $this->assertHeaderContains($header, $match);
        $this->assertNotHeaderContains($header, $match);
        
        $this->assertHeaderRegex($header, $pattern);
        $this->assertNotHeaderRegex($header, $pattern);
        
        // Anfragezusicherungen
        
        $this->assertModule($module);
        $this->assertNotModule($module);
        
        $this->assertController($controller);
        $this->assertNotController($controller);
        
        $this->assertAction($action);
        $this->assertNotAction($action);
        
        $this->assertRoute($route);
        $this->assertNotRoute($route);
    
    }

}