<?php
// Coded By Kerem Demir
// Would Hack
// 1 3 3 7
// Telegram : @wouldhack

class WouldhackAPI {
    private $authKey;
    private $startTime;

    public function __construct($authKey) {
        $this->authKey = $authKey;
        $this->startTime = microtime(true);

        ini_set("display_errors", 0);
        error_reporting(0);
    }

    public function execute() {
        header('Content-Type: application/json; charset=utf-8');

        if ($_GET['auth'] != $this->authKey) {
            $this->respondWithError("Auth eksik veya yanlış");
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $domain = htmlspecialchars($_GET["domain"]);

                if (!empty($domain)) {
                    $usomData = $this->fetchUSOMData($domain);

                    if ($usomData === false) {
                        $this->respondWithError("USOM API'ye istek yapılırken bir hata oluştu.");
                    }

                    if ($usomData['totalCount'] > 0) {
                        $result = $usomData['models'][0];
                        $url = $result['url'];
                        $criticality_level = $result['criticality_level'];
                        $connection_type = $result['connectiontype'];
                        $source = $result['source'];
                        $source_name = ($source == "US") ? "usom" : (($source == "IH") ? "ihbar" : $source);
                        
                        $date = $result['date'];
                        $formatted_date = date('Y/m/d H:i:s', strtotime(str_replace(array('T', '-'), array(' ', '/'), explode('.', $date)[0])));
                        
                        $connection_type_label = ($connection_type == "PH") ? "Oltalama" : $connection_type;
                        
                        $responseData = array(
                            "URL" => $url,
                            "Kritiklik Seviyesi" => $criticality_level,
                            "Bağlantı Türü" => $connection_type_label,
                            "Kaynak" => $source_name,
                            "Tarih" => $formatted_date
                        );

                        $this->respondWithSuccess(1, $responseData, 0);
                    } else {
                        $this->respondWithError("URL bulunamadı");
                    }
                } else {
                    $this->respondWithError("Parametre hatası");
                }
            } else {
                $this->respondWithError("Geçersiz istek yöntemi");
            }
        }
    }

    private function fetchUSOMData($domain) {
        $url = "https://www.usom.gov.tr/api/address/index";
        $params = array(
            "q" => $domain,
            "type" => "domain"
        );

        $headers = array(
            "accept" => "application/json"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 200) {
            $data = json_decode($response, true);
            return $data;
        } else {
            return false;
        }

        curl_close($ch);
    }

    private function respondWithSuccess($count, $data, $elapsedTime) {
        echo json_encode([
            "message" => "Wouldhack API Servisi",
            "Developer" => "@keremdemirsec",
            "status" => "Success",
            "count" => $count,
            "data" => $data,
            "elapsed_time" => sprintf('%.2f', $elapsedTime) . ' ms'
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        die();
    }

    private function respondWithError($message) {
        echo json_encode([
            "message" => "Wouldhack API Servisi",
            "Developer" => "@keremdemirsec",
            "status" => "Error",
            "error_message" => $message
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        die();
    }
}

$api = new WouldhackAPI("yinemi");
$api->execute();

?>
