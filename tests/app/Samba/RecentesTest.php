<?php
/**
 * Test retrieving recenes albuns list
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
namespace Samba;

/**
 * @use Symfony\Component\Console\Application
 */
use Symfony\Component\Console\Application;

/**
 * @use Symfony\Component\Console\Tester\CommandTester
 */
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @use Samba\Recentes
 */
use Samba\Recentes;

/**
 * Test retrieving recenes albuns list
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
class RecentesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function listaRecentes()
    {
        $application = new Application;
        $application->add(new Recentes);

        $command       = $application->find('samba:recentes');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/^([[:alnum:]]).+/', $commandTester->getDisplay());
    }
}