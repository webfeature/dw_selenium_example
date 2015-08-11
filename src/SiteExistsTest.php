<?php

require_once 'config/DenkwerkWebDriver.php';


class SiteExistsTest extends DenkwerkWebDriver
{

    public function  testHomepageSite() {
        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin.',
            $this->webDriver->getTitle());
    }

    public function testDenkwerkSite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-5537"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » denkwerk',
            $this->webDriver->getTitle());
    }

    public function testProjectSite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-12872"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » Projekte',
            $this->webDriver->getTitle());
    }

    public function testCareerSite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-5100"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » Stellen',
            $this->webDriver->getTitle());
    }

    public function testBlogSite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-3133"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » Allgemein',
            $this->webDriver->getTitle());
    }

    public function testTimelineSite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-6273"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » Timeline',
            $this->webDriver->getTitle());
    }

    public function testContactSite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-3026"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » Kontakt',
            $this->webDriver->getTitle());
    }

    public function testDataPrivacySite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-3028"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » Datenschutzerklärung',
            $this->webDriver->getTitle());
    }

    public function testImpressumSite() {
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath('//*[@id="menu-item-3030"]/a'));
        $element->click();

        $this->assertEquals('denkwerk GmbH: Digital-, Online- und Internetagentur in Köln & Berlin. » Impressum',
            $this->webDriver->getTitle());
    }
}