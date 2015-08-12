<?php

use \Facebook\WebDriver as WebDriver;
use \Facebook\WebDriver\Remote as Remote;

require_once 'LocateElementStrategy.php';


class DenkwerkWebDriver extends PHPUnit_Framework_TestCase {

    /**
     * @var Remote\RemoteWebDriver
     */
    protected $webDriver;

    /**
     *
     */
    public static function setUpBeforeClass() {
        /*$files = glob('log/*');
        foreach($files as $file) {
            if (is_file($file) === true) {
                unlink($file);
            }
        }*/
    }

    /**
     * Setting up browser and load website
     */
    protected function setUp()
    {
        global $argv;

        //$browser = $this->setBrowserByParam($argv);
        $browser = Remote\WebDriverBrowserType::FIREFOX;

        $capabilities = array(
            Remote\WebDriverCapabilityType::BROWSER_NAME => $browser
        );

        $this->webDriver = Remote\RemoteWebDriver::create('http://10.0.8.33:4444/wd/hub', $capabilities);

        $this->webDriver->manage()->window()->maximize();

        $this->webDriver->get('https://www.denkwerk.com/');
    }

    /**
     * Close browser
     */
    protected function tearDown() {
        // with quit the test is failing https://github.com/Codeception/Codeception/issues/518
        $this->webDriver->close();
    }

    /**
     * Take a screenshot, when a test fails
     *
     * @param Exception $e
     * @throws Exception
     */
    protected function onNotSuccessfulTest(Exception $e)
    {
        $this->webDriver->takeScreenshot('log/' .  time() . 'result.png');

        parent::onNotSuccessfulTest($e);
    }

    /**
     * Wait for an element displayed
     *
     * @param $locator
     * @param string $strategy
     * @param int $timeout
     * @return Remote\RemoteWebElement
     * @throws Exception
     * @throws WebDriver\Exception\NoSuchElementException
     * @throws WebDriver\Exception\TimeOutException
     * @throws null
     */
    protected function waitForElementDisplayed($locator, $strategy = LocateElementStrategy::STRATEGY_XPATH, $timeout
= 30)
    {
        $this->webDriver->wait($timeout)->until(
            WebDriver\WebDriverExpectedCondition::visibilityOfElementLocated($this->locateElement($locator, $strategy))
        );

        return $this->webDriver->findElement($this->locateElement($locator, $strategy));
    }

    /**
     * Locate element by strategy
     *
     * @param $locator
     * @param string $strategy
     * @return WebDriver\WebDriverBy
     */
    protected  function locateElement($locator, $strategy = LocateElementStrategy::STRATEGY_XPATH)
    {
        switch ($strategy) {
            case LocateElementStrategy::STRATEGY_CLASS_NAME:
                return WebDriver\WebDriverBy::className($locator);
            case LocateElementStrategy::STRATEGY_CSS_SELECTOR:
                return WebDriver\WebDriverBy::cssSelector($locator);
            case LocateElementStrategy::STRATEGY_ID:
                return WebDriver\WebDriverBy::id($locator);
            case LocateElementStrategy::STRATEGY_LINK_TEXT:
                return WebDriver\WebDriverBy::linkText($locator);
            case LocateElementStrategy::STRATEGY_PARTIAL_LINK_TEXT:
                return WebDriver\WebDriverBy::partialLinkText($locator);
            case LocateElementStrategy::STRATEGY_NAME:
                return WebDriver\WebDriverBy::name($locator);
            case LocateElementStrategy::STRATEGY_TAG:
                return WebDriver\WebDriverBy::tag($locator);
            case LocateElementStrategy::STRATEGY_XPATH:
                return WebDriver\WebDriverBy::xpath($locator);
        }
    }

    private function setBrowserByParam($argv) {

        // Default browser
        $browser = Remote\WebDriverBrowserType::FIREFOX;

        // Check if browser is set as param
        if(isset($argv[2]) === true) {
            switch ($argv[2]) {
                case Remote\WebDriverBrowserType::IE:
                    $browser = Remote\WebDriverBrowserType::IE;
                    break;
                case Remote\WebDriverBrowserType::CHROME:
                    $browser = Remote\WebDriverBrowserType::CHROME;
                    break;
                case Remote\WebDriverBrowserType::SAFARI:
                    $browser = Remote\WebDriverBrowserType::SAFARI;
                    break;
                default:
                    echo 'Error: Parameter is not a browser';
                    exit(1);
            }
        }

        return $browser;
    }
}