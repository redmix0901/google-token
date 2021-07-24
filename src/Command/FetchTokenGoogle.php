<?php

namespace Redmix0901\GoogleToken\Command;

use Illuminate\Console\Command;
use Redmix0901\GoogleToken\Facades\Goten;

class FetchTokenGoogle extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'goten:get-token {name=googletoken : The name token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Token Google';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $google_service = Goten::use($this->argument('name'));
        $credentialsPath = $google_service->getOptionsConfig('token_path');

        if (file_exists($credentialsPath)
            && !$this->confirm('Token đã sẵn sàng để sử dụng! Bạn có muốn lấy lại token không?')
        ) {
            return $this->info('Token cũ vẫn được giữ!');
        }

        $this->info('Mở liên kết sau trong trình duyệt của bạn:');
        $this->comment($google_service->getClient()->createAuthUrl());
        $authCode = trim($this->ask('Nhập mã xác nhận'));

        $accessToken = $google_service->getClient()->fetchAccessTokenWithAuthCode($authCode);

        if (array_key_exists('error', $accessToken)) {
            throw new \Exception(join(', ', $accessToken));
        }

        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0777, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        $this->info("Credentials saved to {$credentialsPath}!", $credentialsPath);

        return 0;
    }
}
