<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Pagination\Paginator;

class ApiController extends Controller
{
     /**
     * @var int Status Code.
     */
    protected $statusCode = 200;
    /**
     * Getter method to return stored status code.
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    /**
     * Setter method to set status code.
     * It is returning current object
     * for chaining purposes.
     *
     * @param mixed $statusCode
     * @return current object.
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    /**
     * Function to return an unauthorized response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorizedError($message = 'Unauthorized!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }
    /**
     * Function to return forbidden error response.
     * @param string $message
     * @return mixed
     */
    public function respondForbiddenError($message = 'Forbidden!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }
    /**
     * Function to return a Not Found response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }
    /**
     * Function to return an internal error response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }
    /**
     * Function to return a service unavailable response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondServiceUnavailable($message = "Service Unavailable!")
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_SERVICE_UNAVAILABLE)->respondWithError($message);
    }
    /**
     * Function to return a generic response.
     *
     * @param $data Data to be used in response.
     * @param array $headers Headers to b used in response.
     * @return mixed Return the response.
     */
    public function respond($data, $headers = [])
    {
    
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function respondData($data, $headers = [])
    {
        
        return $this->respond(['status' => true,'data' => $data],$headers);
    }

    public function respondSuccessDataMessage($data,$message="", $headers = [])
    {
        return $this->respond(['status' => true,'data' => $data,"message"=>$message],$headers);
    }
    /**
     * Function to return a generic response.
     *
     * @param $data Data to be used in response.
     * @param array $headers Headers to b used in response.
     * @return mixed Return the response.
     */
    public function respondSuccessMessage($message,$headers = [])
    {
        return response()->json(['status' => true,"message"=>$message], $this->getStatusCode(), $headers);
    }
    /**
     * Function to return a generic response.
     *
     * @param $data Data to be used in response.
     * @param array $headers Headers to b used in response.
     * @return mixed Return the response.
     */
    public function respondSuccess($headers = [])
    {
        return response()->json(['status' => true], $this->getStatusCode(), $headers);
    }
    /**
     * Function to return an error response.
     *
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'status' => false,
                        'message' => $message,
                
                ]);
    }
    /**
     * @param $message
     * @return mixed
     */
    protected function respondCreated($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)
            ->respond([
                'message' => $message
            ]);
    }
    /**
     * @param $message
     * @return mixed
     */
    protected function respondUnprocessableEntity($message)
    {

        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respond([
                
                'message' => $message
            ]);
    }
    /**
     * @param Paginator $lessons
     * @param $data
     * @return mixed
     */
    protected function respondWithPagination(Paginator $lessons, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $lessons->getTotal(),
                'total_pages' => ceil($lessons->getTotal() / $lessons->getPerPage()),
                'current_page' => $lessons->getCurrentPage(),
                'limit' => $lessons->getPerPage()
            ]
        ]);
        return $this->respond($data);
    }



    /**
     * @param $validator
     * @return mixed
     */
    protected function respondValidationErrors($validator)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respond([
                'validation_errors' => $validator->errors()
            ]);
    }
    protected function respondValidationErrorsStr($validator)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respond([
                'validation_errors' => $validator
            ]);
    }

    public function curlExec($url, $method = 'GET', $data = [])
    {
        if($method != 'GET' && $method != 'POST') {
            return $this->respondWithError('Inappropriate request method "' . $method . '"');
        }

        if(empty($url)) {
            return $this->respondWithError('URL is required.');
        }

        $response = null;
        $url = url('api/' . $url);
        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        $response = json_decode($response, true);

        if(! is_array($response)) {
            return ['error' => 'Internal error.'];
        }

        if(array_key_exists('error', $response)) {
            return $response;
        }
        if(array_key_exists('validation_errors', $response)) {
            return $response; 
        }
        if(array_key_exists('status', $response)) {
            if($response['status'] == 'success')
                return $response;   
            else
                return ['error' => 'Internal error.'];
        }
        if(array_key_exists('data', $response)) {
            return $response;   
        }

        return ['error' => 'Internal error.'];
    }
}
