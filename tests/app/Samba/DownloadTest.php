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
    public function albumValido()
    {
        return array(
            array('arlindo-cruz-batuques-e-romances-2011'),
        );
    }
    
    /**
     * Álbuns válidos para baixar
     * 
     * @return array
     */
    public function albumValidoTipoInvalido()
    {
        return array(
            array('arlindo-cruz-batuques-e-romances-2011', 'mp5'),
        );
    }
    
    /**
     * Álbuns válidos para baixar
     * 
     * @return array
     */
    public function albumValidoTipoDestino()
    {
        return array(
            array(
                'arlindo-cruz-batuques-e-romances-2011', 
                'mp3', 
                sys_get_temp_dir()
            ),
        );
    }
    
    /**
     * @test
     * @dataProvider albumValido
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
     * @dataProvider albumValidoTipoInvalido
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
    
    /**
     * @test
     * @dataProvider albumValidoTipoDestino
     * @param string $album
     * @param string $tipo
     * @param string $destino
     */
    public function verificaCriacaoDiretorioDestino($album, $tipo, $destino)
    {
        $application = new Application;
        $application->add(new Download);

        $command       = $application->find('samba:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'command'   => $command->getName(), 
                'album'     => $album,
                'destino'   => $destino,
                'tipo'      => $tipo
            )
        );

        $this->assertRegExp('/.+/', $commandTester->getDisplay());
        $this->assertTrue(is_dir($destino . DIRECTORY_SEPARATOR . $album));
    }
}