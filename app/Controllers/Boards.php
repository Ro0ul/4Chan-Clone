<?php declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use \App\Twig\Twig;
use PDO;

class Boards 
{
    private static array $boards = [
        "t",
        "aam",
        "ac",
        "aw",
        "vgg",
        "vg",
        "vgr",
        "vgs",
        "vgrt",
        "cac",
        "taf",
        "w",
        "sam",
        "s"
    ];
    public static function render(string $boardName) : void
    {
        $boardIsFound = false;
        foreach(static::$boards as $board){
            if($boardName == $board){
                $boardIsFound = true;
            }
        }
        $twig = new Twig;
        $db = new PDO("mysql:host=localhost;port=3306;db=web","root","");
        $boards = $db->query("SELECT * FROM web.post WHERE board = '$boardName'");
        if($boardIsFound){
            $body = Request::getBody();
            $error = $body["err"] ?? null;
            if($error){
                $twig->view("boards/index",[
                    "board"=>$boardName,
                    "allBoards"=> static::$boards,
                    "boards"=>$boards,
                    "error"=>true
                ]);
                exit;
            }

            $twig->view("boards/index",[
                "board"=>$boardName,
                "boards"=>$boards,
                "allBoards"=> static::$boards
            ]);
        }else{
            echo "Board Not Found";
        }
    } 
    public static function new() : void 
    {
        $body = Request::getBody();
        $files = Request::getFiles()["file"] ?? null;
        $filePath = null;
        $tmpFile = $files["tmp_name"] ?? null;
        if($files){
            if($tmpFile){
                $imageInfo = getimagesize($tmpFile) ?? null;
                $errors = [];
                if(!$imageInfo || !str_contains($imageInfo["mime"],"image")){
                    $errors["image"] = true;
                }
                if($imageInfo){
                    $imageWidth = $imageInfo[0];
                    $imageHeight = $imageInfo[1];
                    if($imageWidth > 900 || $imageHeight > 700){
                        $errors["image"] = true;
                    }else{
                        $frontEndDirectory = "/assets/images/" . rand(0,1000);
                        $fileDirectory = $_SERVER["DOCUMENT_ROOT"] . $frontEndDirectory;
                        mkdir($fileDirectory,0777,true);
                        $filePath =  $fileDirectory . "/" . $files["name"];
                        if(move_uploaded_file($tmpFile,$filePath)){
                            unset($errors["image"]);
                        }
                        $filePath = $frontEndDirectory . "/" . $files["name"];
                    }
                    
                }
            }
        }
        $username = filter_var($body["name"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $title = filter_var($body["title"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $captcha = filter_var($body["captcha"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $postBody = filter_var($body["body"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if(strlen($username) > 25){
            $errors["username"] = true;
        }
        if(strlen($postBody) > 500){
            $errors["body"] = true;
        }
        if($captcha != "1234"){
            $errors["captcha"] = true;
        }
        if(strlen($title) > 50){
            $errors["title"] = true;
        }
        $board = $body["board"];
        if(!empty($errors)){
            redirect("/boards/$board?err=true");
            exit;
        }
        $db = new PDO("mysql:host=localhost;port=3306;db=web","root","");
        if($db){
            $now = date("Y-m-d H:i:s", time());
            echo $now;
            $query = $db->prepare(
                "INSERT INTO web.post(title,body,posted_at,image_src,board) VALUES(:title,:body,:posted_at,:image_src,:board)"  
            );
            $query->execute([":title"=>$title,":body"=>$postBody,":posted_at"=>$now,":image_src"=>$filePath,":board"=>$board
            ]);
            redirect("/boards/$board");
            exit;
        }else{
            echo "Couldn't Connect To Database";
        }

    }
}