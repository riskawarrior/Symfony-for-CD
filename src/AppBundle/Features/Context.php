<?php

namespace AppBundle\Features;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Behat\Mink\Exception\ElementNotFoundException;

class Context extends MinkContext implements KernelAwareContext {

    use KernelDictionary;

    protected $application;

    /**
     * Runs, the database preparation.
     *
     * @Given A clean database
     */
    public function cleanDatabase() {
        $kernel = $this->getKernel();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
        $this->runConsole("doctrine:database:drop", ["--force" => true]);
        $this->runConsole("doctrine:database:create");
        $this->runConsole("doctrine:schema:create");
        $this->runConsole("doctrine:fixtures:load", ["-n" => true, "--append" => true]);
    }

    /**
     * Find the attribute text in an element
     *
     * @Then I should see in the ":selector" element in the ":attribute" attribute the ":text" text
     */
    public function checkElementAttributeText($selector, $attribute, $text) {
        $this->assertSession()->elementAttributeContains('css', $selector, $attribute, $text);
    }

    /**
     * Request an URL with specified method and parameters
     *
     * @When I request the ":url" url with the ":parameters" parameters
     */
    public function requestUrl($url, $parameters) {
        $parameters = str_replace("'", "\"", $parameters);
        $parameterArray = json_decode($parameters, true);
        $this->getSession()->getDriver()->getClient()->request('POST', $url, $parameterArray);
    }

    /**
     * Clicks link with specified css.
     *
     * @When I follow ":selector" link
     */
    public function clickLinkWithAttribute($selector) {
        $clickElement = $this->assertSession()->elementExists('css', $selector);

        if (null === $clickElement) {
            throw new ElementNotFoundException($this->getSession(), 'link', 'css', $selector);
        }

        $clickElement->click();
    }

    /**
     * Logs in a User with a password. [FOS User]
     *
     * @Given A logged in user ":user" with password ":password"
     */
    public function loginWithUser($user, $password) {
        $this->visitPath('/login');
        $this->fillField('username',$user);
        $this->fillField('password',$password);
        $this->pressButton('_submit');
    }

    private function runConsole($command, array $options = array()) {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, ['command' => $command]);
        return $this->application->run(new ArrayInput($options));
    }

}
