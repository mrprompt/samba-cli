<?php
/**
 * Search album
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
 * @use Samba\Busca
 */
use Samba\Busca;

/**
 * Search album
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
class BuscaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Palavras chaves utilizadas na busca
     * 
     * @return array
     */
    public function palavras()
    {
        return array(
            array('cartola'),
            array('Fundo de Quintal'),
            array('Almir Guineto'),
            array('Zeca Pagodinho'),
        );
    }
    
    /**
     * @test
     * @dataProvider palavras
     * @param string $palavra 
     */
    public function buscaPorAlgo($palavra)
    {
        $application = new Application;
        $application->add(new Busca);

        $command       = $application->find('samba:busca');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'command'       => $command->getName(), 
                'palavra-chave' => $palavra
            )
        );

        $this->assertRegExp('/.+/', $commandTester->getDisplay());
    }
}