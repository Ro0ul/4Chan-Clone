<?php declare(strict_types=1);

namespace App\Twig;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
class Twig
{
    private const defaultViewPath = ROOT . "/views";

    private array $acceptedFileExs = [
        ".twig",
        ".html",
        ".php"
    ];
    private ?Environment $twig = null; 
    public function __construct(?string $path = null, array $config = [])
    {
        $path = $path == null ? self::defaultViewPath : $path;
        $loader = new FilesystemLoader($path);
        $this->twig = new Environment($loader,$config);
    }
    public function view(string $fileName, array $context = []) : void 
    {
        $fileExtensionSpecified = false;
        foreach($this->acceptedFileExs as $fileExtansion){
            if(str_contains($fileName, $fileExtansion)){
                $fileExtensionSpecified = true;
                echo $this->twig->render($fileName,$context);
                break;
            }
        }
        if(!$fileExtensionSpecified){
            foreach($this->acceptedFileExs as $fileExtansion){
                if(file_exists(self::defaultViewPath . "/$fileName$fileExtansion")){
                    echo $this->twig->render("$fileName$fileExtansion", $context);
                    break;
                }
            }
        }
    }
}