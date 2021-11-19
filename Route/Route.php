<?php
class Route
{    
    /**
     * proccess with specific route
     *
     * @return void
     */
    public function proccessRouting()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // get url
        $uri = explode('/', $uri); //splice uri by '/'
        switch ($uri[1]) {
            case 'user':
                $this->handleRouteUser();
                break;
            case 'image':
                $this->handleRoutePage($uri);
                break;
            default:
                $this->pageNotFoundResponse();
                break;
        }
    }    
    /**
     * handle process with '/user'
     *
     * @return void
     */
    private function handleRouteUser()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $controller = new UserController($requestMethod);
        $controller->processRequest();
    }    
    /**
     * handle process with '/image'
     *
     * @param  array $uri
     * @return void
     */
    private function handleRoutePage($uri)
    {
        $attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/uploaded//" . $uri[2];
        if (file_exists($attachment_location)) {

            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for internet explorer
            header("Content-Type: image/png");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:" . filesize($attachment_location));
            header("Content-Disposition: attachment; filename=" . $uri[2]);
            readfile($attachment_location);
            die();
        } else {
            die("Error: File not found.");
        }
    }
    /**
     * handle page Not Found Response
     *
     * @return void
     */
    private function pageNotFoundResponse()
    {
        header('HTTP/1.1 404 Not Found');
        echo 'Page Not Found';
    }
}
