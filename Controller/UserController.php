<?php

/**
 * UserController
 */
class UserController
{
    private $requestMethod;
    private $user = null;

    /**
     * __construct
     *
     * @param  mixed $requestMethod (GET, POST, PUT, UPDATE)
     * @param  mixed $userId id of user
     * @param  mixed $userPhone phone of user
     * @return void
     */
    public function __construct($requestMethod, $userId = null, $userPhone = null)
    {
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->userPhone = $userPhone;
        $this->user = new User();
    }

    /**
     * processRequest
     *
     * @return mixed $response
     */
    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getUser();
                break;
            case 'POST':
                $response = $this->createUser();
                break;
            case 'PUT':
                $response = $this->updateUser();
                break;
            case 'DELETE':
                $response = $this->deleteUser();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    /**
     * get user by $_PUT['id'])
     *
     * @return bool
     */
    private function updateUser()
    {
        // TODO create function update user
        // return true | false;
    }

    /**
     * get user by $_DELETE['id'])
     *
     * @return bool
     */
    private function deleteUser()
    {
        // TODO create function delete user
        // return true | false;
    }

    /**
     * get user by $_GET['name']) and $_GET['phone']
     *
     * @return mixed
     */
    private function getUser()
    {

        $name = (isset($_GET['name']) && $_GET['name']) ? $_GET['name'] : '';
        $phone = (isset($_GET['phone']) && $_GET['phone']) ? $_GET['phone'] : '';
        $result = $this->user->getInfo($name, $phone);
        if ($result['error'] == 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $result['result'];
            return $response;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = [];
            return $response;
        }
    }


    /**
     * create new user by $_POST
     *
     * @return mixed
     */
    private function createUser()
    {
        if (!$this->validatePerson()) {
            return $this->unprocessableEntityResponse();
        }
        $file_name = $this->storeFile();
        if ($file_name === false) {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = 'upload file failed';
            return $response;
        }
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $avatar = $file_name;

        $result = $this->user->create($name, $phone, $avatar);
        if ($result) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = 'success';
            return $response;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = 'failed';
            return $response;
        }
    }

    /**
     * validate for createUser() function
     *
     * @return bool
     */
    private function validatePerson()
    {
        if (!isset($_POST['name'])) {
            error_log('No name');
            return false;
        }
        if (!isset($_POST['phone'])) {
            error_log('No phone');
            return false;
        }
        if (!isset($_FILES['avatar']['name'])) {
            error_log('No file');
            return false;
        }
        return true;
    }

    /**
     * store avatar in /uploaded
     *
     * @return bool
     */
    private function storeFile()
    {
        try {
            $fileName  =  $_FILES['avatar']['name'];
            $tempPath  =  $_FILES['avatar']['tmp_name'];
            $fileSize  =  $_FILES['avatar']['size'];
            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '\uploaded/'; // set upload folder path 
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // get image extension
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
            // allow valid image file formats
            if (in_array($fileExt, $valid_extensions)) {
                $newFileName = date("Y-m-d-h-i") . '-num-' . rand(1, 999) . '.' . $fileExt; // create new file name
                //check file not exist our upload folder path
                if (!file_exists($upload_path . $newFileName)) {
                    if ($fileSize < 5000000) {
                        $result = move_uploaded_file($tempPath, $upload_path . $newFileName); // move file from system temporary path to our upload folder path 
                        if ($result) {
                            return $newFileName;
                        } else {
                            return false;
                        }
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            error_log(json_encode($th));
            return false;
        }
    }

    /**
     * return unprocessable Entity Response
     *
     * @return mixed
     */
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    /**
     * return not Found Response
     *
     * @return mixed
     */
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
