<?php
/**
 * Test Download an album
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
 * @use Samba\Download
 */
use Samba\Download;

/**
 * Test Download an album
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
class DownloadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Álbuns válidos para baixar
     * 
     * @return array
     */
    public function albuns()
    {
        return array(
            array('arlindo-cruz-batuques-e-romances-2011'),
            array('cartola-verde-que-te-quero-rosa-1977'),
            array('adoniran-barbosa-adoniran-barbosa-e-convidados'),
        );
    }
    
    /**
     * Álbuns válidos para baixar
     * 
     * @return array
     */
    public function tiposInvalidos()
    {
        return array(
            array('arlindo-cruz-batuques-e-romances-2011', 'mp5'),
            array('cartola-verde-que-te-quero-rosa-1977', 'zzz'),
            array('adoniran-barbosa-adoniran-barbosa-e-convidados', 'seilá'),
        );
    }
    
    /**
     * @test
     * @dataProvider albuns
     * @param string $palavra 
     */
    public function baixarAlbum($album)
    {
        $application = new Application;
        $application->add(new Download);

        $command       = $application->find('samba:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'command'   => $command->getName(), 
                'album'     => $album
            )
        );

        $this->assertRegExp('/.+/', $commandTester->getDisplay());
    }
    
    /**
     * @test
     * @dataProvider tiposInvalidos
     * @param string $palavra 
     * @expectedException \InvalidArgumentException
     */
    public function albumComtipoInvalido($album, $tipoInvalido)
    {
        $application = new Application;
        $application->add(new Download);

        $command       = $application->find('samba:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'command'   => $command->getName(), 
                'album'     => $album,
                'destino'   => '/tmp',
                'tipo'      => $tipoInvalido
            )
        );

        $this->assertRegExp('/.+/', $commandTester->getDisplay());
    }
}