<?php

namespace Redmix0901\GoogleToken;

use Redmix0901\GoogleToken\Contracts\GoogleClientInterface;
use InvalidArgumentException;
use Google_Client;

class GoogleClientService implements GoogleClientInterface
{
    protected $google_client = null;

    protected $options = [];

    public function __construct($name)
    {
        $options = config('google-token.' . $name);

        if (empty($options)) {
            throw new InvalidArgumentException('Bạn chưa cung cấp config cho: ' . $this->scope);
        }

        if (empty($options['client_path'] ?? null)) {
            throw new InvalidArgumentException('Config thiếu: "client_path"');
        }
        
        if (!file_exists($options['client_path'] ?? null)) {
            throw new InvalidArgumentException('Vui lòng kiểm tra đường dẫn "client_path" tương ứng với token: ' . $this->scope);
        }

        if (empty($options['token_path'] ?? null)) {
            throw new InvalidArgumentException('Config thiếu: "token_path"');
        }

        if (empty($options['scopes'] ?? null)) {
            throw new InvalidArgumentException('Config thiếu: "scopes"');
        }

        $this->options = $options;
    }

    public function getClient()
    {
        if (!empty($this->google_client)) {
            return $this->google_client;
        }

        $google_client = new Google_Client;
        $google_client->setApplicationName('Laravel Get Token');
        $google_client->setAuthConfig($this->getOptionsConfig('client_path'));
        $google_client->setScopes($this->getOptionsConfig('scopes'));
        $google_client->setAccessType('offline');

        if (file_exists($this->getOptionsConfig('token_path'))) {
            $accessToken = json_decode(file_get_contents($this->getOptionsConfig('token_path')), true);
            $google_client->setAccessToken($accessToken);
    
            // nếu token hết hạn sẽ tiến hành refresh lại token để sử dụng
            if ($google_client->isAccessTokenExpired()) {
                $google_client->fetchAccessTokenWithRefreshToken($google_client->getRefreshToken());
                file_put_contents($this->getOptionsConfig('token_path'), json_encode($google_client->getAccessToken()));
            }
        }       

        return $this->google_client = $google_client;
    }

    public function getOptionsConfig($key = null)
    {        
        return empty($key) ? $this->options : $this->options[$key] ?? null;
    }
}
