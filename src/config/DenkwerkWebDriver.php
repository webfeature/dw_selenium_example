<?php

use \Facebook\WebDriver as WebDriver;
use \Facebook\WebDriver\Remote as Remote;

require_once 'AllowedParameters.php';
require_once 'LocateElementStrategy.php';


class DenkwerkWebDriver extends PHPUnit_Framework_TestCase {

    protected $webDriver;
    protected $browser = '';
    protected $browserstackUser = '';
    protected $browserstackKey = '';

    /**
     * Setting up browser and load website
     */
    protected function setUp()
    {
        $this->getParams();

        $this->browser = $this->setBrowser($this->browser);

        $capabilities = array(
            Remote\WebDriverCapabilityType::PLATFORM => 'WINDOWS',
            Remote\WebDriverCapabilityType::BROWSER_NAME => $this->browser
        );

        if (empty($this->browserstackUser) === true || empty($this->browserstackKey) === true) {
            $this->webDriver = Remote\RemoteWebDriver::create('http://10.0.8.33:4444/wd/hub', $capabilities);
        } else {
            $this->webDriver = Remote\RemoteWebDriver::create(
                'http://' . $this->browserstackUser . ':' . $this->browserstackKey . '@hub.browserstack.com/wd/hub',
                $capabilities
            );
        }

        $this->webDriver->manage()->window()->maximize();

        $this->webDriver->get('https://www.denkwerk.com/');
    }

    /**
     * Close browser
     */
    protected function tearDown() {
        $this->webDriver->close();
        $this->webDriver->quit();
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

    private function setBrowser($browserKey = '') {

        switch ($browserKey) {
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
                $browser = Remote\WebDriverBrowserType::FIREFOX;
        }

        return $browser;
    }

    /**
     * Get all allowed params
     * -b browser
     * -k browserstack key
     * -u browserstack user
     */
    private function getParams() {
        // get browser param
        $this->getParamIntoVariable(AllowedParameters::PARAM_BROWSER, $this->browser);

        // get browserstack user param
        $this->getParamIntoVariable(AllowedParameters::PARAM_BROWSERSTACK_USER, $this->browserstackUser);

        // get browserstack key param
        $this->getParamIntoVariable(AllowedParameters::PARAM_BROWSERSTACK_KEY, $this->browserstackKey);
    }

    /**
     * Check for certain parameter passed into $argv and save into certain variable
     *
     * @param $param
     * @param $intoVariable
     */
    private function getParamIntoVariable($param, &$intoVariable) {
        global $argv;

        $key = array_search($param, $argv);
        if ($key !== false) {
            if (array_key_exists($key + 1, $argv) === true && substr($argv[$key + 1], 0, 1) !== '-') {
                $intoVariable = $argv[$key + 1];
            } else {
                echo 'Error: Value of parameter ' . $param . ' is not valid.';
                exit(1);
            }
        }
    }
}