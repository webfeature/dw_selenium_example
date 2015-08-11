<?php

require_once 'config/DenkwerkWebDriver.php';


class ContactTest extends DenkwerkWebDriver
{
    protected function setUp() {
        parent::setUp();

        $this->webDriver->get('https://www.denkwerk.com/de/kontakt/');
    }

    public function testSendEmptyForm() {
        $xpath = '//*[@id="wpcf7-f3257-o2"]/form/div[4]/input';
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath($xpath));
        $element->click();

        $element = $this->waitForElementDisplayed('//*[@id="wpcf7-f3257-o2"]/form/div[5]');
        $this->assertEquals("Fehler beim Ausfüllen des Formulars! Bitte überprüfen Sie Ihre Eingaben und klicken Sie nochmals auf 'Senden'.", $element->getText());

    }

    public function testFillFormComplete() {
        // gender male
        $xpath = '//*[@id="orange-anker"]';
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath($xpath));
        $element->click();
        $xpath = '//*[@id="anrede"]/span[1]/label/span';
        $element = $this->waitForElementDisplayed($xpath);
        $element->click();

        // reason application
        $xpath = '//*[@id="green-anker"]';
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath($xpath));
        $element->click();
        $xpath = '//*[@id="thema"]/span[3]/label/span';
        $element = $this->waitForElementDisplayed($xpath);
        $element->click();

        // firstname
        $xpath = '//*[@id="wpcf7-f3257-o2"]/form/div[3]/span[1]/input';
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath($xpath));
        $element->sendKeys('Max');

        // lastname
        $xpath = '//*[@id="wpcf7-f3257-o2"]/form/div[3]/span[2]/input';
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath($xpath));
        $element->sendKeys('Mustermann');

        // e-mail
        $xpath = '//*[@id="wpcf7-f3257-o2"]/form/div[3]/span[3]/input';
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath($xpath));
        $element->sendKeys('test@example.com');

        // message
        $xpath = '//*[@id="wpcf7-f3257-o2"]/form/div[4]/span/textarea';
        $element = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::xpath($xpath));
        $element->sendKeys('My job application');
    }

}