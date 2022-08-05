<html>

<head>
    <title>Google Maps Mesafe ve Zamanı Döndüren Api Çalışması</title>
    <meta http-equiv="Content-Type" content="text/html ; charset=UTF-8">
    <style type="text/css">
        body {
            background-color: cadetblue;
            color: whitesmoke;
        }
    </style>
</head>

<body>
    <?php
    echo '<h1 style="text-align: center">Google Maps Mesafe ve Zamanı Döndüren Api Çalışması</h1><br><br>';
    echo '
                <form name="Form1" action="" method="POST">
                    Mevcut İli Girin: <input type="text" name="fromProvince" value="">
                    <br><br>
                    Mevcut İlçeyi Girin: <input type="text" name="fromCounty" value="">
                    <br><br>
                    Gidilecek İli Girin: <input type="text" name="toProvince" value="">
                    <br><br>
                    Gidilecek İlçeyi Girin: <input type="text" name="toCounty" value="">
                    <br><br>
                    <input type="submit" name="Gönder" value="Send">
                </form>
            ';
    class main
    {
        public function getDistancesFromLocationsByGoogle($fromProvince, $fromCounty, $toProvince, $toCounty)
        {


            $URL = 'https://maps.googleapis.com/maps/api/distancematrix/json' .
                '?units=metric&language=tr-TR' .
                '&origins=' . $fromProvince . ',' . $fromCounty . '&destinations=' . $toProvince . ',' . $toCounty .
                '&key=' . "your_api_key_enter_here";

            $data = self::curl($URL);
            $distance = (string)$data->rows[0]->elements[0]->distance->text;
            $duration = (string)$data->rows[0]->elements[0]->duration->text;
            return [
                'distance' => $distance,
                'duration' => $duration,
            ];
        }

        private function curl($rawURL)
        {
            $data = null;

            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $rawURL);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                $response = curl_exec($ch);
                $data = json_decode($response);
                curl_close($ch);
            } catch (\Exception $exception) {
            }

            return $data;
        }
    }
    $main1 = new Main();
    if ($_POST) {

        echo '<h3 style="text-align: center">'.$_POST['fromProvince'].'/'.$_POST['fromCounty'].' - '.$_POST['toProvince'].'/'.$_POST['toCounty'].'<br><br>'.
        'Mesafe: '.$main1->getDistancesFromLocationsByGoogle($_POST['fromProvince'], $_POST['fromCounty'], $_POST['toProvince'], $_POST['toCounty'])['distance'].'<br>'.
        'Zaman: '.$main1->getDistancesFromLocationsByGoogle($_POST['fromProvince'], $_POST['fromCounty'], $_POST['toProvince'], $_POST['toCounty'])['duration'].'<br>'.'</h3>';
    }

    ?>
</body>

</html>