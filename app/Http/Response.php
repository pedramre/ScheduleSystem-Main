<?php


namespace App\Http;


class Response
{
    private $success = true;
    private $data = [];
    private $message = '';
    private $status = 200;

    public function setSuccess(bool $value): Response
    {
        $this->success = $value;
        return $this;
    }

    public function setData(array $value): Response
    {
        $this->data = $value;
        return $this;
    }

    public function setMessage(string $value): Response
    {
        $this->message = $value;
        return $this;
    }

    public function setStatus(int $value): Response
    {
        $this->status = $value;
        return $this;
    }

    public function send(){
        $response = [
            'success' => $this->success,
            'data' => $this->data,
            'message' => $this->message
        ];
        return response()->json($response, $this->status);
    }
}
